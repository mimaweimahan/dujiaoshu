# Telegram 按钮可视化编辑器使用说明

## 📋 功能概述

本工具为独角数卡系统的 Telegram Bot 按钮管理功能提供了强大的可视化编辑界面，让管理员无需手写 JSON 代码即可轻松创建和管理 Telegram 按钮。

## 🎯 主要特性

### 1. **可视化按钮编辑**
- ✅ 拖拽式界面，直观易用
- ✅ 点击按钮即可编辑内容
- ✅ 支持添加/删除按钮和按钮行
- ✅ 实时生成 JSON 配置

### 2. **双向同步**
- ✅ 可视化编辑器 ↔ JSON 代码双向同步
- ✅ 支持从 JSON 导入现有配置
- ✅ 自动保存为 JSON 格式

### 3. **按钮类型支持**
- ✅ **Inline Keyboard（内联按钮）**: 显示在消息下方的交互按钮
  - 支持 `callback_data`（回调数据）
  - 支持 `url`（外部链接）
- ✅ **Reply Keyboard（回复键盘）**: 替换输入框上方的键盘
  - 直接发送文本

### 4. **实时预览**
- ✅ 可视化预览按钮布局
- ✅ 模拟 Telegram 显示效果

## 📖 使用教程

### 访问路径
```
后台管理 → Buttons → 新增 / 编辑
或直接访问: https://your-domain.com/admin/buttons
```

### 基本操作流程

#### 步骤 1: 填写基本信息
1. **标题**: 按钮组的名称（如：主菜单按钮）
2. **关键词**: 程序调用标识（如：start, shoplist, my）
3. **语言**: 选择适用的语言（zh-CN, zh-TW 等）
4. **消息内容**: 发送给用户的文本
5. **消息模式**: HTML / MarkDown / MarkDownV2
6. **展示URL预览**: 是否在消息中显示链接预览

#### 步骤 2: 选择按钮类型
- **Inline Keyboard**: 用于交互式菜单、商品列表、支付选择等
- **Reply Keyboard**: 用于主菜单、常用功能快捷键等

#### 步骤 3: 使用可视化编辑器创建按钮

##### 方式一：从零开始创建
1. 点击 **"添加新行"** 按钮
2. 自动创建一个新按钮，点击该按钮进行编辑
3. 在弹出的对话框中填写：
   - **按钮文字**: 显示给用户的文字
   - **回调数据**: callback_data（如：shoplist, goods_123）
   - **URL链接**: 可选，设置后按钮变为链接按钮
4. 点击 **"添加按钮"** 可在同一行添加更多按钮
5. 重复步骤 1-4 创建更多行

##### 方式二：从 JSON 导入
1. 在 **"按钮JSON配置"** 字段粘贴现有的 JSON 代码
2. 点击 **"从JSON导入"** 按钮
3. 编辑器会自动解析并显示按钮

#### 步骤 4: 预览效果
- 点击 **"预览效果"** 按钮查看按钮布局
- 预览区会模拟 Telegram 的显示效果

#### 步骤 5: 保存配置
- 点击页面底部的 **"提交"** 按钮保存

## 💡 使用示例

### 示例 1: 创建主菜单按钮（Reply Keyboard）

**配置信息:**
- 标题: 主菜单
- 关键词: start
- 语言: zh-CN
- 消息内容: 欢迎使用！请选择功能：
- 按钮类型: Reply Keyboard

**按钮布局:**
```
第 1 行: [🛍 商品列表] [👤 个人中心]
第 2 行: [💰 余额充值] [📋 订单查询]
第 3 行: [❓ 使用帮助] [🌐 语言设置]
```

**生成的 JSON:**
```json
[
  [
    {"text": "🛍 商品列表"},
    {"text": "👤 个人中心"}
  ],
  [
    {"text": "💰 余额充值"},
    {"text": "📋 订单查询"}
  ],
  [
    {"text": "❓ 使用帮助"},
    {"text": "🌐 语言设置"}
  ]
]
```

### 示例 2: 创建商品列表按钮（Inline Keyboard）

**配置信息:**
- 标题: 商品分类
- 关键词: shoplist
- 语言: zh-CN
- 消息内容: 请选择商品分类：
- 按钮类型: Inline Keyboard

**按钮布局:**
```
第 1 行: [游戏充值]
第 2 行: [会员服务]
第 3 行: [数字产品]
第 4 行: [❌ 关闭]
```

**生成的 JSON:**
```json
[
  [
    {"text": "游戏充值", "callback_data": "goods_1"}
  ],
  [
    {"text": "会员服务", "callback_data": "goods_2"}
  ],
  [
    {"text": "数字产品", "callback_data": "goods_3"}
  ],
  [
    {"text": "❌ 关闭", "callback_data": "close"}
  ]
]
```

### 示例 3: 创建带链接的按钮

