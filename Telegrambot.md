# Telegram Bot 功能梳理文档

## 📋 目录
1. [系统架构概览](#系统架构概览)
2. [核心组件](#核心组件)
3. [交互流程](#交互流程)
4. [功能模块详解](#功能模块详解)
5. [前后端交互](#前后端交互)
6. [数据流](#数据流)
7. [配置说明](#配置说明)

---

## 系统架构概览

### 整体架构
```
Telegram Bot 系统
├── Webhook 入口 (BotController@index)
├── 命令处理层 (BotController)
├── 按钮处理层 (ButtonUtil)
├── 服务层 (ButtonService, OrderService, GoodsService)
├── 队列任务 (TelegramPush, TelegramBroadcast)
└── 数据库模型 (User, Order, Goods, Button)
```

### 技术栈
- **Bot SDK**: `telegram-bot/api` (PHP)
- **HTTP 客户端**: GuzzleHttp
- **队列系统**: Laravel Queue
- **缓存**: Laravel Cache (Redis)

---

## 核心组件

### 1. BotController (`app/Http/Controllers/Home/BotController.php`)

**职责**: Telegram Bot 的主要入口和命令处理器

**核心功能**:
- 接收 Telegram Webhook 请求
- 处理用户命令 (`/start`, `/help`, `/energy`, `/premium`, `/stars`)
- 处理普通消息（商品搜索、订单查询等）
- 处理内联按钮回调

**关键方法**:
```php
public function index()  // Webhook 入口
```

**命令处理**:
- `/start` - 启动命令，处理用户注册和商品分享链接
- `/help` - 帮助命令
- `/energy` - 能量购买命令
- `/premium` - 会员购买命令
- `/stars` - 星星购买命令（未开发）

### 2. ButtonUtil (`app/Util/ButtonUtil.php`)

**职责**: 处理所有内联按钮的回调逻辑

**核心方法**:
- `clone()` - 关闭按钮
- `shoplist()` - 商品分类列表
- `goods()` - 商品列表
- `goodsinfo()` - 商品详情
- `goodsbuy()` - 购买商品
- `confirmorder()` - 确认订单
- `gopay()` - 支付订单
- `rechargeamount()` - 充值金额选择
- `confirmrecharge()` - 确认充值
- `gorechargepay()` - 执行充值支付
- `customrecharge()` - 自定义充值
- `premiumself()` - 为自己购买会员
- `premiumother()` - 为他人购买会员
- `confirmrehuiyuan()` - 确认购买会员
- `payhuiyuan()` - 支付会员
- `getorder()` - 获取订单文件
- `setlang()` - 设置语言

### 3. ButtonService (`app/Service/ButtonService.php`)

**职责**: 管理按钮配置数据

**核心方法**:
- `withButtonData($keyword, $lang)` - 通过关键词获取按钮配置
- `withButtonTitleData($keyword, $lang)` - 通过标题获取按钮配置

**数据来源**: `buttons` 表，存储按钮的文本、按钮布局、消息模式等

### 4. TelegramPush (`app/Jobs/TelegramPush.php`)

**职责**: 订单创建后向管理员推送 Telegram 通知

**触发时机**: 订单创建时（通过队列异步执行）

**推送内容**:
- 订单号
- 订单金额
- 支付方式
- 商品信息
- 库存信息
- 用户邮箱

### 5. TelegramBroadcast (`app/Jobs/TelegramBroadcast.php`)

**职责**: 批量群发消息给所有绑定 Telegram 的用户

**支持的消息类型**:
- `text` - 文本消息
- `photo` - 图片消息
- `video` - 视频消息

**使用场景**: 后台管理批量通知用户

### 6. TelegramBroadcastController (`app/Admin/Controllers/TelegramBroadcastController.php`)

**职责**: 后台管理批量群发功能

**核心方法**:
- `index()` - 显示群发页面
- `send()` - 处理群发请求，将任务加入队列

---

## 交互流程

### 1. 用户启动 Bot (`/start` 命令)

```
用户发送 /start
    ↓
BotController@index 接收
    ↓
检查是否为私聊 (private)
    ↓
解析启动参数 (getUserAndShop)
    ├── 邀请链接: ?start=user=123
    └── 商品分享: ?start=shop=456
    ↓
检查用户是否存在 (Util::getUserTelegramId)
    ├── 不存在 → 创建新用户
    │   ├── telegram_id
    │   ├── telegram_username
    │   ├── telegram_nick
    │   ├── password (默认: 123456)
    │   ├── money (注册赠送金额)
    │   └── invite_code (随机生成)
    └── 存在 → 使用现有用户
    ↓
根据参数类型处理
    ├── 商品分享 → 显示商品详情
    └── 普通启动 → 显示主菜单
```

### 2. 商品购买流程

```
用户点击"商品列表"按钮
    ↓
ButtonUtil@shoplist() 处理
    ↓
显示商品分类列表
    ↓
用户选择分类
    ↓
ButtonUtil@goods() 处理
    ↓
显示该分类下的商品列表
    ↓
用户选择商品
    ↓
ButtonUtil@goodsinfo() 处理
    ↓
显示商品详情
    ├── 商品名称
    ├── 商品描述
    ├── 库存数量
    ├── 价格
    └── 发货类型（自动/手动）
    ↓
用户点击"购买"按钮
    ↓
ButtonUtil@goodsbuy() 处理
    ├── 检查库存
    └── 设置缓存状态，等待用户输入数量
    ↓
用户输入购买数量
    ↓
BotController 检测到缓存状态
    ↓
显示支付方式选择
    ├── 余额支付
    └── 其他支付方式
    ↓
用户选择支付方式
    ↓
ButtonUtil@confirmorder() 处理
    ├── 验证商品状态
    ├── 验证库存
    ├── 创建订单 (OrderProcessService)
    └── 显示订单确认信息
    ↓
用户确认支付
    ↓
ButtonUtil@gopay() 处理
    ├── 余额支付 → 直接扣款
    └── 其他支付 → 调用支付网关
        ├── TokenPay → 显示二维码和地址
        ├── EPUSDT → 显示支付链接和二维码
        └── Yipay → 显示支付链接和二维码
```

### 3. 余额充值流程

```
用户点击"余额充值"按钮
    ↓
显示充值金额选项（从配置读取）
    ├── 预设金额（带赠送）
    └── 自定义金额
    ↓
用户选择金额
    ↓
ButtonUtil@rechargeamount() 处理
    ↓
显示支付方式选择（过滤充值可用支付方式）
    ↓
用户选择支付方式
    ↓
ButtonUtil@confirmrecharge() 处理
    ↓
显示充值确认信息
    ├── 充值金额
    ├── 赠送金额
    └── 支付方式
    ↓
用户确认
    ↓
ButtonUtil@gorechargepay() 处理
    ├── 创建充值订单
    ├── 调用支付网关
    └── 显示支付信息（二维码/链接）
```

### 4. 订单查询流程

```
用户发送订单号（纯文本消息）
    ↓
BotController 检测到文本消息
    ↓
尝试查询订单 (OrderService@detailOrderSN)
    ↓
找到订单 → 显示订单详情
    ├── 订单号
    ├── 商品名称
    ├── 订单金额
    ├── 支付方式
    ├── 订单状态
    └── 查看详情按钮
    ↓
用户点击"查看详情"按钮
    ↓
ButtonUtil@getorder() 处理
    ├── 查找订单文件 (.txt 或 .zip)
    └── 发送文件给用户
```

### 5. 会员购买流程

```
用户发送 /premium 命令
    ↓
显示会员购买菜单
    ├── 为自己购买
    └── 为他人购买
    ↓
用户选择"为自己购买"
    ↓
ButtonUtil@premiumself() 处理
    ↓
显示会员套餐选择
    ├── 1个月 (XX USDT)
    ├── 3个月 (XX USDT)
    └── ...
    ↓
用户选择套餐
    ↓
ButtonUtil@confirmrehuiyuan() 处理
    ↓
显示确认信息
    ↓
用户确认
    ↓
ButtonUtil@payhuiyuan() 处理
    ├── 检查余额
    ├── 扣除余额
    ├── 调用 Telegram API 开通会员
    └── 显示成功信息
```

---

## 功能模块详解

### 1. 用户管理

**用户注册**:
- 通过 `/start` 命令自动注册
- 存储信息: `telegram_id`, `telegram_username`, `telegram_nick`
- 默认密码: `123456`
- 注册赠送金额: 从配置 `regmoney` 读取

**用户识别**:
```php
Util::getUserTelegramId($telegramId)
```
- 通过 `telegram_id` 查找用户
- 返回用户数组或 null

**用户信息展示**:
- 个人中心显示: ID、用户名、昵称、余额、邀请码、语言、注册时间、购买统计

### 2. 商品管理

**商品分类**:
- `ButtonUtil@shoplist()` - 显示所有分类
- `ButtonUtil@goods()` - 显示分类下的商品

**商品详情**:
- `ButtonUtil@goodsinfo()` - 显示商品详细信息
- 支持变量替换: `{gd_name}`, `{info}`, `{cardscount}`, `{price}`, `{type}`

**商品搜索**:
- 用户发送文本消息
- 系统搜索商品名称和描述
- 返回匹配的商品列表（带链接）

**商品分享**:
- 格式: `https://t.me/bot_username?start=shop=商品ID`
- 点击后直接显示商品详情

### 3. 订单管理

**订单创建**:
- 使用 `OrderProcessService` 创建订单
- 订单邮箱格式: `{telegram_id}@qq.com`
- IP 地址: `8.8.8.8` (固定)

**订单查询**:
- 通过订单号查询
- 通过邮箱查询（需要查询密码）
- 通过浏览器缓存查询

**订单状态**:
- 待支付 (STATUS_WAIT_PAY)
- 待处理 (STATUS_PENDING)
- 处理中 (STATUS_PROCESSING)
- 已完成 (STATUS_COMPLETED)
- 失败 (STATUS_FAILURE)
- 过期 (STATUS_EXPIRED)

**订单文件**:
- 自动发货订单生成 `.txt` 或 `.zip` 文件
- 用户可通过按钮下载订单文件

### 4. 支付系统

**支持的支付方式**:
- 余额支付 (WalletController)
- TokenPay (TokenPayController)
- EPUSDT (EpusdtController)
- Yipay (YipayController)
- 其他支付方式（通过配置）

**支付流程**:
1. 用户选择支付方式
2. 系统调用对应支付控制器
3. 返回支付信息（二维码/链接）
4. 用户完成支付
5. 支付回调更新订单状态

**支付信息展示**:
- TokenPay: 显示地址和二维码
- EPUSDT: 显示支付链接和二维码
- Yipay: 显示支付链接和二维码

### 5. 语言系统

**多语言支持**:
- 从 `langs` 表读取可用语言
- 用户语言存储在 `users.lang` 字段
- 按钮内容根据语言显示

**语言切换**:
- `ButtonUtil@setlang()` - 切换用户语言
- 切换后重新显示主菜单

### 6. 消息推送

**订单通知** (TelegramPush):
- 订单创建时触发
- 向管理员推送订单信息
- 使用队列异步执行

**批量群发** (TelegramBroadcast):
- 后台管理功能
- 支持文本、图片、视频
- 批量发送给所有绑定用户

---

## 前后端交互

### 1. Webhook 机制

**入口路由**:
```php
Route::post('/hook', 'BotController@index');
```

**请求流程**:
```
Telegram 服务器
    ↓ (POST /hook)
Laravel 应用
    ↓
BotController@index
    ↓
TelegramBot\Api\Client
    ↓
处理更新 (Update)
    ├── Message (文本消息)
    ├── CallbackQuery (按钮回调)
    └── Command (命令)
```

### 2. 按钮交互

**按钮数据结构**:
```json
{
  "inline_keyboard": [
    [
      {
        "text": "按钮文本",
        "callback_data": "action_param1_param2"
      }
    ]
  ]
}
```

**回调处理流程**:
```
用户点击按钮
    ↓
Telegram 发送 CallbackQuery
    ↓
BotController 解析 callback_data
    ↓
提取动作名称 (action)
    ↓
调用 ButtonUtil@{action}()
    ↓
返回响应数据
    ├── type: "send" | "edit" | "photo" | "video"
    ├── content: 消息内容
    ├── button: 按钮布局
    └── mode: 解析模式 (Markdown/HTML)
    ↓
根据 type 执行操作
    ├── send → 发送新消息
    ├── edit → 编辑消息
    ├── photo → 发送图片
    └── video → 发送视频
```

### 3. 缓存机制

**用途**:
- 存储用户临时状态
- 例如: 等待用户输入购买数量、等待输入充值金额

**缓存键格式**:
```php
Cache::put($chatId . "buygoods", $goodsId);  // 购买商品状态
Cache::put($chatId . "customrecharge", "12345");  // 自定义充值状态
Cache::put($chatId . "premiumother", "12345");  // 为他人购买会员状态
```

**清理缓存**:
```php
clone_cache_all($chatId);  // 清理用户所有缓存
```

### 4. Web 端 Telegram 登录

**登录流程**:
```
用户访问登录页面
    ↓
页面加载 Telegram Widget
    ↓
用户点击 "Login with Telegram"
    ↓
Telegram 验证用户身份
    ↓
回调到 /logintg
    ↓
AuthController@loginHandlerTg
    ├── 验证 Telegram 数据
    ├── 查找或创建用户
    └── 登录用户
```

**Telegram Widget 配置**:
```html
<script async src="https://telegram.org/js/telegram-widget.js?22"
    data-telegram-login="bot_username"
    data-size="large"
    data-auth-url="/logintg"
    data-request-access="write">
</script>
```

---

## 数据流

### 1. 用户数据流

```
Telegram 用户
    ↓
/start 命令
    ↓
创建/更新 User 记录
    ├── telegram_id
    ├── telegram_username
    ├── telegram_nick
    ├── money (余额)
    └── invite_code
    ↓
存储到 users 表
```

### 2. 订单数据流

```
用户选择商品和支付方式
    ↓
ButtonUtil@confirmorder()
    ↓
OrderProcessService@createOrder()
    ↓
创建 Order 记录
    ├── order_sn
    ├── goods_id
    ├── email (telegram_id@qq.com)
    ├── pay_id
    ├── total_price
    └── actual_price
    ↓
存储到 orders 表
    ↓
触发 TelegramPush 任务（队列）
    ↓
向管理员推送订单通知
```

### 3. 支付数据流

```
用户确认支付
    ↓
ButtonUtil@gopay()
    ↓
调用支付控制器
    ├── TokenPayController@gateway()
    ├── EpusdtController@gateway()
    └── YipayController@gateway()
    ↓
返回支付信息
    ├── 支付地址
    ├── 二维码链接
    └── 支付链接
    ↓
显示给用户
    ↓
用户完成支付
    ↓
支付回调更新订单状态
```

---

## 配置说明

### 1. Bot 配置

**必需配置**:
- `telegram_bot_api_token` - Bot Token
- `telegram_bot_username` - Bot 用户名（用于登录 Widget）

**可选配置**:
- `telegram_userid` - 管理员 Telegram ID（接收订单通知）
- `telegram_bot_token` - 订单通知使用的 Token（可能与上面不同）

### 2. 按钮配置

**存储位置**: `buttons` 表

**关键字段**:
- `keyword` - 按钮标识（用于查找）
- `title` - 按钮标题（用于匹配用户输入）
- `content` - 消息内容（支持变量替换）
- `button_json` - 按钮布局 JSON
- `mode` - 解析模式 (Markdown/HTML)
- `is_show` - 是否显示预览链接
- `lang` - 语言代码

**变量替换**:
- `{gd_name}` - 商品名称
- `{price}` - 价格
- `{ordersn}` - 订单号
- `{amount}` - 金额
- `{username}` - 用户名
- 等等...

### 3. 充值配置

**配置项**:
- `recharge_promotion` - 充值优惠配置（JSON）
  ```json
  [
    {"amount": 10, "value": 1},
    {"amount": 50, "value": 5}
  ]
  ```
- `recharge_text` - 充值单位文本
- `mini_deposit_amount` - 最低充值金额
- `max_deposit_amount` - 最高充值金额
- `open_czid` - 充值可用支付方式 ID（逗号分隔）

### 4. 会员配置

**配置项**:
- `subscribe_buy_config` - 会员套餐配置（JSON）
  ```json
  {
    "1": "10",
    "3": "25",
    "12": "90"
  }
  ```
- `chang_huiyuan` - 会员开通方式 (api/fragment)

### 5. 其他配置

- `regmoney` - 注册赠送金额
- `order_expire_time` - 订单过期时间（分钟）
- `search_keyword` - 群组搜索关键词（可选）

---

## 辅助函数

### 1. TelegramText()

**功能**: 转义 Telegram Markdown 特殊字符

**使用场景**: 发送 Markdown 格式消息时

```php
TelegramText($string)
```

**转义字符**: `.`, `#`, `>`, `=`, `{`, `}`, `-`, `|`, `_`, `+`, `(`, `)`, `<`, `!`

### 2. getUserAndShop()

**功能**: 解析 `/start` 命令的参数

**参数格式**:
- 邀请链接: `?start=user=123`
- 商品分享: `?start=shop=456`
- 组合: `?start=user=123andshop=456`

**返回**:
```php
[
  "upuser" => 123,  // 邀请人用户ID
  "shop" => [...],  // 商品信息数组
]
```

### 3. Util::getUserTelegramId()

**功能**: 通过 Telegram ID 查找用户

**返回**: 用户数组或 null

---

## 安全机制

### 1. 用户验证

- 所有操作都需要用户已注册
- 通过 `telegram_id` 识别用户

### 2. 订单验证

- 验证商品状态和库存
- 验证支付方式是否可用
- 订单过期自动处理

### 3. 支付安全

- 支付回调验证
- 订单状态检查
- 余额支付需要足够余额

---

## 错误处理

### 1. 异常捕获

- 所有关键操作都有 try-catch
- 错误信息记录到日志
- 用户友好的错误提示

### 2. 队列失败处理

- 任务最大尝试次数: 2 次
- 超时时间: 30 秒
- 失败后记录日志

---

## 扩展点

### 1. 添加新命令

在 `BotController@index()` 中添加:
```php
$bot->command("newcommand", function($message) use ($bot) {
    // 处理逻辑
});
```

### 2. 添加新按钮

1. 在 `buttons` 表添加配置
2. 在 `ButtonUtil` 添加处理方法
3. 在按钮 JSON 中设置 `callback_data`

### 3. 添加新支付方式

1. 创建支付控制器
2. 在 `ButtonUtil@gopay()` 中添加处理逻辑
3. 配置支付参数

---

## 总结

Telegram Bot 系统是一个完整的电商机器人，支持:
- ✅ 用户注册和管理
- ✅ 商品浏览和购买
- ✅ 订单创建和查询
- ✅ 多种支付方式
- ✅ 余额充值和提现
- ✅ 会员购买
- ✅ 多语言支持
- ✅ 批量消息推送
- ✅ Web 端 Telegram 登录

系统采用事件驱动架构，通过 Webhook 接收 Telegram 更新，通过按钮和命令与用户交互，使用队列处理异步任务，保证了系统的可扩展性和稳定性。

