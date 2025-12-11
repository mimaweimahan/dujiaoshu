# Telegram 按钮可视化编辑器 - 快速开始 🚀

## 快速上手指南（3分钟）

### 第一步：访问编辑器
```
浏览器打开：https://your-domain.com/admin/buttons
点击：新增
```

### 第二步：填写基本信息（30秒）
```
✅ 标题：主菜单按钮
✅ 关键词：start
✅ 语言：zh-CN
✅ 消息内容：欢迎使用！请选择功能：
✅ 消息模式：HTML
```

### 第三步：创建按钮（1分钟）
1. 点击 **"添加新行"**
2. 点击蓝色按钮进行编辑
3. 填写：
   - 按钮文字：`🛍 商品列表`
   - 回调数据：`shoplist`
4. 点击 **"添加按钮"** 创建第二个按钮
5. 重复以上步骤创建更多按钮

### 第四步：预览和保存（30秒）
1. 点击 **"预览效果"** 查看效果
2. 点击页面底部 **"提交"** 保存

## 🎯 常用按钮模板

### 模板 1：主菜单（复制即用）
```json
[
  [
    {"text": "🛍 商品列表", "callback_data": "shoplist"}
  ],
  [
    {"text": "👤 个人中心", "callback_data": "my"},
    {"text": "💰 余额充值", "callback_data": "recharge"}
  ],
  [
    {"text": "📋 订单查询", "callback_data": "orderlist"},
    {"text": "❓ 使用帮助", "callback_data": "help"}
  ]
]
```

**使用方法：**
1. 复制上面的 JSON
2. 粘贴到 "按钮JSON配置" 字段
3. 点击 "从JSON导入"
4. 保存

### 模板 2：支付方式选择
```json
[
  [
    {"text": "💳 支付宝", "callback_data": "pay_alipay"}
  ],
  [
    {"text": "💳 微信支付", "callback_data": "pay_wechat"}
  ],
  [
    {"text": "🪙 USDT", "callback_data": "pay_usdt"}
  ],
  [
    {"text": "⬅️ 返回", "callback_data": "back"}
  ]
]
```

### 模板 3：确认操作
```json
[
  [
    {"text": "✅ 确认", "callback_data": "confirm"},
    {"text": "❌ 取消", "callback_data": "cancel"}
  ]
]
```

## 💡 专业技巧

### 技巧 1：使用 Emoji 让按钮更美观
```
🛍 商品  💰 充值  📋 订单  👤 我的
❤️ 收藏  ⭐ 推荐  🔥 热门  🎁 优惠
✅ 确认  ❌ 取消  ⬅️ 返回  ➡️ 下一步
```

### 技巧 2：按钮布局建议
```
✅ 好的布局：
[按钮1] [按钮2]     ← 一行2个，平衡美观
[按钮3]              ← 重要操作单独一行

❌ 不好的布局：
[按钮1] [按钮2] [按钮3] [按钮4]  ← 一行太多，拥挤
```

### 技巧 3：按钮文字长度控制
```
✅ 好：商品列表、余额充值、个人中心
❌ 差：点击这里查看所有的商品列表信息
```

## 🔧 callback_data 命名规范

### 规范格式
```
功能_参数

示例：
goods_123      → 商品ID为123
pay_456        → 支付ID为456
confirm_789    → 确认订单789
back           → 返回上一页
close          → 关闭消息
```

### 对应 ButtonUtil.php 方法
```php
callback_data: "shoplist"  → public function shoplist($update, $bot)
callback_data: "goods_123" → public function goods($update, $bot)
callback_data: "close"     → public function close($update, $bot)
```

## 📱 测试按钮

### 方法 1：直接在 Telegram 测试
1. 打开你的 Telegram Bot
2. 发送 `/start` 命令
3. 点击按钮测试功能

### 方法 2：使用编辑器预览
1. 在编辑器中点击 "预览效果"
2. 查看按钮布局是否合理
3. 调整后再保存

## ❗ 常见错误及解决

### 错误 1：按钮保存后不显示
```
原因：keyword 或 lang 设置错误
解决：检查 keyword 是否与代码中的调用一致
```

### 错误 2：点击按钮没反应
```
原因：callback_data 没有对应的处理方法
解决：在 ButtonUtil.php 中添加对应方法
```

### 错误 3：JSON 格式错误
```
原因：手动编辑 JSON 时出错
解决：使用可视化编辑器，或点击 "从JSON导入" 检查格式
```

## 🎓 5分钟进阶教程

### 创建一个完整的购物流程

#### 1. 主菜单按钮（keyword: start）
```json
[
  [{"text": "🛍 浏览商品", "callback_data": "shoplist"}],
  [{"text": "👤 个人中心", "callback_data": "my"}]
]
```

#### 2. 商品分类按钮（keyword: shoplist）
```json
[
  [{"text": "🎮 游戏充值", "callback_data": "goods_1"}],
  [{"text": "👑 会员服务", "callback_data": "goods_2"}],
  [{"text": "⬅️ 返回", "callback_data": "back"}]
]
```

#### 3. 商品详情按钮（keyword: goodsinfo）
```json
[
  [{"text": "🛒 立即购买", "callback_data": "goodsbuy_{id}"}],
  [{"text": "ℹ️ 购买须知", "callback_data": "usegoods_{id}"}],
  [{"text": "⬅️ 返回", "callback_data": "shoplist"}]
]
```

#### 4. 支付确认按钮（keyword: confirmorder）
```json
[
  [{"text": "💳 去支付", "callback_data": "gopay_{ordersn}"}],
  [{"text": "❌ 取消订单", "callback_data": "cancel_{ordersn}"}]
]
```

## 🌟 完成！

现在你已经掌握了 Telegram 按钮可视化编辑器的基本使用方法！

- ✅ 创建美观的按钮界面
- ✅ 使用模板快速开发
- ✅ 掌握按钮命名规范
- ✅ 知道如何测试和调试

需要更多帮助？查看完整文档：`telegram_button_visual_editor.md`