**按钮配置:**
```json
[
  [
    {"text": "📖 查看文档", "url": "https://github.com/your-repo"},
    {"text": "💬 加入群组", "url": "https://t.me/your-group"}
  ],
  [
    {"text": "返回", "callback_data": "back"}
  ]
]
```

## 🔧 高级功能

### 1. 变量替换
在消息内容中可以使用变量，系统会自动替换：

```
欢迎 {username}！
您的余额：{amount} 元
订单号：{ordersn}
商品名称：{gd_name}
支付方式：{paytype}
支付金额：{payamount}
```

### 2. JSON 格式说明

#### Inline Keyboard 格式
```json
[
  [
    {"text": "按钮文字", "callback_data": "回调数据"}
  ],
  [
    {"text": "链接按钮", "url": "https://example.com"}
  ]
]
```

#### Reply Keyboard 格式
```json
[
  [
    {"text": "按钮1"},
    {"text": "按钮2"}
  ],
  [
    {"text": "按钮3"}
  ]
]
```

### 3. 按钮行布局建议
- **每行 1-2 个按钮**: 适合主要操作
- **每行 3 个按钮**: 适合选项较多的情况
- **单独一行**: 用于"返回"、"关闭"等次要操作

## ⚠️ 注意事项

### 1. 按钮文字限制
- Telegram 对按钮文字长度有限制
- 建议每个按钮文字不超过 20 个字符
- 使用 emoji 可以让按钮更直观

### 2. Callback Data 命名规范
- 使用小写字母和下划线
- 建议格式：`action_param`（如：`goods_123`, `pay_456`）
- 要与 `ButtonUtil.php` 中的方法名对应

### 3. 按钮行数限制
- Inline Keyboard: 建议不超过 8 行
- Reply Keyboard: 建议不超过 6 行
- 过多的按钮会影响用户体验

### 4. URL 按钮规则
- URL 必须以 `http://` 或 `https://` 开头
- URL 按钮不能设置 callback_data
- 点击 URL 按钮会在浏览器中打开链接

## 🐛 常见问题

### Q1: 为什么保存后按钮没有显示？
**A:** 检查以下几点：
1. JSON 格式是否正确
2. `keyword` 是否与代码中调用的一致
3. `lang` 语言设置是否正确
4. 清除浏览器缓存后重试

### Q2: 如何修改现有按钮？
**A:** 
1. 进入编辑页面
2. 编辑器会自动导入现有的 JSON 配置
3. 点击按钮进行修改
4. 保存即可

### Q3: 按钮点击后没有反应？
**A:** 
1. 确认 `callback_data` 在 `ButtonUtil.php` 中有对应的方法
2. 检查 Telegram Bot Token 是否配置正确
3. 查看后台日志排查错误

### Q4: 如何复制按钮配置？
**A:** 
1. 打开要复制的按钮编辑页面
2. 复制 "按钮JSON配置" 字段的内容
3. 在新建页面粘贴即可

## 📚 相关文件

- **控制器**: `app/Admin/Controllers/ButtonController.php`
- **模型**: `app/Models/Button.php`
- **服务层**: `app/Service/ButtonService.php`
- **业务逻辑**: `app/Util/ButtonUtil.php`
- **Bot 控制器**: `app/Http/Controllers/Home/BotController.php`

## 🔄 与系统集成

### 在代码中调用按钮

```php
// 在 ButtonUtil.php 或 BotController.php 中
$buttonInfo = $this->buttonService->withButtonData("keyword", $userInfo["lang"]);

// 返回按钮配置
return [
    "content" => $buttonInfo["content"],
    "mode" => $buttonInfo["mode"],
    "is_show" => $buttonInfo["is_show"],
    "button" => json_decode($buttonInfo["button_json"], true)
];
```

### 添加新的按钮功能

1. 在数据库中创建按钮配置（使用可视化编辑器）
2. 在 `ButtonUtil.php` 中添加对应的方法：

```php
// 示例：添加一个新功能按钮
public function myNewFeature($update, $bot) {
    $userInfo = Util::getUserTelegramId($update->getCallbackQuery()->getMessage()->getChat()->getId());
    $buttonInfo = $this->buttonService->withButtonData("my_new_feature", $userInfo["lang"]);
    
    // 处理业务逻辑
    // ...
    
    return $this->_return(
        $buttonInfo["content"],
        $buttonInfo["mode"],
        $buttonInfo["is_show"],
        json_decode($buttonInfo["button_json"], true)
    );
}
```

## 🎉 总结

Telegram 按钮可视化编辑器让按钮管理变得简单高效：
- ✅ 无需手写 JSON 代码
- ✅ 所见即所得的编辑体验
- ✅ 实时预览效果
- ✅ 支持双向同步
- ✅ 适合各种业务场景

如有任何问题，请参考本文档或查看相关代码文件。

