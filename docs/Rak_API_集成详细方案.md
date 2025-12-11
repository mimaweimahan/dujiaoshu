# Rak API 集成详细方案

## 📋 目录

1. [集成概述](#集成概述)
2. [系统架构](#系统架构)
3. [环境配置](#环境配置)
4. [核心组件说明](#核心组件说明)
5. [集成步骤](#集成步骤)
6. [商品配置方式](#商品配置方式)
7. [订单处理流程](#订单处理流程)
8. [Telegram Bot 集成](#telegram-bot-集成)
9. [API 使用示例](#api-使用示例)
10. [错误处理与日志](#错误处理与日志)
11. [测试验证](#测试验证)
12. [常见问题](#常见问题)
13. [后续扩展](#后续扩展)

---

## 集成概述

### 目标

将 Rak API 集成到独角数卡系统中，实现：
- ✅ 自动获取 Rak 云产品列表（云服务器、独服、磁盘、EIP）
- ✅ 用户购买 Rak 云服务器商品时自动调用 API 下单
- ✅ 订单完成后自动发货（返回服务器信息给用户）
- ✅ 支持多种计费周期（月付、季付、半年付、年付）
- ✅ 支持优惠券自动应用

### 集成方式

Rak API 作为**商品自动发货**的扩展功能，而非支付网关。

**工作流程**：
```
用户选择商品 → 完成支付 → 订单状态更新为已完成 
    ↓
系统检测是否为 Rak 商品
    ↓
调用 Rak API 创建订单
    ↓
获取服务器信息（serviceids）
    ↓
更新订单信息，自动发货给用户
```

### 已实现功能

✅ **RakApiClient** - Rak API 客户端服务类（已完成）
✅ **RakOrderService** - Rak 订单处理服务（已完成）
✅ **RakOrderProcess** - Rak 订单处理队列任务（已完成）
✅ **配置文件** - `config/rak.php`（已完成）
✅ **订单流程集成** - 已集成到 `OrderProcessService`（已完成）

---

## 系统架构

### 架构图

```
┌─────────────────────────────────────────────────────────────┐
│                      用户购买流程                              │
└─────────────────────────────────────────────────────────────┘
                            ↓
┌─────────────────────────────────────────────────────────────┐
│              OrderProcessService@completedOrder              │
│                 订单支付完成处理                               │
└─────────────────────────────────────────────────────────────┘
                            ↓
┌─────────────────────────────────────────────────────────────┐
│              检查是否为 Rak 商品                              │
│          RakOrderService@isRakProduct()                      │
└─────────────────────────────────────────────────────────────┘
                            ↓
┌─────────────────────────────────────────────────────────────┐
│              异步队列任务（延迟5秒）                          │
│              RakOrderProcess::dispatch()                     │
└─────────────────────────────────────────────────────────────┘
                            ↓
┌─────────────────────────────────────────────────────────────┐
│              RakOrderService@processOrder()                  │
│              处理 Rak 订单                                    │
└─────────────────────────────────────────────────────────────┘
                            ↓
┌─────────────────────────────────────────────────────────────┐
│              RakApiClient@createOrder()                     │
│              调用 Rak API 创建订单                            │
└─────────────────────────────────────────────────────────────┘
                            ↓
┌─────────────────────────────────────────────────────────────┐
│              获取服务器信息                                   │
│          serviceids, invoiceid, amount                       │
└─────────────────────────────────────────────────────────────┘
                            ↓
┌─────────────────────────────────────────────────────────────┐
│              更新订单信息                                     │
│          将服务器信息保存到订单 info 字段                      │
└─────────────────────────────────────────────────────────────┘
```

### 核心组件

| 组件 | 文件路径 | 功能说明 |
|------|---------|---------|
| **RakApiClient** | `app/Service/RakApiClient.php` | Rak API 客户端，封装所有 API 调用 |
| **RakOrderService** | `app/Service/RakOrderService.php` | Rak 订单处理服务，处理订单逻辑 |
| **RakOrderProcess** | `app/Jobs/RakOrderProcess.php` | 队列任务，异步处理订单 |
| **配置文件** | `config/rak.php` | Rak API 配置 |

---

## 环境配置

### 第一步：配置环境变量

在项目根目录的 `.env` 文件中添加以下配置：

```env
# Rak API 配置
RAK_API_BASE_URL=https://rak-api.raksmart.com/rakapi/v1/
RAK_API_KEY=your_api_key_here
RAK_DEFAULT_REGION=sv
RAK_DEFAULT_TYPE=instance
RAK_API_TIMEOUT=30
RAK_ENABLED=true
```

### 配置项说明

| 配置项 | 说明 | 必填 | 默认值 | 示例 |
|--------|------|------|--------|------|
| `RAK_API_BASE_URL` | Rak API 基础 URL | 是 | `https://rak-api.raksmart.com/rakapi/v1/` | - |
| `RAK_API_KEY` | Rak API Key（从 RakSmart 获取） | 是 | - | `rak_xxxxxxxxxxxxx` |
| `RAK_DEFAULT_REGION` | 默认地区 | 否 | `sv` | `sv`, `hk`, `tky` |
| `RAK_DEFAULT_TYPE` | 默认产品类型 | 否 | `instance` | `instance`, `metal`, `disk`, `eip` |
| `RAK_API_TIMEOUT` | API 请求超时时间（秒） | 否 | `30` | `30` |
| `RAK_ENABLED` | 是否启用 Rak 功能 | 否 | `false` | `true`, `false` |

### 第二步：验证配置

配置文件位于 `config/rak.php`，已自动读取 `.env` 中的配置。

---

## 核心组件说明

### 1. RakApiClient（API 客户端）

**文件路径**: `app/Service/RakApiClient.php`

**主要方法**：

#### 1.1 获取可用地区

```php
/**
 * 获取可用地区
 *
 * @param string $type 产品类型 (instance|metal|disk|eip)
 * @param int $offset 偏移量
 * @param int $limit 限制数量
 * @return array|null
 */
public function getRegions(string $type = 'instance', int $offset = 0, int $limit = 10): ?array
```

**使用示例**：
```php
$rakClient = new \App\Service\RakApiClient();
$regions = $rakClient->getRegions('instance');
// 返回: [{"continent": "americas", "region": "sv"}, ...]
```

#### 1.2 获取云产品列表

```php
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
): ?array
```

**使用示例**：
```php
$rakClient = new \App\Service\RakApiClient();
$plans = $rakClient->getPlans('instance', 'sv', null, 0, 10, 0);
// 返回产品列表，包含配置选项
```

#### 1.3 获取产品价格

```php
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
): ?array
```

**使用示例**：
```php
$rakClient = new \App\Service\RakApiClient();
$price = $rakClient->getPrice(
    'psam_01J8HEQ29HECJ88NHCMXDR33ZH',
    [
        '7778' => 91584,  // CPU: 2核心
        '7777' => 91573,  // Memory: 2G
        '7862' => 10      // Data Disk: 10G
    ],
    'Monthly',
    1
);
// 返回: {"first_payment_amount": "18.22", "recurring_amount": "23.22", ...}
```

#### 1.4 创建订单

```php
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
): ?array
```

**使用示例**：
```php
$rakClient = new \App\Service\RakApiClient();
$result = $rakClient->createOrder(
    'psam_01J8HEQ29HECJ88NHCMXDR33ZH',
    [
        '7778' => 91584,
        '7777' => 91573,
        '7862' => 10
    ],
    'Monthly',
    1,
    ['disc_01JM9MQ0AJSSC799X0VFHNEPXP']  // 可选：优惠券ID
);
// 返回: {"pay_result": {...}, "order_result": {"serviceids": "280985"}}
```

### 2. RakOrderService（订单处理服务）

**文件路径**: `app/Service/RakOrderService.php`

**主要方法**：

#### 2.1 处理订单

```php
/**
 * 处理 Rak 订单
 *
 * @param Order $order 订单对象
 * @return bool
 */
public function processOrder(Order $order): bool
```

**处理流程**：
1. 检查是否启用 Rak 功能
2. 检查订单是否为 Rak 商品
3. 从订单中获取 Rak 配置
4. 调用 Rak API 创建订单
5. 处理订单结果，更新订单信息

#### 2.2 检查是否为 Rak 商品

```php
/**
 * 检查订单是否为 Rak 商品（公共方法）
 *
 * @param Order $order
 * @return bool
 */
public function isRakProduct(Order $order): bool
```

**判断逻辑**：
1. 检查商品名称或描述中是否包含 Rak 关键词（`rak`, `raksmart`, `云服务器`, `云机`）
2. 检查订单的 `other_input` 字段中是否包含 `rak` 配置
3. 检查订单的 `info` 字段中是否包含 `rak` 配置

### 3. RakOrderProcess（队列任务）

**文件路径**: `app/Jobs/RakOrderProcess.php`

**功能**：
- 异步处理 Rak 订单，避免阻塞主流程
- 支持自动重试（最多3次）
- 超时时间：60秒

---

## 集成步骤

### 步骤一：环境配置（已完成）

✅ 配置文件已创建：`config/rak.php`
✅ 环境变量配置说明已提供

### 步骤二：核心组件（已完成）

✅ `RakApiClient.php` - API 客户端已实现
✅ `RakOrderService.php` - 订单处理服务已实现
✅ `RakOrderProcess.php` - 队列任务已实现

### 步骤三：订单流程集成（已完成）

✅ 已集成到 `OrderProcessService@completedOrder` 方法中

**集成代码位置**：`app/Service/OrderProcessService.php` 第 592-604 行

```php
// Rak 订单处理（如果是 Rak 商品，异步处理）
if ($order->goods_id && $order->goods_id > 0) {
    try {
        $rakOrderService = app('App\Service\RakOrderService');
        if ($rakOrderService && $rakOrderService->isRakProduct($order) && config('rak.enabled', false)) {
            // 异步处理 Rak 订单，延迟5秒确保订单状态已更新
            RakOrderProcess::dispatch($order->order_sn)->delay(now()->addSeconds(5));
        }
    } catch (\Exception $e) {
        // Rak 订单处理失败不影响主流程
        Log::warning('Rak 订单处理触发失败: ' . $e->getMessage());
    }
}
```

### 步骤四：配置队列（需要确认）

确保 Laravel 队列已配置并运行：

```bash
# 启动队列处理器
php artisan queue:work

# 或使用 Supervisor 管理（推荐生产环境）
```

---

## 商品配置方式

### 方式一：通过订单 other_input 字段（推荐）

在用户下单时，通过前端表单收集 Rak 配置信息，并存储在订单的 `other_input` 字段中。

#### 配置格式

```json
{
  "rak": {
    "sample_id": "psam_01J8HEQ29HECJ88NHCMXDR33ZH",
    "config_options_data": {
      "7778": 91584,
      "7777": 91573,
      "7862": 10
    },
    "billing_cycle": "Monthly",
    "discount_ids": ["disc_01JM9MQ0AJSSC799X0VFHNEPXP"]
  }
}
```

#### 字段说明

| 字段 | 说明 | 必填 | 示例 |
|------|------|------|------|
| `sample_id` | Rak 产品 ID | 是 | `psam_01J8HEQ29HECJ88NHCMXDR33ZH` |
| `config_options_data` | 配置选项数据 | 是 | `{"7778": 91584, "7777": 91573}` |
| `billing_cycle` | 计费周期 | 否 | `Monthly`（默认） |
| `discount_ids` | 优惠券 ID 数组 | 否 | `["disc_xxx"]` |

#### 配置选项数据说明

- **普通配置项**（type≠4）：`{"configoption_id": sub_option_id}`
  - 例如：`{"7778": 91584}` 表示选择 CPU 2核心
- **数值型配置项**（type=4，如数据盘）：`{"configoption_id": 数值}`
  - 例如：`{"7862": 10}` 表示数据盘 10G

#### 计费周期可选值

- `Monthly` - 每月
- `Quarterly` - 季度
- `SemiAnnually` - 半年
- `Annually` - 每年

### 方式二：通过商品名称关键词（自动识别）

系统会自动识别商品名称或描述中包含以下关键词的商品：
- `rak`
- `raksmart`
- `云服务器`
- `云机`

**注意**：这种方式不需要额外配置，但需要在商品名称或描述中包含关键词。

### 方式三：通过订单 info 字段

如果订单的 `info` 字段包含 JSON 格式的 Rak 配置，也会被识别：

```json
{
  "rak": {
    "sample_id": "psam_01J8HEQ29HECJ88NHCMXDR33ZH",
    "config_options_data": {
      "7778": 91584,
      "7777": 91573,
      "7862": 10
    },
    "billing_cycle": "Monthly"
  }
}
```

---

## 订单处理流程

### 完整流程说明

1. **用户下单**
   - 用户选择商品并完成支付
   - 订单状态更新为 `STATUS_COMPLETED`（已完成）

2. **订单完成处理**
   - `OrderProcessService@completedOrder` 方法被调用
   - 检查订单是否关联商品（`goods_id > 0`）

3. **Rak 商品检测**
   - 调用 `RakOrderService@isRakProduct()` 检查是否为 Rak 商品
   - 检查是否启用 Rak 功能（`config('rak.enabled')`）

4. **异步队列处理**
   - 如果检测到是 Rak 商品，创建 `RakOrderProcess` 队列任务
   - 延迟5秒执行，确保订单状态已更新

5. **Rak 订单处理**
   - `RakOrderProcess` 队列任务执行
   - 调用 `RakOrderService@processOrder()` 处理订单

6. **获取 Rak 配置**
   - 从订单的 `other_input` 或 `info` 字段中解析 Rak 配置
   - 验证必要参数（`sample_id`, `config_options_data`）

7. **调用 Rak API**
   - 调用 `RakApiClient@createOrder()` 创建 Rak 订单
   - 传递产品 ID、配置选项、计费周期等参数

8. **处理订单结果**
   - 从 API 响应中提取服务器信息：
     - `serviceids` - 服务器 ID
     - `invoiceid` - 发票 ID
     - `amount` - 订单金额
     - `invoicepaid` - 是否已支付
   - 将服务器信息保存到订单的 `info` 字段
   - 用户可以在订单详情中查看服务器信息

### 流程图

```
用户支付完成
    ↓
OrderProcessService@completedOrder
    ↓
检查 goods_id > 0
    ↓
RakOrderService@isRakProduct()
    ↓
是 Rak 商品？
    ├─ 否 → 结束
    └─ 是 → 检查是否启用 Rak
            ↓
        启用？
        ├─ 否 → 结束
        └─ 是 → 创建队列任务（延迟5秒）
                ↓
            RakOrderProcess::dispatch()
                ↓
            RakOrderService@processOrder()
                ↓
            从订单获取 Rak 配置
                ↓
            RakApiClient@createOrder()
                ↓
            获取服务器信息
                ↓
            更新订单 info 字段
                ↓
            完成
```

---

## Telegram Bot 集成

### 概述

Telegram Bot 是系统的重要功能模块，用户可以通过 Telegram 机器人购买商品。为了支持 Rak API 集成，需要在 Telegram Bot 的订单创建流程中传递 Rak 配置信息。

### 当前实现状态

✅ **已实现**：
- Telegram Bot 订单创建流程
- 订单支付完成后的 Rak 自动处理（已集成到 `OrderProcessService`）
- Rak 商品自动识别（通过商品名称关键词）

⚠️ **需要完善**：
- Telegram Bot 中传递 Rak 配置到订单的 `other_input` 字段
- 在商品详情页面显示 Rak 配置选项（如地区、CPU、内存等）
- 用户选择 Rak 配置的交互流程

### Telegram Bot 订单流程

```
用户通过 Telegram Bot 购买商品
    ↓
ButtonUtil@goodsinfo() - 显示商品详情
    ↓
用户点击"购买"按钮
    ↓
ButtonUtil@goodsbuy() - 设置购买状态
    ↓
用户输入购买数量
    ↓
ButtonUtil@confirmorder() - 创建订单
    ├── 设置商品信息
    ├── 设置购买数量
    ├── 设置支付方式
    └── 创建订单（OrderProcessService@createOrder）
    ↓
订单创建完成
    ↓
ButtonUtil@gopay() - 处理支付
    ↓
订单支付完成
    ↓
OrderProcessService@completedOrder()
    ↓
检测是否为 Rak 商品
    ↓
异步处理 Rak 订单（RakOrderProcess）
```

### 集成方案

#### 方案一：通过商品配置传递 Rak 信息（推荐）

**适用场景**：商品固定配置，用户无需选择

**实现步骤**：

1. **在商品表中添加 Rak 配置字段**（可选）

   如果需要在商品表中直接存储 Rak 配置，可以添加以下字段：
   - `rak_sample_id` - Rak 产品 ID
   - `rak_config_options` - Rak 配置选项（JSON）
   - `rak_billing_cycle` - Rak 计费周期

2. **修改 `ButtonUtil@confirmorder()` 方法**

   在创建订单时，从商品配置中获取 Rak 信息并传递到 `other_input`：

   ```php
   // app/Util/ButtonUtil.php
   public function confirmorder($update,$bot){
       // ... 现有代码 ...
       
       // 检查商品是否为 Rak 商品
       if ($this->isRakProduct($goods)) {
           // 从商品配置或商品表获取 Rak 配置
           $rakConfig = $this->getRakConfigFromGoods($goods);
           
           if ($rakConfig) {
               // 设置 other_input
               $otherInput = json_encode([
                   'rak' => $rakConfig
               ]);
               $this->orderProcessService->setOtherIpt($otherInput);
           }
       }
       
       // ... 继续创建订单 ...
   }
   
   /**
    * 检查商品是否为 Rak 商品
    */
   private function isRakProduct($goods): bool
   {
       $rakKeywords = ['rak', 'raksmart', '云服务器', '云机'];
       $goodsName = strtolower($goods->gd_name . ' ' . ($goods->gd_description ?? ''));
       
       foreach ($rakKeywords as $keyword) {
           if (strpos($goodsName, strtolower($keyword)) !== false) {
               return true;
           }
       }
       
       return false;
   }
   
   /**
    * 从商品中获取 Rak 配置
    */
   private function getRakConfigFromGoods($goods): ?array
   {
       // 方式1：从商品表的扩展字段获取（如果已添加）
       if (isset($goods->rak_sample_id) && $goods->rak_sample_id) {
           return [
               'sample_id' => $goods->rak_sample_id,
               'config_options_data' => json_decode($goods->rak_config_options, true) ?? [],
               'billing_cycle' => $goods->rak_billing_cycle ?? 'Monthly',
           ];
       }
       
       // 方式2：从商品描述中解析（如果描述包含 JSON）
       if (!empty($goods->gd_description)) {
           $desc = json_decode($goods->gd_description, true);
           if (is_array($desc) && isset($desc['rak'])) {
               return $desc['rak'];
           }
       }
       
       // 方式3：使用默认配置（需要根据实际情况调整）
       // 这里可以根据商品 ID 或名称匹配预设的 Rak 配置
       
       return null;
   }
   ```

#### 方案二：用户交互选择 Rak 配置（高级）

**适用场景**：需要用户选择配置（如地区、CPU、内存等）

**实现步骤**：

1. **在商品详情页面添加配置选择按钮**

   修改 `ButtonUtil@goodsinfo()` 方法，如果是 Rak 商品，显示配置选择按钮：

   ```php
   // app/Util/ButtonUtil.php
   public function goodsinfo($update,$bot){
       // ... 现有代码 ...
       
       // 如果是 Rak 商品，添加配置选择按钮
       if ($this->isRakProduct($goodsList)) {
           $arr[] = [["text" => "选择配置", "callback_data" => "rakconfig_" . $goodsList["id"]]];
       }
       
       // ... 返回商品详情 ...
   }
   ```

2. **添加配置选择处理方法**

   ```php
   // app/Util/ButtonUtil.php
   public function rakconfig($update,$bot){
       $userInfo = Util::getUserTelegramId($update->getCallbackQuery()->getMessage()->getChat()->getId());
       $array = explode("_",$update->getCallbackQuery()->getData());
       $goodsId = $array[1];
       
       // 获取 Rak 产品列表
       $rakClient = new \App\Service\RakApiClient();
       $plans = $rakClient->getPlans('instance', 'sv'); // 可以根据商品配置选择地区
       
       // 显示配置选项（地区、CPU、内存等）
       $buttons = [];
       foreach ($plans as $plan) {
           $buttons[] = [[
               "text" => $plan['product_name'],
               "callback_data" => "rakplan_" . $plan['id'] . "_" . $goodsId
           ]];
       }
       
       // 保存用户选择的配置到缓存
       Cache::put($update->getCallbackQuery()->getMessage()->getChat()->getId() . "_rakconfig", [
           'goods_id' => $goodsId,
           'plan_id' => $plan['id'],
       ], 600); // 10分钟过期
       
       return $this->_return("请选择产品配置", "markdown", true, $buttons);
   }
   ```

3. **在创建订单时使用缓存的配置**

   ```php
   // app/Util/ButtonUtil.php
   public function confirmorder($update,$bot){
       // ... 现有代码 ...
       
       $chatId = $update->getCallbackQuery()->getMessage()->getChat()->getId();
       
       // 检查是否有缓存的 Rak 配置
       $rakConfig = Cache::get($chatId . "_rakconfig");
       if ($rakConfig && $rakConfig['goods_id'] == $array[2]) {
           // 获取完整的 Rak 配置
           $fullRakConfig = $this->buildRakConfig($rakConfig);
           
           if ($fullRakConfig) {
               $otherInput = json_encode([
                   'rak' => $fullRakConfig
               ]);
               $this->orderProcessService->setOtherIpt($otherInput);
           }
           
           // 清理缓存
           Cache::forget($chatId . "_rakconfig");
       }
       
       // ... 继续创建订单 ...
   }
   ```

### 推荐实现方案

**对于大多数场景，推荐使用方案一**，原因：
1. ✅ 实现简单，无需复杂的用户交互
2. ✅ 用户体验好，购买流程顺畅
3. ✅ 适合固定配置的商品

**如果商品需要用户选择配置，可以使用方案二**，但需要：
1. 设计良好的用户交互流程
2. 处理配置选择的缓存和过期
3. 验证配置的有效性

### 代码修改示例

#### 修改 `ButtonUtil@confirmorder()` 方法

在 `app/Util/ButtonUtil.php` 的 `confirmorder()` 方法中，取消注释并修改以下代码：

```php
// 原代码（第 357-358 行，已注释）
//$otherIpt = $this->orderService->validatorChargeInput($goods, $request);
//$this->orderProcessService->setOtherIpt($otherIpt);

// 修改为：
// 检查是否为 Rak 商品
$rakKeywords = ['rak', 'raksmart', '云服务器', '云机'];
$goodsName = strtolower($goods->gd_name . ' ' . ($goods->gd_description ?? ''));
$isRakProduct = false;
foreach ($rakKeywords as $keyword) {
    if (strpos($goodsName, strtolower($keyword)) !== false) {
        $isRakProduct = true;
        break;
    }
}

if ($isRakProduct) {
    // 从商品描述或配置中获取 Rak 配置
    // 方式1：如果商品描述包含 JSON 格式的 Rak 配置
    $rakConfig = null;
    if (!empty($goods->gd_description)) {
        $desc = json_decode($goods->gd_description, true);
        if (is_array($desc) && isset($desc['rak'])) {
            $rakConfig = $desc['rak'];
        }
    }
    
    // 方式2：使用默认配置（需要根据实际情况调整）
    if (!$rakConfig) {
        // 这里可以根据商品 ID 或名称匹配预设的 Rak 配置
        // 例如：从配置文件或数据库获取
        $rakConfig = [
            'sample_id' => 'psam_01J8HEQ29HECJ88NHCMXDR33ZH', // 需要根据实际情况设置
            'config_options_data' => [
                '7778' => 91584,  // CPU: 2核心
                '7777' => 91573,  // Memory: 2G
                '7862' => 10       // Data Disk: 10G
            ],
            'billing_cycle' => 'Monthly',
        ];
    }
    
    if ($rakConfig) {
        $otherIpt = json_encode(['rak' => $rakConfig]);
        $this->orderProcessService->setOtherIpt($otherIpt);
    }
} else {
    // 非 Rak 商品，使用原有的逻辑
    $otherIpt = $this->orderService->validatorChargeInput($goods, $request);
    $this->orderProcessService->setOtherIpt($otherIpt);
}
```

### 测试 Telegram Bot 集成

1. **创建测试商品**
   - 商品名称包含 "Rak" 或 "云服务器"
   - 商品描述包含 Rak 配置（JSON 格式）或使用默认配置

2. **通过 Telegram Bot 购买**
   - 发送 `/start` 命令
   - 选择商品列表
   - 选择 Rak 商品
   - 完成购买流程

3. **验证订单处理**
   - 检查订单的 `other_input` 字段是否包含 Rak 配置
   - 检查订单支付完成后是否触发 Rak 订单处理
   - 查看日志确认 Rak API 调用成功

### 注意事项

1. **商品配置管理**
   - 建议在后台商品管理中直接配置 Rak 信息
   - 或者在商品描述中使用 JSON 格式存储 Rak 配置

2. **错误处理**
   - 如果 Rak 配置缺失，订单仍可正常创建，但不会触发 Rak 自动发货
   - 建议在日志中记录配置缺失的情况

3. **用户体验**
   - 如果使用方案二（用户选择配置），需要设计清晰的交互流程
   - 配置选择应该有明确的提示和确认步骤

---

## API 使用示例

### 示例一：获取 SV 地区云产品列表

```php
use App\Service\RakApiClient;

$rakClient = new RakApiClient();

// 获取 SV 地区的云产品列表
$plans = $rakClient->getPlans('instance', 'sv');

if ($plans) {
    foreach ($plans as $plan) {
        echo "产品ID: " . $plan['id'] . "\n";
        echo "产品名称: " . $plan['product_name'] . "\n";
        
        // 遍历配置选项
        foreach ($plan['product_sample_options'] as $option) {
            echo "配置项: " . $option['configoption_name'] . "\n";
            foreach ($option['sub_option'] as $subOption) {
                echo "  - " . $subOption['sub_option_name'] . " (ID: " . $subOption['sub_option_id'] . ")\n";
            }
        }
    }
}
```

### 示例二：计算产品价格

```php
use App\Service\RakApiClient;

$rakClient = new RakApiClient();

// 计算 SV 地区 2核2G 10G数据盘 月付价格
$price = $rakClient->getPrice(
    'psam_01J8HEQ29HECJ88NHCMXDR33ZH',  // 产品ID
    [
        '7778' => 91584,  // CPU: 2核心
        '7777' => 91573,  // Memory: 2G
        '7862' => 10      // Data Disk: 10G
    ],
    'Monthly',  // 月付
    1           // 数量
);

if ($price) {
    echo "首付金额: $" . $price['first_payment_amount'] . "\n";
    echo "续费金额: $" . $price['recurring_amount'] . "\n";
    
    if (isset($price['use_discount_ids'])) {
        echo "可用优惠券: " . implode(', ', $price['use_discount_ids']) . "\n";
    }
}
```

### 示例三：创建订单（完整流程）

```php
use App\Service\RakApiClient;

$rakClient = new RakApiClient();

// 1. 先获取价格（可选，用于验证）
$price = $rakClient->getPrice(
    'psam_01J8HEQ29HECJ88NHCMXDR33ZH',
    [
        '7778' => 91584,
        '7777' => 91573,
        '7862' => 10
    ],
    'Monthly',
    1
);

// 2. 创建订单
$orderResult = $rakClient->createOrder(
    'psam_01J8HEQ29HECJ88NHCMXDR33ZH',
    [
        '7778' => 91584,
        '7777' => 91573,
        '7862' => 10
    ],
    'Monthly',
    1,
    $price['use_discount_ids'] ?? null  // 使用可用优惠券
);

if ($orderResult) {
    $serviceIds = $orderResult['order_result']['serviceids'] ?? '';
    $invoiceId = $orderResult['pay_result']['data']['invoiceid'] ?? '';
    $amount = $orderResult['pay_result']['data']['amount'] ?? 0;
    $invoicePaid = $orderResult['pay_result']['data']['invoicepaid'] ?? 'false';
    
    echo "服务器ID: " . $serviceIds . "\n";
    echo "发票ID: " . $invoiceId . "\n";
    echo "订单金额: $" . $amount . "\n";
    echo "是否已支付: " . $invoicePaid . "\n";
}
```

---

## 错误处理与日志

### 错误处理机制

1. **API 调用失败**
   - 记录错误日志
   - 返回 `null`
   - 队列任务自动重试（最多3次）

2. **配置缺失**
   - 记录错误日志
   - 跳过处理，不影响主流程

3. **订单状态不正确**
   - 记录信息日志
   - 跳过处理

### 日志位置

所有日志记录在 Laravel 日志文件中（`storage/logs/laravel.log`）。

**日志类型**：

- **错误日志**：`Log::error()` - API 调用失败、配置缺失等
- **警告日志**：`Log::warning()` - 处理失败但不影响主流程
- **信息日志**：`Log::info()` - 订单处理成功、跳过处理等

### 日志示例

```
[2024-01-01 10:00:00] local.ERROR: Rak API 创建订单失败: Connection timeout
[2024-01-01 10:00:05] local.INFO: Rak 订单处理成功 {"order_sn":"ORD20240101100000","service_ids":"280985"}
[2024-01-01 10:00:10] local.WARNING: Rak 订单处理触发失败: Class not found
```

---

## 测试验证

### 测试步骤

#### 1. 环境配置测试

```bash
# 检查配置文件是否存在
php artisan config:cache

# 检查环境变量是否正确读取
php artisan tinker
>>> config('rak.api_key')
```

#### 2. API 连接测试

创建测试脚本 `test_rak_api.php`：

```php
<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Service\RakApiClient;

$rakClient = new RakApiClient();

// 测试获取地区
echo "测试获取地区...\n";
$regions = $rakClient->getRegions('instance');
if ($regions) {
    echo "成功！获取到 " . count($regions) . " 个地区\n";
    print_r($regions);
} else {
    echo "失败！请检查 API Key 和网络连接\n";
}

// 测试获取产品列表
echo "\n测试获取产品列表...\n";
$plans = $rakClient->getPlans('instance', 'sv');
if ($plans) {
    echo "成功！获取到 " . count($plans) . " 个产品\n";
} else {
    echo "失败！\n";
}
```

运行测试：
```bash
php test_rak_api.php
```

#### 3. 订单处理测试

1. **创建测试商品**
   - 商品名称包含 "Rak" 或 "云服务器"
   - 设置商品为自动发货

2. **创建测试订单**
   - 在订单的 `other_input` 字段中添加 Rak 配置：
   ```json
   {
     "rak": {
       "sample_id": "psam_01J8HEQ29HECJ88NHCMXDR33ZH",
       "config_options_data": {
         "7778": 91584,
         "7777": 91573,
         "7862": 10
       },
       "billing_cycle": "Monthly"
     }
   }
   ```

3. **完成订单支付**
   - 使用测试支付方式完成订单

4. **检查订单处理**
   - 查看日志文件：`storage/logs/laravel.log`
   - 检查订单的 `info` 字段是否包含服务器信息
   - 检查队列任务是否执行成功

#### 4. 队列测试

```bash
# 启动队列处理器
php artisan queue:work

# 查看队列任务
php artisan queue:failed
```

---

## 常见问题

### Q1: 如何获取 Rak API Key？

A: 联系 RakSmart 客服或在 RakSmart 控制台申请 API Key。

### Q2: 订单没有自动处理 Rak 发货？

**检查清单**：
1. ✅ 检查 `RAK_ENABLED=true` 是否已设置
2. ✅ 检查商品名称是否包含 Rak 关键词
3. ✅ 检查订单的 `other_input` 字段是否包含 Rak 配置
4. ✅ 检查队列是否正在运行：`php artisan queue:work`
5. ✅ 查看日志文件：`storage/logs/laravel.log`

### Q3: API 调用失败怎么办？

**排查步骤**：
1. 检查 API Key 是否正确
2. 检查网络连接是否正常
3. 检查 API 基础 URL 是否正确
4. 查看日志文件获取详细错误信息
5. 联系 RakSmart 技术支持

### Q4: 如何手动触发 Rak 订单处理？

```php
use App\Models\Order;
use App\Service\RakOrderService;

$order = Order::where('order_sn', 'YOUR_ORDER_SN')->first();
$rakOrderService = new RakOrderService();
$result = $rakOrderService->processOrder($order);
```

### Q5: 如何查看 Rak 订单处理状态？

查看订单的 `info` 字段，如果包含 `service_ids`，说明处理成功。

### Q6: 支持哪些产品类型？

- `instance` - 云产品（云服务器）
- `metal` - 独服产品
- `disk` - 磁盘产品
- `eip` - 弹性 IP

### Q7: 如何配置优惠券？

在订单的 `other_input` 字段中添加 `discount_ids`：

```json
{
  "rak": {
    "sample_id": "...",
    "config_options_data": {...},
    "billing_cycle": "Monthly",
    "discount_ids": ["disc_01JM9MQ0AJSSC799X0VFHNEPXP"]
  }
}
```

---

## 后续扩展

### 1. 产品同步功能

定期同步 Rak 产品列表到系统，方便商品管理。

### 2. 价格监控

监控价格变化并通知管理员。

### 3. 库存管理

同步库存信息，自动下架缺货商品。

### 4. 订单查询

查询 Rak 订单状态，支持订单状态同步。

### 5. 服务器管理

管理已购买的服务器，支持续费、升级等操作。

### 6. 后台管理界面

创建后台管理界面，方便配置和管理 Rak 商品。

---

## 技术支持

如有问题，请：
1. 查看日志文件：`storage/logs/laravel.log`
2. 检查配置文件：`config/rak.php`
3. 参考 Rak API 官方文档
4. 联系技术支持

---

**文档版本**: v1.0  
**最后更新**: 2024-01-01  
**维护者**: 系统管理员

