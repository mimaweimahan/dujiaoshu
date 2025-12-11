# Telegram批量群发功能使用说明

## 📋 功能概述

本功能允许管理员通过后台向所有绑定了Telegram的用户批量发送消息，支持三种消息类型：
- **文本消息** - 纯文本或HTML格式的消息
- **图片消息** - 带图片的消息
- **视频消息** - 带视频的消息

## 🎯 使用方式

### 方式一：顶部导航栏快捷按钮（推荐）

1. 登录后台管理系统
2. 在顶部导航栏找到 **"批量群发"** 按钮（带发送图标）
3. 点击按钮，弹出群发对话框
4. 填写相关信息：
   - 选择消息类型（文本/图片/视频）
   - 如果选择图片或视频，需要填写媒体URL
   - 输入消息内容（支持HTML标签）
5. 点击 **"发送群发"** 按钮
6. 等待系统处理，查看发送结果

### 方式二：独立管理页面

1. 访问后台地址：`/admin/telegram-broadcast`
2. 查看当前绑定Telegram的用户数量
3. 填写表单信息并提交

## 📝 消息格式说明

### 文本消息
支持HTML格式，可使用以下标签：
```html
<b>粗体文字</b>
<i>斜体文字</i>
<u>下划线</u>
<a href="https://example.com">超链接</a>
<code>代码</code>
<pre>预格式化文本</pre>
```

示例：
```
<b>重要通知</b>

尊敬的用户，您好！

我们的系统将于 <u>2025年1月1日</u> 进行升级维护。

详情请访问：<a href="https://example.com">查看详情</a>
```

### 图片消息
- 需要提供可直接访问的图片URL
- 支持的格式：JPG、PNG、GIF
- 图片URL示例：`https://example.com/image.jpg`
- 可以添加图片说明文字（caption）

### 视频消息
- 需要提供可直接访问的视频URL
- 支持的格式：MP4、AVI等
- 视频URL示例：`https://example.com/video.mp4`
- 可以添加视频说明文字（caption）

## ⚙️ 技术实现

### 文件结构
```
app/
├── Jobs/
│   └── TelegramBroadcast.php          # 队列任务，处理单个用户的消息发送
├── Admin/
│   ├── Controllers/
│   │   └── TelegramBroadcastController.php  # 后台控制器
│   ├── bootstrap.php                  # 注册导航栏按钮
│   └── routes.php                     # 添加路由

resources/views/admin/
├── telegram_broadcast_button.blade.php  # 顶部导航栏按钮视图
└── telegram_broadcast.blade.php         # 独立管理页面

docs/
└── telegram_broadcast_guide.md          # 本使用说明
```

### 工作流程

1. **管理员提交群发请求**
   - 通过弹窗或页面提交表单
   - 后端接收并验证数据

2. **获取目标用户**
   ```php
   User::whereNotNull('telegram_id')
       ->where('telegram_id', '!=', '')
       ->get(['id', 'telegram_id', 'email']);
   ```

3. **创建发送任务**
   - 为每个用户创建一个独立的队列任务
   - 使用Laravel队列系统异步处理
   ```php
   TelegramBroadcast::dispatch(
       $user->telegram_id,
       $message,
       $messageType,
       $mediaUrl
   );
   ```

4. **队列执行发送**
   - 每个任务独立执行，互不影响
   - 失败的任务会自动重试（最多2次）
   - 所有操作都记录日志

### API路由

| 方法 | 路径 | 说明 |
|------|------|------|
| GET | `/admin/telegram-broadcast` | 批量群发管理页面 |
| POST | `/admin/telegram-broadcast/send` | 发送批量群发请求 |

### 请求参数

```json
{
    "message_type": "text|photo|video",
    "message": "消息内容",
    "media_url": "媒体URL（可选，图片或视频时必填）"
}
```

### 响应格式

成功响应：
```json
{
    "status": true,
    "message": "成功将 100 条消息加入发送队列，请稍后查看发送结果",
    "data": {
        "total_users": 100,
        "queued_count": 100
    }
}
```

失败响应：
```json
{
    "status": false,
    "message": "错误信息"
}
```

## 🔧 配置要求

### 必须配置项

