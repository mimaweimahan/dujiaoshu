# Telegram Bot 交互元数据平台化方案

## 1. 总体目标

- 在 Telegram 内实现可扩展、可配置、可治理的交互体系，支持命令、回复键盘（Reply Keyboard）、内联按钮（Inline Keyboard）以及富媒体消息。
- 将所有交互元素（按钮、命令、消息模板、动作逻辑）抽象为元数据，存储在数据库中，通过后台可视化配置，实现快速扩展业务场景（如会员开通、TRX 能量兑换等）。
- 保证现有业务逻辑（订单、支付、卡密发货等）复用原有服务层，避免重复实现。

## 2. 核心数据模型

### 2.1 `telegram_components`

- **作用**：定义交互元件的通用属性，用于描述命令、按钮、输入等基础单元。
- **关键字段**：
  - `id`
  - `type`：`command` / `reply_keyboard` / `inline_keyboard` / `input` 等。
  - `identifier`：唯一标识，用于动作映射、版本管理。
  - `label_translations`：JSON，存储多语言文案。
  - `visibility_rules`：JSON，配置可见条件（角色、会员等级、时间段等）。
  - `validation_schema`：JSON Schema，约束输入或回调参数。
  - `lifecycle`：状态、有效期、版本标签等。
  - `created_at` / `updated_at`

### 2.2 `telegram_layouts`

- **作用**：描述元件如何呈现，控制布局、槽位、条件渲染。
- **关键字段**：
  - `id`
  - `slot`：场景标识（如 `main_menu`、`order_detail`、`member_center`）。
  - `component_ids`：按顺序关联多个元件，支持嵌套、复用。
  - `layout_meta`：JSON，记录行列布局、响应式策略、条件渲染等。
  - `created_at` / `updated_at`

### 2.3 `telegram_actions`

- **作用**：绑定业务逻辑，驱动命令或按钮的实际行为。
- **关键字段**：
  - `id`
  - `component_identifier`
  - `action_type`：内部服务、Webhook、工作流、异步任务等。
  - `action_payload`：JSON，配置执行参数。
  - `pre_hooks` / `post_hooks`：执行前后附加逻辑。
  - `version`：支持灰度、回滚、A/B 测试。
  - `created_at` / `updated_at`

### 2.4 `telegram_message_templates`

- **作用**：存储消息体内容及格式，用于向用户返回富文本、媒体消息。
- **关键字段**：
  - `id`
  - `code`
  - `title`
  - `content`
  - `content_format`：`html` / `markdown` / `markdown_v2`。
  - `is_active`
  - `meta`：JSON，记录语言、渠道等。
  - `created_at` / `updated_at`

### 2.5 `telegram_message_assets`

- **作用**：管理富媒体资源（图片、视频、文档等）。
- **关键字段**：
  - `id`
  - `file_id`
  - `type`：`photo` / `video` / `document` 等。
  - `description`
  - `mime_type`
  - `size`
  - `meta`：JSON（多语言、封面等）。
  - `created_at` / `updated_at`

### 2.6 `telegram_message_template_assets`

- **作用**：模板与附件之间的多对多关系表。
- **关键字段**：
  - `template_id`
  - `asset_id`
  - `sort_order`
  - `caption`

### 2.7 `telegram_message_buttons`

- **作用**：为消息模板配置内联按钮。
- **关键字段**：
  - `id`
  - `template_id`
  - `label`
  - `type`：`callback` / `url` / `switch_inline` / `payment` 等。
  - `callback_id`
  - `payload`
  - `url`
  - `row_index` / `col_index`
  - `is_active`
  - `created_at` / `updated_at`

### 2.8 日志表（可选）`telegram_message_logs`

- 记录每次发送的模板、附件、按钮、用户、执行结果等信息，用于审计与问题排查。

## 3. 后台管理能力

- **交互元件管理**：
  - CRUD 操作、复制、版本发布、条件配置。
  - 可视化展示命令、按钮、输入等元件的关系和状态。
- **布局管理**：
  - 通过拖拽或表单配置元件在不同场景的排列方式。
  - 支持灰度发布、定时启用、环境标记（测试/生产）。
- **动作管理**：
  - 为元件绑定执行逻辑，配置执行参数、前后置 Hook。
  - 提供测试入口，模拟执行并查看日志。
- **消息模板管理**：
  - 富文本/Markdown/MarkdownV2 编辑器。
  - 格式校验、渲染预览、草稿/发布管理。
  - 关联富媒体、内联按钮，支持多语言版本。
