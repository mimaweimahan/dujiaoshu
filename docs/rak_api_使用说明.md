# Rak API 集成使用说明

## 📋 快速开始

### 1. 环境配置

在 `.env` 文件中添加以下配置：

```env
# Rak API 配置
RAK_API_BASE_URL=https://rak-api.raksmart.com/rakapi/v1/
RAK_API_KEY=your_api_key_here
RAK_DEFAULT_REGION=sv
RAK_DEFAULT_TYPE=instance
RAK_API_TIMEOUT=30
RAK_ENABLED=true
```

### 2. 配置说明

| 配置项 | 说明 | 必填 | 默认值 |
|--------|------|------|--------|
| `RAK_API_BASE_URL` | Rak API 基础 URL | 是 | `https://rak-api.raksmart.com/rakapi/v1/` |
| `RAK_API_KEY` | Rak API Key | 是 | - |
| `RAK_DEFAULT_REGION` | 默认地区 | 否 | `sv` |
| `RAK_DEFAULT_TYPE` | 默认产品类型 | 否 | `instance` |
| `RAK_API_TIMEOUT` | API 请求超时时间（秒） | 否 | `30` |
| `RAK_ENABLED` | 是否启用 Rak 功能 | 否 | `false` |

---

## 🛒 商品配置方式

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

---

### 方式二：通过商品名称关键词识别

系统会自动识别商品名称中包含以下关键词的商品为 Rak 商品：

- `rak`
- `raksmart`
- `云服务器`
- `云机`

**注意**：使用此方式时，仍需在订单的 `other_input` 字段中提供 Rak 配置信息。

---

## 📝 使用示例

### 示例 1：创建 SV 地区云机订单

#### 1. 获取产品信息

```php
use App\Service\RakApiClient;

$rakClient = new RakApiClient();

// 获取 SV 地区的云产品列表
$plans = $rakClient->getPlans(
    type: 'instance',
    region: 'sv',
    limit: 10
);

// 假设获取到的产品 ID 为：psam_01J8HEQ29HECJ88NHCMXDR33ZH
```

#### 2. 获取价格

```php
$price = $rakClient->getPrice(
    sampleId: 'psam_01J8HEQ29HECJ88NHCMXDR33ZH',
    configOptionsData: [
        '7778' => 91584,  // 2核
        '7777' => 91573,  // 2G内存
        '7862' => 10      // 10G 数据盘
    ],
    billingCycle: 'Monthly',
    quantity: 1
);

// 返回：['first_payment_amount' => '18.22', 'recurring_amount' => '23.22']
```

#### 3. 用户下单时配置订单

在前端表单中收集用户选择的配置，并在创建订单时传入：

```php
// 订单创建时
$orderData = [
    'goods_id' => $goodsId,
    'other_input' => json_encode([
        'rak' => [
            'sample_id' => 'psam_01J8HEQ29HECJ88NHCMXDR33ZH',
            'config_options_data' => [
                '7778' => 91584,
                '7777' => 91573,
                '7862' => 10
            ],
            'billing_cycle' => 'Monthly',
        ]
    ]),
    // ... 其他订单字段
];
```

#### 4. 订单支付完成后自动处理

订单支付完成后，系统会自动：
1. 检测订单是否为 Rak 商品
2. 调用 Rak API 创建订单
3. 获取服务器信息并更新到订单
4. 自动发货给用户

---

## 🔄 订单处理流程

```
用户下单
    ↓
订单支付完成
    ↓
OrderProcessService@completedOrder
    ↓
检查是否为 Rak 商品
    ↓
是 → 异步触发 RakOrderProcess 队列任务
    ↓
RakOrderService@processOrder
    ↓
调用 RakApiClient@createOrder
    ↓
获取服务器信息
    ↓
更新订单信息（info 字段）
    ↓
自动发货给用户
```

---

## 📊 订单信息格式

订单处理完成后，订单的 `info` 字段会包含服务器 ID（service_ids），格式如下：

```
280985
```

或者包含完整的订单信息（JSON 格式）：

```json
{
  "service_ids": "280985",
  "invoice_id": 19981,
  "amount": 32.05,
  "invoice_paid": "true",
  "order_time": "2025-01-01 12:00:00",
  "rak_order_result": {
    "pay_result": {...},
    "order_result": {...}
  }
}
```

---

## 🛠️ API 客户端使用

### 获取可用地区

```php
$rakClient = new RakApiClient();
$regions = $rakClient->getRegions('instance');
// 返回：[
//   ['continent' => 'americas', 'region' => 'sv'],
//   ['continent' => 'asia', 'region' => 'hk'],
//   ...
// ]
```

### 获取产品列表

```php
$rakClient = new RakApiClient();
$plans = $rakClient->getPlans(
    type: 'instance',
    region: 'sv',
    productName: 'SV-RAK',
    limit: 10
);
```

### 获取产品价格

```php
$rakClient = new RakApiClient();
$price = $rakClient->getPrice(
    sampleId: 'psam_xxx',
    configOptionsData: ['7778' => 91584, '7777' => 91573],
    billingCycle: 'Monthly',
    quantity: 1
);
```

### 创建订单

```php
$rakClient = new RakApiClient();
$result = $rakClient->createOrder(
    sampleId: 'psam_xxx',
    configOptionsData: ['7778' => 91584, '7777' => 91573],
    billingCycle: 'Monthly',
    quantity: 1,
    discountIds: ['disc_xxx'] // 可选
);
```

---

## ⚠️ 注意事项

1. **API Key 安全**
   - 确保 API Key 安全存储，不要提交到代码仓库
   - 使用环境变量存储敏感信息

2. **错误处理**
   - 系统已实现完善的错误处理和日志记录
   - 订单处理失败时会自动重试（最多3次）
   - 查看日志：`storage/logs/laravel.log`

3. **队列处理**
   - Rak 订单处理使用队列异步处理，不会阻塞主流程
   - 确保队列服务正常运行：`php artisan queue:work`

4. **订单状态**
   - 只有已支付的订单才会触发 Rak 订单处理
   - 订单状态必须为 `STATUS_COMPLETED`

5. **配置验证**
   - 系统会验证 Rak 配置的完整性
   - 缺少必要参数时会在日志中记录错误

---

## 🐛 故障排查

### 问题 1：Rak 订单未自动处理

**检查项：**
1. 确认 `RAK_ENABLED=true` 已配置
2. 确认 `RAK_API_KEY` 正确
3. 检查订单的 `other_input` 字段是否包含 Rak 配置
4. 检查商品名称是否包含 Rak 关键词
5. 查看日志：`storage/logs/laravel.log`

### 问题 2：API 调用失败

**检查项：**
1. 确认 API Key 有效
2. 确认网络连接正常
3. 检查 API 基础 URL 是否正确
4. 查看日志中的详细错误信息

### 问题 3：订单信息未更新

**检查项：**
1. 确认 Rak API 返回了正确的订单结果
2. 检查数据库事务是否提交成功
3. 查看日志中的订单处理记录

---

## 📚 相关文档

- [Rak API 集成详细方案](./rak_api_集成方案.md)
- [Rak API 官方文档](https://rak-api.raksmart.com/docs)

---

## 🔗 相关文件

- `config/rak.php` - Rak 配置文件
- `app/Service/RakApiClient.php` - Rak API 客户端
- `app/Service/RakOrderService.php` - Rak 订单处理服务
- `app/Jobs/RakOrderProcess.php` - Rak 订单处理队列任务
- `app/Service/OrderProcessService.php` - 订单处理服务（已集成）