1. **Telegram Bot Token**
   - 在系统设置中配置：`telegram_bot_api_token`
   - 获取方式：通过 [@BotFather](https://t.me/BotFather) 创建Bot

2. **队列配置**
   - 确保Laravel队列正常运行
   - 启动队列worker：
   ```bash
   php artisan queue:work
   ```
   
3. **用户Telegram绑定**
   - 用户需要通过Telegram登录或手动绑定
   - 绑定后 `telegram_id` 字段会存储用户的Telegram ID

### 可选配置

- 队列驱动：可选择 `redis`、`database`、`sync` 等
- 任务重试次数：默认2次
- 任务超时时间：默认30秒

## 📊 日志记录

所有群发操作都会记录日志，可在 `storage/logs/laravel.log` 中查看：

```
# 群发任务创建日志
[2025-01-01 12:00:00] local.INFO: Telegram批量群发任务已加入队列 
{"user_count":100,"queued_count":100,"message_type":"text","admin_user":"admin"}

# 单条消息发送成功日志
[2025-01-01 12:00:01] local.INFO: TelegramBroadcast 发送成功 
{"telegram_id":"123456789","type":"text"}

# 单条消息发送失败日志
[2025-01-01 12:00:02] local.ERROR: TelegramBroadcast 发送失败: Connection timeout 
{"telegram_id":"987654321","type":"text"}
```

## ⚠️ 注意事项

1. **发送频率限制**
   - Telegram对Bot发送消息有频率限制
   - 建议使用队列异步发送，避免并发过高
   - 大量用户时，发送可能需要一定时间

2. **消息格式**
   - 确保HTML标签正确闭合
   - 媒体URL必须可直接访问（无需登录）
   - 建议使用HTTPS协议的URL

3. **用户筛选**
   - 只会向 `telegram_id` 不为空的用户发送
   - 如果用户未绑定Telegram，会自动跳过

4. **错误处理**
   - 单个用户发送失败不影响其他用户
   - 失败的任务会自动重试
   - 建议定期查看日志文件

## 🎨 界面预览

### 顶部导航栏按钮
```
[首页] [商品] [订单] [用户] [批量群发🔔]
```

### 弹窗界面
```
╔══════════════════════════════════════╗
║     Telegram批量群发               ×  ║
╠══════════════════════════════════════╣
║                                      ║
║  消息类型：[文本消息 ▼]              ║
║                                      ║
║  消息内容：                          ║
║  ┌──────────────────────────────┐   ║
║  │ 请输入要群发的消息内容...    │   ║
║  │                              │   ║
║  │                              │   ║
║  └──────────────────────────────┘   ║
║                                      ║
║    [取消]          [发送群发]        ║
╚══════════════════════════════════════╝
```

## 🐛 常见问题

### Q1：点击按钮没有反应？
**A：** 检查以下几点：
- 浏览器控制台是否有JavaScript错误
- 是否正确加载了SweetAlert2库
- 是否有权限访问该功能

### Q2：发送后没有收到消息？
**A：** 检查以下几点：
- Telegram Bot Token是否正确配置
- 用户的telegram_id是否正确
- 队列是否正常运行（`php artisan queue:work`）
- 查看日志文件确认发送状态

### Q3：部分用户收不到消息？
**A：** 可能的原因：
- 用户未绑定Telegram账号
- 用户屏蔽了Bot
- 用户的telegram_id不正确
- 网络问题或Telegram服务暂时不可用

### Q4：如何查看发送状态？
**A：** 
- 查看日志文件：`storage/logs/laravel.log`
- 使用命令：`tail -f storage/logs/laravel.log | grep TelegramBroadcast`
- 在后台查看队列任务执行情况

## 🔄 更新日志

### v1.0.0 (2025-01-01)
- ✅ 初始版本发布
- ✅ 支持文本、图片、视频三种消息类型
- ✅ 添加顶部导航栏快捷按钮
- ✅ 集成SweetAlert2弹窗
- ✅ 使用队列异步处理
- ✅ 完整的日志记录

## 📞 技术支持

如有问题，请联系开发团队或查看系统日志。

---

**开发团队** | **最后更新：2025-01-01**

