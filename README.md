# 🦄 独角数卡 2.0.6 - 数字商品自动销售系统

<div align="center">

![Laravel](https://img.shields.io/badge/Laravel-6.x-red.svg)
![PHP](https://img.shields.io/badge/PHP-7.2.5%2B-blue.svg)
![License](https://img.shields.io/badge/License-MIT-green.svg)
![Version](https://img.shields.io/badge/Version-2.0.6-orange.svg)

一个功能强大的数字商品自动销售系统，基于 Laravel 框架开发

[功能特性](#-功能特性) • [快速开始](#-快速开始) • [文档](#-文档) • [问题反馈](#-问题反馈)

</div>

---

## 📖 项目简介

独角数卡是一个专业的数字商品自动销售系统，支持卡密、账号等虚拟商品的自动化销售。系统采用 Laravel 6.x 框架开发，提供完整的前后台管理、多种支付方式集成、订单管理、用户系统等功能。

### ✨ 核心特性

- 🚀 **自动化销售** - 支持自动发货和手动处理两种模式
- 💳 **多支付集成** - 集成 15+ 种主流支付方式
- 👥 **用户系统** - 完整的注册、登录、邀请、返利系统
- 🎫 **优惠券系统** - 支持百分比、固定金额等多种优惠方式
- 📦 **商品管理** - 商品分类、库存管理、批量导入
- 📊 **订单管理** - 完整的订单生命周期管理
- 🔐 **安全防护** - IP限制、验证码、密码保护等多重安全机制

---

## 🎯 功能特性

### 商品管理
- ✅ 商品分类管理
- ✅ 自动发货/手动处理模式
- ✅ 库存实时管理
- ✅ 最低购买数量限制
- ✅ 商品自定义返利百分比
- ✅ 支付方式限制（不同商品可用不同支付方式）
- ✅ 自选卡密功能
- ✅ 远程图片 URL 支持
- ✅ 商品代理批发功能
- ✅ 商品上新/补货/降价通知

### 订单系统
- ✅ 订单创建与处理
- ✅ 订单状态实时监控
- ✅ 多种订单查询方式（订单号/邮箱/浏览器缓存）
- ✅ 手动补单功能
- ✅ 卡密导出（TXT 格式）
- ✅ 同一 IP 订单限制
- ✅ 订单过期自动处理

### 支付系统
- ✅ **支付宝** - 当面付、PC网站、手机网站
- ✅ **微信支付** - Native、H5、小程序
- ✅ **PayJS** - 微信/支付宝扫码
- ✅ **码支付** - QQ/支付宝/微信
- ✅ **PayPal** - 国际支付
- ✅ **Stripe** - 国际信用卡支付
- ✅ **V免签** - 免签约支付
- ✅ **易支付** - 通用彩虹版
- ✅ **Coinbase** - 加密货币支付
- ✅ **EPUSDT** - USDT 支付
- ✅ **TokenPay** - 区块链代币支付
- ✅ **Binance Pay** - 币安支付
- ✅ **Alpha Pay** - Alpha 支付
- ✅ **钱包余额支付** - 用户余额支付
- ✅ 支付通道费率自定义
- ✅ 强制汇率自定义
- ✅ 支付单位自定义

### 用户系统
- ✅ 用户注册/登录（邮箱、Telegram）
- ✅ 用户中心
- ✅ 余额充值/提现
- ✅ 邀请系统（AFF 推广）
- ✅ 返利中心
- ✅ 修改密码
- ✅ 用户等级系统
- ✅ 订单历史查询

### 优惠券系统
- ✅ 百分比折扣
- ✅ 整体固定金额优惠
- ✅ 每件固定金额优惠
- ✅ 商品关联限制
- ✅ 使用次数限制
- ✅ 有效期管理

### 其他功能
- ✅ 虚拟购买展示（首页随机展示）
- ✅ 文章系统（支持分类和远程缩略图）
- ✅ 卡密管理（导入/导出/下载）
- ✅ 邮件通知模板
- ✅ Telegram 推送
- ✅ API Webhook
- ✅ 极验验证（Geetest）
- ✅ 人机交互密码保护
- ✅ 多语言支持

---

## 🛠 技术栈

### 后端
- **框架**: [Laravel](https://laravel.com/) 6.20.26
- **后台管理**: [Dcat Admin](http://www.dcatadmin.com) 2.x
- **支付集成**: [yansongda/Pay](https://github.com/yansongda/pay) 2.10
- **区块链支付**: [TokenPay](https://github.com/LightCountry/TokenPay)
- **验证码**: [Geetest](https://www.geetest.com/)

### 前端
- **构建工具**: Laravel Mix + Webpack
- **UI 框架**: Dcat Admin
- **模板引擎**: Blade

### 数据库
- **主数据库**: MySQL 5.7+
- **缓存**: Redis
- **IP 数据库**: GeoLite2

### 主要依赖
```json
{
  "laravel/framework": "^6.20.26",
  "dcat/laravel-admin": "2.*",
  "yansongda/pay": "^2.10",
  "stripe/stripe-php": "^7.84",
  "firebase/php-jwt": "^6.10",
  "germey/geetest": "^3.1"
}
```

---

## 📋 系统要求

### PHP 环境要求

**必须安装的扩展：**
- ✅ `fileinfo` 扩展
- ✅ `redis` 扩展
- ✅ `php-cli` 支持（终端执行 `php -v` 测试）
- ✅ 必须开启的函数：`putenv`、`proc_open`、`pcntl_signal`、`pcntl_alarm`

**建议安装的扩展：**
- ⚡ `opcache` 扩展（提升性能）

### 服务器要求
- **PHP**: 7.2.5+ 或 8.0+
- **MySQL**: 5.7+ 或 MariaDB 10.2+
- **Redis**: 3.0+
- **Web 服务器**: Nginx 或 Apache
- **操作系统**: Linux（推荐 Ubuntu 18.04+ 或 CentOS 7+）

> ⚠️ **注意**: 本程序不支持虚拟主机，未在 Windows 服务器上进行测试，请使用 Linux 服务器完成搭建。

---

## 🚀 快速开始

### 1. 克隆项目

```bash
git clone https://github.com/your-username/dujiaoka.git
cd dujiaoka
```

### 2. 安装依赖

```bash
# 安装 PHP 依赖
composer install

# 安装前端依赖（可选）
npm install
npm run production
```

### 3. 环境配置

```bash
# 复制环境配置文件
cp .env.example .env

# 生成应用密钥
php artisan key:generate
```

编辑 `.env` 文件，配置数据库和 Redis：

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=dujiaoka
DB_USERNAME=your_username
DB_PASSWORD=your_password

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379
```

### 4. 数据库迁移

```bash
# 运行数据库迁移
php artisan migrate

# 导入初始数据（如果有 SQL 文件）
mysql -u your_username -p dujiaoka < database/sql/install.sql
```

### 5. 设置权限

```bash
# 设置存储目录权限
chmod -R 755 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

### 6. 配置 Web 服务器

#### Nginx 配置示例

```nginx
server {
    listen 80;
    server_name your-domain.com;
    root /path/to/dujiaoka/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php7.4-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

### 7. 访问安装页面

访问 `http://your-domain.com/install` 完成系统安装，或直接访问后台：

- **后台地址**: `http://your-domain.com/admin`
- **默认账号**: `admin`
- **默认密码**: `admin`

> ⚠️ **重要**: 安装完成后请立即修改默认管理员密码！

---

## 📁 项目结构

```
dujiaoka/
├── app/                      # 应用核心代码
│   ├── Admin/                # 后台管理模块（Dcat Admin）
│   │   ├── Controllers/      # 后台控制器
│   │   ├── Forms/            # 表单组件
│   │   └── Repositories/     # 数据仓库
│   ├── Http/
│   │   └── Controllers/
│   │       ├── Home/         # 前台控制器
│   │       └── Pay/          # 支付控制器
│   ├── Models/               # 数据模型
│   ├── Service/              # 业务逻辑服务层
│   ├── Jobs/                 # 队列任务
│   ├── Events/               # 事件
│   ├── Listeners/            # 事件监听器
│   └── Helpers/              # 辅助函数
├── config/                   # 配置文件
├── database/                 # 数据库相关
│   ├── migrations/           # 数据库迁移
│   └── sql/                  # SQL 文件
├── public/                   # 公共资源目录
├── resources/                # 资源文件
│   ├── views/                # 视图模板
│   └── lang/                 # 语言包
├── routes/                    # 路由定义
│   ├── common/               # 通用路由
│   │   ├── web.php           # 前台路由
│   │   └── pay.php           # 支付路由
│   └── api.php               # API 路由
├── storage/                   # 存储目录
├── tests/                     # 测试文件
└── vendor/                    # Composer 依赖
```

---

## 🔧 配置说明

### 支付方式配置

系统支持多种支付方式，每种支付方式需要在后台进行配置。主要配置项包括：

- 支付方式名称
- 支付接口参数（AppID、密钥等）
- 支付方式（跳转/扫码）
- 适用客户端（PC/移动/通用）
- 支付费率设置
- 强制汇率设置

### 系统配置

在后台 `系统设置` 中可以配置：

- 网站基本信息
- 邮件服务配置
- Telegram 推送配置
- API Webhook 配置
- 安全设置（IP限制、验证码等）
- 货币单位设置

---

## 📚 使用文档

### 基础操作

1. **商品管理**
   - 创建商品分类
   - 添加商品（设置价格、库存、发货方式等）
   - 导入卡密

2. **订单处理**
   - 查看订单列表
   - 处理待处理订单
   - 手动补单
   - 导出卡密

3. **用户管理**
   - 查看用户列表
   - 管理用户余额
   - 处理提现申请

4. **支付配置**
   - 添加支付方式
   - 配置支付参数
   - 设置支付费率

### 高级功能

- **优惠券系统**: 创建优惠券并关联商品
- **邀请系统**: 设置邀请返利比例
- **文章系统**: 发布公告和帮助文档
- **批发功能**: 设置商品批发价格

---

## 🔐 安全建议

1. **修改默认密码**: 安装后立即修改默认管理员密码
2. **配置 HTTPS**: 使用 SSL 证书保护数据传输
3. **定期备份**: 定期备份数据库和重要文件
4. **更新系统**: 及时更新 Laravel 和依赖包
5. **权限控制**: 合理设置文件目录权限
6. **防火墙配置**: 配置服务器防火墙规则

---

## 🐛 常见问题

### 1. 安装时数据库连接失败
- 检查数据库配置是否正确
- 确认数据库用户有足够权限
- 检查防火墙是否允许连接

### 2. 支付回调失败
- 检查支付接口配置是否正确
- 确认服务器可以接收外部回调
- 查看日志文件排查问题

### 3. 卡密无法自动发货
- 检查商品是否设置为自动发货
- 确认商品有足够的卡密库存
- 查看订单处理日志

更多问题请参考 [常见问题文档](https://github.com/assimon/dujiaoka/wiki/problems)

---

## 🤝 贡献指南

我们欢迎所有形式的贡献！

1. Fork 本仓库
2. 创建特性分支 (`git checkout -b feature/AmazingFeature`)
3. 提交更改 (`git commit -m 'Add some AmazingFeature'`)
4. 推送到分支 (`git push origin feature/AmazingFeature`)
5. 开启 Pull Request

---

## 📞 交流与支持

- **Telegram 群组**: [加入交流群](https://t.me/dujiaouser)
- **问题反馈**: [GitHub Issues](https://github.com/your-username/dujiaoka/issues)
- **原版作者**: [Assimon](https://github.com/assimon)

---

## 🙏 致谢

### 项目原版作者
- [Assimon](https://github.com/assimon) - 独角数卡原作者

### 核心贡献者
- [iLay1678](https://github.com/iLay1678) - 核心功能开发

### 模板贡献者
- [Julyssn](https://github.com/Julyssn) - `luna` 模板作者
- [bimoe](https://github.com/bimoe) - `hyper` 模板作者

### 开源项目
- [Laravel](https://github.com/laravel/laravel) - PHP 框架
- [Dcat Admin](http://www.dcatadmin.com) - 后台管理框架
- [yansongda/Pay](https://github.com/yansongda/pay) - 支付集成
- [GeoLite2](https://dev.maxmind.com/geoip/geolite2-free-geolocation-data) - IP 数据库

感谢以上所有开源项目及贡献者！

---

## 📄 许可证

本项目采用 [MIT License](https://opensource.org/licenses/MIT) 许可证。

```
MIT License

Copyright (c) 2021-2024 独角数卡

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
```

This product includes GeoLite2 data created by MaxMind, available from [https://www.maxmind.com](https://www.maxmind.com)

---

## ⚠️ 免责声明

独角数卡是一款用于学习 PHP 搭建自动化销售系统的程序案例，仅供学习交流使用。

**严禁用于任何违反中华人民共和国（含台湾省）或使用者所在地区法律法规的用途。**

因为作者仅完成代码的开发和开源活动（开源即任何人都可以下载使用），从未参与用户的任何运营和盈利活动。且不知晓用户后续将程序源代码用于何种用途，故用户使用过程中所带来的任何法律责任即由用户自己承担。

---

<div align="center">

**如果这个项目对你有帮助，请给一个 ⭐ Star！**

Made with ❤️ by 独角数卡团队

</div>