- **富媒体资源管理**：
  - 上传并缓存 Telegram `file_id`，或管理本地/云端资源。
  - 记录媒体元数据，支持复用与失效校验。
- **预览与测试**：
  - 在后台选择模板、指定测试用户或 chat_id，实时预览发送结果。
  - 记录测试日志，确保上线前验证通过。

## 4. 运行时执行流程

1. **命令/按钮触发**：
   - Telegram 将用户操作回调到 Webhook。
   - `TelegramBotController` 解析请求，交给 `TelegramBotService` 处理。
2. **元件识别与权限校验**：
   - 根据命令或 Callback Data 定位 `identifier`。
   - 判定用户身份、角色、会员等级等是否满足 `visibility_rules`。
3. **执行动作**：
   - 根据 `identifier` 在 `telegram_actions` 中找到匹配记录。
   - 按 `action_type` 执行对应策略：
     - 调用内部服务（如订单创建、会员开通、TRX 兑换）。
     - 请求第三方 API。
     - 派发异步任务或工作流。
   - `pre_hooks` / `post_hooks` 负责额外校验、打点、通知等。
4. **构造响应消息**：
   - 动作返回 `response_template_id` 或动态选择模板。
   - 渲染模板内容（注入变量、格式转义）。
   - 关联附件与内联按钮，生成完整消息体。
5. **发送消息并记录日志**：
   - 调用 Telegram API 发送消息。
   - 写入 `telegram_message_logs`，记录成功/失败状态。
   - 若发送失败，触发告警（如格式校验失败、文件不存在等）。

## 5. 会话状态与流程控制

- `users` 表中新增 `telegram_id`、`telegram_username`、`telegram_language`、`bot_state`、`bot_metadata` 等字段，确保 Telegram 用户与系统用户共用一张表。
- `bot_state`：记录当前所处流程节点。
- `bot_metadata`：JSON，保存临时上下文（如订单参数、验证码校验状态）。
- 状态机由服务层管理，元件可根据状态展示不同按钮或执行不同动作。

## 6. 缓存与发布策略

- 所有元数据加载时使用 Redis 缓存，后台更新后触发事件清除缓存。
- 支持组件/模板的草稿、预发布、定时上线。
- 提供灰度控制：可按用户分组或百分比启用新版本。

## 7. 安全治理

- 表单输入校验：
  - JSON Schema 验证 `payload`、`visibility_rules`、`layout_meta`。
  - 命令/按钮文本长度限制。
- 消息内容安全：
  - HTML 内容白名单过滤。
  - Markdown 转义工具，避免格式注入。
- 敏感操作控制：
  - `extra` 字段可标记二次确认、管理员审批。
  - 支持风控策略，如金额限制、黑名单、频率控制。
- 审计：
  - 所有后台操作记录审计日志，支持版本对比与回滚。

## 8. 监控与告警

- 建立消息发送统计面板：
  - 按模板、按钮、动作维度统计使用频率、失败率、转化率。
- 失败重试机制：
  - 对于网络异常、限流等情况可自动重试。
- 告警渠道：
  - 支持 Email、Telegram 管理群、企业微信等，提示关键错误或高失败率。

## 9. 开发步骤建议

1. 数据库迁移：创建核心数据表及必要索引。
2. 服务层搭建：
   - `TelegramComponentService`
   - `TelegramLayoutService`
   - `TelegramActionService`
   - `TelegramMessageService`
3. 控制器与路由：Webhook 接入、命令路由。
4. 后台界面：
   - 元件、布局、动作、模板、附件等管理页面。
   - 预览与测试工具。
5. 业务落地：
   - 与订单、会员、TRX 兑换等服务对接。
   - 编写 Action 执行器。
6. 缓存、灰度、审计、告警体系。
7. 测试与文档：
   - 单元、集成、端到端测试。
   - 使用手册、运维指南、风控指引。

## 10. 后续扩展方向

- 多渠道支持：同一元数据体系可扩展到其他即时通讯平台（如 WhatsApp、Line、企业微信）。
- 流程编排：引入可视化流程引擎，将复杂业务拆分为节点，通过元数据驱动执行。
- AI 辅助配置：根据用户行为数据，推荐按钮布局、文案优化。
- 自动化运营：结合定时任务、用户画像，实现智能推送、精准营销。

---

此方案以“元数据驱动 + 策略执行”为核心，打通命令、按钮、消息模板与业务动作的全链路，既满足灵活扩展需求，又保证治理、审计与安全控制，适用于长期演进的 Telegram 业务场景。

