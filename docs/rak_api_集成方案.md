# Rak API 集成详细方案

## 📋 目录
1. [集成概述](#集成概述)
2. [架构设计](#架构设计)
3. [文件结构](#文件结构)
4. [实现步骤](#实现步骤)
5. [数据库设计](#数据库设计)
6. [API 客户端实现](#api-客户端实现)
7. [订单处理流程](#订单处理流程)
8. [后台管理界面](#后台管理界面)
9. [测试方案](#测试方案)

---

## 集成概述

### 目标
将 Rak API 集成到独角数卡系统中，实现：
- 自动获取 Rak 云产品列表
- 用户购买 Rak 云服务器商品时自动调用 API 下单
- 订单完成后自动发货（返回服务器信息）

### 集成方式
Rak API 作为**商品自动发货**的扩展功能，而非支付网关。当用户购买 Rak 云服务器商品时：
1. 用户选择商品并完成支付
2. 系统调用 Rak API 创建订单
3. 获取服务器信息并自动发货给用户

---

## 架构设计

### 系统架构图
```
用户购买流程
    ↓
订单创建（OrderProcessService）
    ↓
订单支付完成（OrderProcessService@completedOrder）
    ↓
触发 Rak 自动发货（RakOrderService）
    ↓
调用 Rak API 下单（RakApiClient）
    ↓
获取服务器信息
    ↓
更新订单信息（卡密/服务器信息）
    ↓
发送给用户
```

### 核心组件

1. **RakApiClient** - Rak API 客户端服务类
2. **RakOrderService** - Rak 订单处理服务
3. **RakProductService** - Rak 产品管理服务
4. **RakController** - 后台管理控制器（可选）

---

## 文件结构

```
app/
├── Service/
│   ├── RakApiClient.php          # Rak API 客户端
│   ├── RakOrderService.php       # Rak 订单处理服务
│   └── RakProductService.php     # Rak 产品管理服务
├── Models/
│   └── RakProduct.php            # Rak 产品模型（可选）
├── Jobs/
│   └── RakOrderProcess.php       # Rak 订单处理队列任务
├── Admin/
│   └── Controllers/
│       └── RakProductController.php  # 后台管理（可选）
└── Http/
    └── Controllers/
        └── Api/
            └── RakController.php    # API 接口（可选）

config/
└── rak.php                        # Rak API 配置文件

database/
└── migrations/
    └── xxxx_create_rak_products_table.php  # 数据库迁移（可选）
```

---

## 实现步骤

### 第一步：创建配置文件

**文件**: `config/rak.php`

```php
<?php

return [
    // API 基础配置
    'api_base_url' => env('RAK_API_BASE_URL', 'https://rak-api.raksmart.com/rakapi/v1/'),
    'api_key' => env('RAK_API_KEY', ''),
    
    // 默认配置
    'default_region' => env('RAK_DEFAULT_REGION', 'sv'),
    'default_type' => env('RAK_DEFAULT_TYPE', 'instance'),
    
    // 请求超时设置
    'timeout' => env('RAK_API_TIMEOUT', 30),
];
```

### 第二步：创建 Rak API 客户端

**文件**: `app/Service/RakApiClient.php`

### 第三步：创建 Rak 订单处理服务

**文件**: `app/Service/RakOrderService.php`

### 第四步：集成到订单处理流程

修改 `OrderProcessService`，在订单完成时检查是否为 Rak 商品，如果是则调用 Rak API。

### 第五步：创建后台管理界面（可选）

用于管理 Rak 产品配置。

---

## 数据库设计

### 方案一：扩展 Goods 表（推荐）

在 `goods` 表中添加字段：
- `rak_product_id` - Rak 产品 ID
- `rak_config_options` - Rak 配置选项（JSON）
- `rak_billing_cycle` - Rak 计费周期

### 方案二：新建 rak_products 表（可选）

如果需要独立管理 Rak 产品：

```sql
CREATE TABLE `rak_products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `goods_id` int(11) NOT NULL COMMENT '关联商品ID',
  `rak_product_id` varchar(100) NOT NULL COMMENT 'Rak产品ID',
  `rak_region` varchar(50) NOT NULL COMMENT 'Rak地区',
  `rak_type` varchar(50) NOT NULL COMMENT 'Rak产品类型',
  `config_options` text COMMENT '配置选项JSON',
  `billing_cycle` varchar(50) NOT NULL DEFAULT 'Monthly' COMMENT '计费周期',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_goods_id` (`goods_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

---

## API 客户端实现

### RakApiClient.php 完整代码

```php
<?php

namespace App\Service;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;

class RakApiClient
{
    private $client;
    private $apiKey;
    private $baseUrl;
    private $timeout;

    public function __construct()
    {
        $this->baseUrl = config('rak.api_base_url');
        $this->apiKey = config('rak.api_key');
        $this->timeout = config('rak.timeout', 30);
        
        $this->client = new Client([
            'base_uri' => $this->baseUrl,
            'timeout' => $this->timeout,
            'headers' => [
                'X-API-Key' => $this->apiKey,
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ],
        ]);
    }

    /**
     * 获取可用地区
     *
     * @param string $type 产品类型 (instance|metal|disk|eip)
     * @param int $offset 偏移量
     * @param int $limit 限制数量
     * @return array|null
     */
    public function getRegions(string $type = 'instance', int $offset = 0, int $limit = 10): ?array
    {
        try {
            $response = $this->client->get('regions', [
                'query' => [
                    'type' => $type,
                    'offset' => $offset,
                    'limit' => $limit,
                ],
            ]);
            
            $body = json_decode($response->getBody()->getContents(), true);
            return $body['regions'] ?? null;
        } catch (GuzzleException $e) {
            Log::error('Rak API 获取地区失败: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * 获取云产品列表
     *
     * @param string $type 产品类型
     * @param string|null $region 地区
     * @param string|null $productName 产品名称（模糊搜索）
     * @param int $offset 偏移量
     * @param int $limit 限制数量
     * @param int $sampleOptionsShowFixed 是否显示固定配置项
     * @return array|null
     */
    public function getPlans(
        string $type = 'instance',
        ?string $region = null,
        ?string $productName = null,
        int $offset = 0,
        int $limit = 10,
        int $sampleOptionsShowFixed = 0
    ): ?array {
        try {
            $query = [
                'type' => $type,
                'offset' => $offset,
                'limit' => $limit,
                'sample_options_show_fixed' => $sampleOptionsShowFixed,
            ];
            
            if ($region) {
                $query['region'] = $region;
            }
            
            if ($productName) {
                $query['product_name'] = $productName;
            }
            
            $response = $this->client->get('plans', [
                'query' => $query,
            ]);
            
            $body = json_decode($response->getBody()->getContents(), true);
            return $body['productSamples'] ?? null;
        } catch (GuzzleException $e) {
            Log::error('Rak API 获取产品列表失败: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * 获取产品价格
     *
     * @param string $sampleId 产品ID
     * @param array $configOptionsData 配置选项数据
     * @param string $billingCycle 计费周期 (Monthly|Quarterly|SemiAnnually|Annually)
     * @param int $quantity 数量
     * @return array|null
     */
    public function getPrice(
        string $sampleId,
        array $configOptionsData,
        string $billingCycle = 'Monthly',
        int $quantity = 1
    ): ?array {
        try {
            $response = $this->client->post('price', [
                'json' => [
                    'sample_id' => $sampleId,
                    'configoptions_data' => $configOptionsData,
                    'billingcycle' => $billingCycle,
                    'quantity' => $quantity,
                ],
            ]);
            
            $body = json_decode($response->getBody()->getContents(), true);
            return $body;
        } catch (GuzzleException $e) {
            Log::error('Rak API 获取价格失败: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * 创建订单
     *
     * @param string $sampleId 产品ID
     * @param array $configOptionsData 配置选项数据
     * @param string $billingCycle 计费周期
     * @param int $quantity 数量
     * @param array|null $discountIds 优惠券ID数组
     * @return array|null
     */
    public function createOrder(
        string $sampleId,
        array $configOptionsData,
        string $billingCycle = 'Monthly',
        int $quantity = 1,
        ?array $discountIds = null
    ): ?array {
        try {
            $payload = [
                'sample_id' => $sampleId,
                'configoptions_data' => $configOptionsData,
                'billingcycle' => $billingCycle,
                'quantity' => $quantity,
            ];
            
            if ($discountIds) {
                $payload['discount_ids'] = $discountIds;
            }
            
            $response = $this->client->post('order', [
                'json' => $payload,
            ]);
            
            $body = json_decode($response->getBody()->getContents(), true);
            return $body;
        } catch (GuzzleException $e) {
            Log::error('Rak API 创建订单失败: ' . $e->getMessage());
            return null;
        }
    }
}
```

---

## 订单处理流程

### RakOrderService.php 完整代码

```php
<?php

namespace App\Service;

use App\Models\Order;
use App\Service\RakApiClient;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class RakOrderService
{
    private $rakApiClient;

    public function __construct()
    {
        $this->rakApiClient = new RakApiClient();
    }

    /**
     * 处理 Rak 订单
     *
     * @param Order $order 订单对象
     * @return bool
     */
    public function processOrder(Order $order): bool
    {
        try {
            // 检查订单是否关联 Rak 商品
            if (!$this->isRakProduct($order)) {
                return false;
            }

            // 从订单信息中获取 Rak 配置
            $rakConfig = $this->getRakConfigFromOrder($order);
            if (!$rakConfig) {
                Log::error('Rak 订单配置缺失', ['order_sn' => $order->order_sn]);
                return false;
            }

            // 调用 Rak API 创建订单
            $rakOrderResult = $this->rakApiClient->createOrder(
                $rakConfig['sample_id'],
                $rakConfig['config_options_data'],
                $rakConfig['billing_cycle'],
                $order->buy_amount,
                $rakConfig['discount_ids'] ?? null
            );

            if (!$rakOrderResult) {
                Log::error('Rak API 创建订单失败', ['order_sn' => $order->order_sn]);
                return false;
            }

            // 处理订单结果
            $this->handleOrderResult($order, $rakOrderResult);

            return true;
        } catch (\Exception $e) {
            Log::error('Rak 订单处理异常: ' . $e->getMessage(), [
                'order_sn' => $order->order_sn,
                'trace' => $e->getTraceAsString(),
            ]);
            return false;
        }
    }

    /**
     * 检查订单是否为 Rak 商品
     *
     * @param Order $order
     * @return bool
     */
    private function isRakProduct(Order $order): bool
    {
        // 方式1：通过商品ID判断（需要在商品表中添加标识）
        // 方式2：通过商品名称关键词判断
        // 方式3：通过订单备注字段判断
        
        // 这里使用方式2作为示例
        $goods = $order->goods;
        if (!$goods) {
            return false;
        }
        
        // 检查商品名称或描述中是否包含 Rak 关键词
        $rakKeywords = ['rak', 'raksmart', '云服务器', '云机'];
        $goodsName = strtolower($goods->gd_name . ' ' . $goods->gd_description);
        
        foreach ($rakKeywords as $keyword) {
            if (strpos($goodsName, strtolower($keyword)) !== false) {
                return true;
            }
        }
        
        return false;
    }

    /**
     * 从订单中获取 Rak 配置
     *
     * @param Order $order
     * @return array|null
     */
    private function getRakConfigFromOrder(Order $order): ?array
    {
        // 方式1：从订单的 other_input 字段解析（JSON格式）
        // 方式2：从商品的自定义字段获取
        // 方式3：从订单备注中解析
        
        // 这里使用方式1作为示例
        if (empty($order->other_input)) {
            return null;
        }
        
        $config = json_decode($order->other_input, true);
        if (!$config || !isset($config['rak'])) {
            return null;
        }
        
        return $config['rak'];
    }

    /**
     * 处理订单结果
     *
     * @param Order $order
     * @param array $rakOrderResult
     * @return void
     */
    private function handleOrderResult(Order $order, array $rakOrderResult): void
    {
        DB::beginTransaction();
        try {
            // 提取服务器信息
            $serviceIds = $rakOrderResult['order_result']['serviceids'] ?? '';
            $invoiceId = $rakOrderResult['pay_result']['data']['invoiceid'] ?? '';
            $amount = $rakOrderResult['pay_result']['data']['amount'] ?? 0;
            
            // 构建发货信息
            $deliveryInfo = [
                'service_ids' => $serviceIds,
                'invoice_id' => $invoiceId,
                'amount' => $amount,
                'order_time' => now()->toDateTimeString(),
            ];
            
            // 更新订单信息
            $order->info = json_encode($deliveryInfo, JSON_UNESCAPED_UNICODE);
            $order->save();
            
            DB::commit();
            
            Log::info('Rak 订单处理成功', [
                'order_sn' => $order->order_sn,
                'service_ids' => $serviceIds,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
```

---

## 集成到订单处理流程

### 修改 OrderProcessService

在 `app/Service/OrderProcessService.php` 的 `completedOrder` 方法中添加：

```php
// 在订单完成后，检查是否为 Rak 商品
if ($this->isRakProduct($order)) {
    // 异步处理 Rak 订单
    RakOrderProcess::dispatch($order->order_sn)->delay(now()->addSeconds(5));
}
```

### 创建队列任务

**文件**: `app/Jobs/RakOrderProcess.php`

```php
<?php

namespace App\Jobs;

use App\Models\Order;
use App\Service\RakOrderService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class RakOrderProcess implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3;
    public $timeout = 60;

    private $orderSN;

    public function __construct(string $orderSN)
    {
        $this->orderSN = $orderSN;
    }

    public function handle()
    {
        $order = Order::where('order_sn', $this->orderSN)->first();
        if (!$order) {
            Log::error('Rak 订单处理失败：订单不存在', ['order_sn' => $this->orderSN]);
            return;
        }

        $rakOrderService = new RakOrderService();
        $rakOrderService->processOrder($order);
    }
}
```

---

## 后台管理界面（可选）

### 创建后台控制器

**文件**: `app/Admin/Controllers/RakProductController.php`

用于：
- 同步 Rak 产品列表
- 配置商品与 Rak 产品的关联
- 查看订单处理状态

---

## 商品配置方式

### 方式一：通过商品自定义字段

在商品创建/编辑时，添加 Rak 配置字段：
- Rak 产品 ID
- Rak 地区
- Rak 配置选项（JSON）
- Rak 计费周期

### 方式二：通过订单其他输入字段

在用户下单时，通过 `other_input` 字段传递 Rak 配置。

---

## 测试方案

### 1. 单元测试
- 测试 RakApiClient 各个方法
- 测试 RakOrderService 订单处理逻辑

### 2. 集成测试
- 测试完整下单流程
- 测试错误处理

### 3. 生产测试
- 创建测试商品
- 完成测试订单
- 验证服务器信息是否正确返回

---

## 配置说明

### 环境变量配置

在 `.env` 文件中添加：

```env
RAK_API_BASE_URL=https://rak-api.raksmart.com/rakapi/v1/
RAK_API_KEY=your_api_key_here
RAK_DEFAULT_REGION=sv
RAK_DEFAULT_TYPE=instance
RAK_API_TIMEOUT=30
```

### 后台配置

在后台系统设置中添加 Rak API 配置项，或创建独立的 Rak 产品管理页面。

---

## 注意事项

1. **API Key 安全**：确保 API Key 安全存储，不要泄露
2. **错误处理**：完善的错误处理和日志记录
3. **队列处理**：使用队列异步处理，避免阻塞
4. **重试机制**：订单处理失败时自动重试
5. **价格同步**：定期同步 Rak 产品价格，确保商品价格准确

---

## 后续扩展

1. **产品同步**：定期同步 Rak 产品列表到系统
2. **价格监控**：监控价格变化并通知
3. **库存管理**：同步库存信息
4. **订单查询**：查询 Rak 订单状态
5. **服务器管理**：管理已购买的服务器

