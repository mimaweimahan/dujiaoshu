<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class listentrx extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'listentrx';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'TRX到账监听命令，用于检查待支付的TRX订单状态并自动确认到账';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // 获取Tronscan API密钥配置
        $tronscanApiKey = dujiaoka_config_get("tronscan_api");

        // 检查是否配置了API密钥
        if (empty($tronscanApiKey)) {
            $this->error('Tronscan API密钥未配置，请在系统设置中配置tronscan_api');
            return;
        }

            // 获取能量监听地址
            $energyAddress = dujiaoka_config_get("energy_address");

            if (empty($energyAddress)) {
                $this->error('能量地址未配置，请在系统设置中配置energy_address');
                return;
            }

        $this->info('╔════════════════════════════════════════════════════════════╗');
        $this->info('║         🚀 TRX/USDT 持续监听程序已启动                    ║');
        $this->info('╚════════════════════════════════════════════════════════════╝');
        $this->info("监听地址: {$energyAddress}");
        $this->info('监听间隔: 30秒');
        $this->info('按 Ctrl+C 可停止监听');
        $this->info('');

        // 循环计数器
        $loopCount = 0;

        // 无限循环，持续监听
        while (true) {
            try {
                $loopCount++;
                $this->info("━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━");
                $this->info("📊 第 {$loopCount} 次监听检查 - " . date('Y-m-d H:i:s'));
                $this->info("━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━");

                // 1. 获取并显示余额信息
                $this->displayBalances($energyAddress, $tronscanApiKey);

                // 2. 监听地址的交易
            $this->monitorAddressTransactions($energyAddress, $tronscanApiKey);

                $this->info("✅ 本次检查完成");
                $this->info("");

        } catch (\Exception $e) {
                $this->error('❌ TRX监听出错: ' . $e->getMessage());
            \Log::error('TRX监听出错', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            }

            // 等待30秒后继续下一次监听
            $this->info("⏳ 等待30秒后进行下一次检查...");
            $this->info("");
            sleep(30);
        }
    }

    /**
     * 显示地址余额信息
     *
     * @param string $address TRX地址
     * @param string $apiKey Tronscan API密钥
     */
    private function displayBalances($address, $apiKey)
    {
        try {
            $this->info("💰 正在获取余额信息...");

            // 获取TRX余额
            $trxBalance = $this->getTrxBalance($address, $apiKey);

            // 获取USDT余额
            $usdtBalance = $this->getUsdtBalance($address, $apiKey);

            // 美化输出余额信息
            $this->info("┌─────────────────────────────────────────┐");
            $this->info("│  💎 TRX余额:  " . str_pad(number_format($trxBalance, 6), 20, ' ', STR_PAD_LEFT) . " TRX  │");
            $this->info("│  💵 USDT余额: " . str_pad(number_format($usdtBalance, 6), 20, ' ', STR_PAD_LEFT) . " USDT │");
            $this->info("└─────────────────────────────────────────┘");
            $this->info("");

        } catch (\Exception $e) {
            $this->warn("⚠️ 获取余额信息失败: " . $e->getMessage());
            \Log::warning('获取TRX/USDT余额失败', [
                'address' => $address,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * 获取TRX余额
     *
     * @param string $address TRX地址
     * @param string $apiKey Tronscan API密钥
     * @return float TRX余额
     */
    private function getTrxBalance($address, $apiKey)
    {
        try {
            // Tronscan API获取账户信息接口
            $apiUrl = "https://apilist.tronscanapi.com/api/account";

            // 构建请求参数
            $params = [
                'address' => $address
            ];

            // 构建请求头
            $headers = [
                'TRON-PRO-API-KEY: ' . $apiKey,
                'Content-Type: application/json'
            ];

            // 发送HTTP请求
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $apiUrl . '?' . http_build_query($params));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            if (curl_error($ch)) {
                throw new \Exception('Curl错误: ' . curl_error($ch));
            }

            curl_close($ch);

            if ($httpCode !== 200) {
                throw new \Exception("Tronscan API请求失败，HTTP状态码: {$httpCode}");
            }

            $data = json_decode($response, true);

            // 获取余额（单位：sun，1 TRX = 1,000,000 sun）
            if (isset($data['balance'])) {
                return $data['balance'] / 1000000;
            }

            return 0;

        } catch (\Exception $e) {
            throw new \Exception('获取TRX余额失败: ' . $e->getMessage());
        }
    }

    /**
     * 获取USDT-TRC20余额
     *
     * @param string $address TRX地址
     * @param string $apiKey Tronscan API密钥
     * @return float USDT余额
     */
    private function getUsdtBalance($address, $apiKey)
    {
        try {
            // USDT-TRC20合约地址
            $usdtContractAddress = 'TR7NHqjeKQxGTCi8q8ZY4pL8otSzgjLj6t';

            // Tronscan API获取TRC20代币余额接口
            $apiUrl = "https://apilist.tronscanapi.com/api/account/tokens";

            // 构建请求参数
            $params = [
                'address' => $address,
                'start' => 0,
                'limit' => 20
            ];

            // 构建请求头
            $headers = [
                'TRON-PRO-API-KEY: ' . $apiKey,
                'Content-Type: application/json'
            ];

            // 发送HTTP请求
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $apiUrl . '?' . http_build_query($params));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            if (curl_error($ch)) {
                throw new \Exception('Curl错误: ' . curl_error($ch));
            }

            curl_close($ch);

            if ($httpCode !== 200) {
                throw new \Exception("Tronscan API请求失败，HTTP状态码: {$httpCode}");
            }

            $data = json_decode($response, true);

            // 查找USDT代币余额
            if (isset($data['data']) && is_array($data['data'])) {
                foreach ($data['data'] as $token) {
                    // 匹配USDT合约地址
                    if (isset($token['tokenId']) && $token['tokenId'] === $usdtContractAddress) {
                        // USDT有6位小数
                        $balance = isset($token['balance']) ? $token['balance'] : 0;
                        $decimals = isset($token['tokenDecimal']) ? $token['tokenDecimal'] : 6;
                        return $balance / pow(10, $decimals);
                    }
                }
            }

            return 0;

        } catch (\Exception $e) {
            throw new \Exception('获取USDT余额失败: ' . $e->getMessage());
        }
    }

    /**
     * 监听指定地址的交易
     *
     * @param string $address
     * @param string $apiKey
     */
    private function monitorAddressTransactions($address, $apiKey)
    {
        try {
            $this->info("🔍 正在检查新交易...");

            // 获取最后处理的交易时间戳
            $lastProcessedTime = $this->getLastProcessedTime($address);
            $lastProcessedDate = date('Y-m-d H:i:s', $lastProcessedTime / 1000);

            // 查询地址的最新交易记录
            $transactions = $this->getTrxTransactions($address, $apiKey);

            if (!$transactions) {
                $this->warn("⚠️ 无法获取交易记录");
                return;
            }

            $this->info("📋 已获取到 " . count($transactions) . " 条最近交易");
            $this->info("⏰ 上次检查时间: {$lastProcessedDate}");

            // 过滤新交易（时间戳大于最后处理时间）
            $newTransactions = array_filter($transactions, function($tx) use ($lastProcessedTime) {
                return $tx['timestamp'] > $lastProcessedTime;
            });

            if (empty($newTransactions)) {
                $this->info("✓ 暂无新交易");
                return;
            }

            $this->info("━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━");
            $this->info("🎉 发现 " . count($newTransactions) . " 笔新交易！");
            $this->info("━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━");

            // 处理每笔新交易
            foreach ($newTransactions as $transaction) {
                $this->processNewTransaction($address, $transaction);
            }

            // 更新最后处理时间
            $latestTimestamp = max(array_column($newTransactions, 'timestamp'));
            $this->updateLastProcessedTime($address, $latestTimestamp);

        } catch (\Exception $e) {
            $this->error("❌ 监听交易时出错: " . $e->getMessage());
            \Log::error('TRX地址监听出错', [
                'address' => $address,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * 验证TRX地址格式
     *
     * @param string $address
     * @return bool
     */
    private function isValidTrxAddress($address)
    {
        // TRON地址通常以T开头，长度为34位
        return preg_match('/^T[0-9A-Za-z]{33}$/', $address);
    }

    /**
     * 获取最后处理的交易时间戳
     *
     * @param string $address
     * @return int
     */
    private function getLastProcessedTime($address)
    {
        // 使用缓存存储最后处理时间
        $cacheKey = 'trx_monitor_last_time_' . md5($address);
        $timestamp = \Cache::get($cacheKey);

        if ($timestamp) {
            return (int) $timestamp;
        }

        // 如果缓存不存在，返回24小时前的时间戳（毫秒）
        return (time() - 86400) * 1000;
    }

    /**
     * 更新最后处理的交易时间戳
     *
     * @param string $address
     * @param int $timestamp
     */
    private function updateLastProcessedTime($address, $timestamp)
    {
        // 更新缓存中的最后处理时间（缓存7天）
        $cacheKey = 'trx_monitor_last_time_' . md5($address);
        \Cache::put($cacheKey, $timestamp, 60 * 24 * 7); // 7天过期
    }

    /**
     * 检查交易是否已被处理过
     *
     * @param string $txHash
     * @return bool
     */
    private function isTransactionProcessed($txHash)
    {
        $cacheKey = 'trx_processed_' . $txHash;
        return \Cache::has($cacheKey);
    }

    /**
     * 标记交易为已处理
     *
     * @param string $txHash
     */
    private function markTransactionAsProcessed($txHash)
    {
        $cacheKey = 'trx_processed_' . $txHash;
        \Cache::put($cacheKey, true, 60 * 24 * 30); // 30天过期
    }

    /**
     * 处理新发现的交易
     *
     * @param string $address
     * @param array $transaction
     */
    private function processNewTransaction($address, $transaction)
    {
        try {
            // 从 hash 字段获取交易哈希
            $txHash = $transaction['hash'] ?? '';

            // 如果还是获取不到，输出完整数据帮助调试
            if (empty($txHash)) {
                $this->warn("⚠️ 无法获取交易哈希，输出完整数据进行调试：");
                $this->info("");

                ob_start();
                print_r($transaction);
                $arrayOutput = ob_get_clean();
                $lines = explode("\n", $arrayOutput);
                foreach ($lines as $line) {
                    $this->info("  " . $line);
                }

                $this->info("");
                return;
            }

            $txHashShort = substr($txHash, 0, 16) . '...';

            $this->info("🔍 正在处理交易: {$txHashShort}");
            $this->info("   完整哈希: {$txHash}");

            // 检查交易是否成功
            $contractRet = $transaction['contractRet'] ?? 'UNKNOWN';
            if ($contractRet !== 'SUCCESS') {
                $this->warn("  ⊗ 跳过: 交易状态不是SUCCESS (状态: {$contractRet})");
                return;
            }
            $this->info("  ✓ 交易状态验证通过 (SUCCESS)");

            // 检查是否为TRX转账交易
            if (!$this->isTrxTransfer($transaction)) {
                $transactionType = $transaction['raw_data']['contract'][0]['type'] ?? 'UNKNOWN';
                $this->warn("  ⊗ 跳过: 不是TRX转账交易 (类型: {$transactionType})");

                // 输出完整的交易数据数组，方便分析数据结构
                $this->info("");
                $this->info("  ╔════════════════════════════════════════════════════════════╗");
                $this->info("  ║  📋 完整交易数据 - 请复制以下内容提供给开发者           ║");
                $this->info("  ╚════════════════════════════════════════════════════════════╝");
                $this->info("");

                // 输出完整的交易数组（使用 var_export 更清晰）
                $this->info("  【开始】交易数据数组：");
                $this->info("");

                // 使用 print_r 输出更易读的格式
                ob_start();
                print_r($transaction);
                $arrayOutput = ob_get_clean();

                $lines = explode("\n", $arrayOutput);
                foreach ($lines as $line) {
                    $this->info("  " . $line);
                }

                $this->info("");
                $this->info("  【结束】交易数据数组");
                $this->info("");
                $this->info("  ────────────────────────────────────────────────────────────");
                $this->info("  JSON格式（备用）:");
                $this->info("  ────────────────────────────────────────────────────────────");
                $this->info("");

                // 同时输出JSON格式
                $jsonData = json_encode($transaction, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
                $jsonLines = explode("\n", $jsonData);
                // 限制输出前100行，避免太长
                $displayLines = array_slice($jsonLines, 0, 100);
                foreach ($displayLines as $line) {
                    $this->info("  " . $line);
                }

                if (count($jsonLines) > 100) {
                    $this->info("  ... (还有 " . (count($jsonLines) - 100) . " 行数据)");
                }

                $this->info("");
                $this->info("  ════════════════════════════════════════════════════════════");
                $this->info("");

                return;
            }
            $this->info("  ✓ 交易类型验证通过 (TRX转账)");

            // 检查是否是接收交易（不是发送交易）
            $receivingCheck = $this->isReceivingTransaction($transaction, $address);

            if (!$receivingCheck) {
                // 获取地址信息用于调试
                $fromAddr = $transaction['ownerAddress'] ?? 'unknown';
                $toAddr = $transaction['toAddress'] ?? 'unknown';

                $this->warn("  ⊗ 跳过: 这是发送交易，不是接收交易");
                $this->info("     监听地址: {$address}");
                $this->info("     付款地址: {$fromAddr}");
                $this->info("     收款地址: {$toAddr}");
                $this->info("     → 监听地址 = 付款地址，说明这是我们发出去的交易，忽略");
                $this->info("");
                return;
            }
            $this->info("  ✓ 交易方向验证通过 (接收交易，监听地址 = 收款地址)");

            // 检查交易是否已被处理过
            if ($this->isTransactionProcessed($txHash)) {
                $this->warn("  ⊗ 跳过: 该交易已处理过 (防重复)");
                return;
            }
            $this->info("  ✓ 防重复验证通过 (首次处理)");

            // 获取交易金额
            $amountRaw = $transaction['amount'] ?? 'null'; // 原始值
            $amount = $this->getTransactionAmount($transaction);

            if ($amount === null || $amount <= 0) {
                $this->warn("  ⊗ 跳过: 交易金额无效");
                $this->warn("     原始金额: {$amountRaw}");
                $this->warn("     转换后金额: " . ($amount ?? 'null') . " TRX");
                return;
            }
            $this->info("  ✓ 金额验证通过");
            $this->info("     原始值: {$amountRaw} sun");
            $this->info("     TRX值: {$amount} TRX");
            $this->info("");

            // 美化输出交易信息
            $this->info("");
            $this->info("┏━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┓");
            $this->info("┃  💰 TRX到账通知                                   ┃");
            $this->info("┣━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┫");
            $this->info("┃  金额: " . str_pad(number_format($amount, 6) . " TRX", 44, ' ', STR_PAD_RIGHT) . "┃");
            $this->info("┃  哈希: " . substr($txHash, 0, 40) . "... ┃");
            $this->info("┗━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┛");
            $this->info("");

            // 标记交易为已处理
            $this->markTransactionAsProcessed($txHash);

            // ===============================================
            // 🎯 在这里处理监听到的TRX到账数据
            // ===============================================
            $this->handleTrxReceived($address, $amount, $txHash, $transaction);

        } catch (\Exception $e) {
            $this->error("处理交易时出错: " . $e->getMessage());
            \Log::error('TRX交易处理出错', [
                'address' => $address,
                'transaction' => $transaction,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * 🎯 处理TRX到账的核心业务逻辑
     *
     * 这里是您需要编写具体业务处理逻辑的地方！
     *
     * @param string $address 收款地址
     * @param float $amount 到账金额（TRX）
     * @param string $txHash 交易哈希
     * @param array $transaction 完整的交易数据
     */
    private function handleTrxReceived($address, $amount, $txHash, $transaction)
    {
        $this->info("📝 开始处理业务逻辑...");

        try {
            // 获取区块时间戳
            $blockTimestamp = $transaction['timestamp'] ?? 0;

            // 根据实际数据结构获取地址
            $fromAddress = $transaction['ownerAddress'] ?? ''; // 付款地址
            $toAddress = $transaction['toAddress'] ?? ''; // 收款地址

            // 兼容 contractData 中的地址
            if (empty($fromAddress)) {
                $fromAddress = $transaction['contractData']['owner_address'] ?? '';
            }
            if (empty($toAddress)) {
                $toAddress = $transaction['contractData']['to_address'] ?? '';
            }

            $this->info("");
            $this->info("📊 交易详情:");
            $this->info("  ├─ 付款地址: " . $fromAddress);
            $this->info("  ├─ 收款地址: " . $toAddress);
            $this->info("  ├─ 交易金额: {$amount} TRX");
            $this->info("  ├─ 交易哈希: " . substr($txHash, 0, 20) . "..." . substr($txHash, -20));
            $this->info("  └─ 区块时间: " . date('Y-m-d H:i:s', $blockTimestamp / 1000));

            // 验证付款地址是否有效
            if (empty($fromAddress)) {
                $this->error("  ❌ 无法获取付款地址，跳过处理");
                $this->error("  提示: 付款地址为空，能量无法转出");
                return;
            }

            $this->info("");

            // ===============================================
            // 🔥 在这里添加您的具体业务处理逻辑：
            // ===============================================

            // 例如：
            // 1. 根据金额和地址查找对应的订单
            // 2. 更新订单状态为已支付
            // 3. 发送确认邮件或通知
            // 4. 触发自动发货流程
            // 5. 更新用户余额
            // 6. 记录财务流水
            // 7. 发送webhook通知给第三方系统

            // 示例处理代码（请根据实际需求修改）：
            $this->processBusinessLogic($address, $amount, $txHash, $fromAddress, $blockTimestamp);

            $this->info("✅ 业务逻辑处理完成");
            $this->info("");

        } catch (\Exception $e) {
            $this->error("❌ 处理业务逻辑时出错: " . $e->getMessage());
            \Log::error('TRX到账业务处理失败', [
                'address' => $address,
                'amount' => $amount,
                'tx_hash' => $txHash,
                'error' => $e->getMessage(),
                'transaction' => $transaction
            ]);
        }
    }

    /**
     * 🔥 具体的业务处理逻辑（需要根据实际需求实现）
     *
     * @param string $address 收款地址
     * @param float $amount 到账金额
     * @param string $txHash 交易哈希
     * @param string $fromAddress 付款地址
     * @param int $blockTimestamp 区块时间戳
     */
    private function processBusinessLogic($address, $amount, $txHash, $fromAddress, $blockTimestamp)
    {
        // ===============================================
        // 🎯 TRX能量租赁业务逻辑
        // ===============================================

        $this->info("⚙️ 执行能量转账业务逻辑...");
        $this->info("");

        try {
            // 步骤1: 记录交易日志
            $this->info("  [1/3] 📄 记录交易日志...");
        $this->logTransactionToFile($address, $amount, $txHash, $fromAddress, $blockTimestamp);
            $this->info("        ✓ 日志记录成功");

            // 步骤2: 获取能量购买配置
            $this->info("  [2/3] ⚡ 查询能量配置...");
            $energyConfig = dujiaoka_config_get("energy_buy_config");

            if (empty($energyConfig)) {
                $this->warn("        ⚠️ 未配置能量购买规则 (energy_buy_config)");
                $this->warn("        提示: 请在系统设置中配置，格式如: {\"1.5\":32000,\"3\":64000}");
                return;
            }

            $this->info("        原始配置: " . $energyConfig);

            // 解析JSON配置
            $energyRules = json_decode($energyConfig, true);
            if (!$energyRules || !is_array($energyRules)) {
                $this->error("        ❌ 能量配置格式错误，应为JSON格式");
                $this->error("        当前配置: " . $energyConfig);
                $this->error("        正确格式: {\"1.5\":32000,\"3\":64000}");
                return;
            }

            $this->info("        ✓ 配置加载成功 (共 " . count($energyRules) . " 个套餐)");

            // 步骤3: 匹配TRX金额对应的能量数量
            $this->info("  [3/3] 🔍 匹配能量数量...");
            $this->info("        收到金额: {$amount} TRX");
            $this->info("        可用套餐:");

            $energyCount = null;
            $matchedAmount = null;

            // 遍历配置，查找匹配的金额
            foreach ($energyRules as $requiredTrx => $energyAmount) {
                // 显示每个套餐
                $trxFloat = (float)$requiredTrx;
                $diff = abs((float)$amount - $trxFloat);
                $isMatch = $diff < 0.01;

                $matchSymbol = $isMatch ? '✓' : ' ';
                $this->info("          {$matchSymbol} {$requiredTrx} TRX → " . number_format($energyAmount) . " 能量 (差值: {$diff})");

                // 转换为浮点数进行比较（允许0.01的误差）
                if ($isMatch) {
                    $energyCount = $energyAmount;
                    $matchedAmount = $requiredTrx;
                }
            }

            $this->info("");

            // 如果没有精确匹配
            if ($energyCount === null) {
                $this->warn("        ⚠️ 未找到匹配的能量套餐！");
                $this->warn("        收到金额 {$amount} TRX 不在配置范围内");
                $this->warn("        请确保用户转账的金额与配置完全匹配（误差<0.01）");
                return;
            }

            $this->info("        ✅ 匹配成功: {$matchedAmount} TRX → " . number_format($energyCount) . " 能量");
            $this->info("");

            // 步骤4: 调用能量购买方法
            $this->info("  🚀 开始购买并转出能量...");
            $this->info("");
            $this->info("     👤 付款人地址 (能量接收者): " . $fromAddress);
            $this->info("     🏦 收款地址 (我们自己): {$address}");
            $this->info("     ⚡ 转出能量数量: " . number_format($energyCount));
            $this->info("     💰 收到TRX金额: {$amount} TRX");
            $this->info("");
            $this->info("     ⏳ 正在调用 start_energy_buy({$energyCount}, \"{$fromAddress}\")...");
            $this->info("     → 将能量转给付款人: {$fromAddress}");
            $this->info("");

            // 调用能量购买函数
            // 参数1: 能量数量
            // 参数2: 能量接收地址（付款人地址，不是监听地址）
            try {
                $result = start_energy_buy($energyCount, $fromAddress);

                $this->info("");
                $this->info("     📦 API返回结果: " . (is_string($result) ? $result : json_encode($result, JSON_UNESCAPED_UNICODE)));
                $this->info("");

                // 判断结果
                if ($result) {
                    $this->info("     ✅ 能量转账成功！");
                    $this->info("");

                    // 记录成功日志
                    \Log::info('TRX能量转账成功', [
                        'tx_hash' => $txHash,
                        'from_address' => $fromAddress,
                        'trx_amount' => $amount,
                        'energy_count' => $energyCount,
                        'api_result' => $result
                    ]);
                } else {
                    $this->error("     ❌ 能量转账失败（API返回空或失败）");
                    $this->info("");

                    // 记录失败日志
                    \Log::error('TRX能量转账失败', [
                        'tx_hash' => $txHash,
                        'from_address' => $fromAddress,
                        'trx_amount' => $amount,
                        'energy_count' => $energyCount,
                        'api_result' => $result
                    ]);
                }

            } catch (\Exception $apiException) {
                $this->error("     ❌ 调用 start_energy_buy() 异常: " . $apiException->getMessage());
                $this->info("");

                // 记录异常日志
                \Log::error('start_energy_buy调用异常', [
                    'tx_hash' => $txHash,
                    'from_address' => $fromAddress,
                    'trx_amount' => $amount,
                    'energy_count' => $energyCount,
                    'error' => $apiException->getMessage(),
                    'trace' => $apiException->getTraceAsString()
                ]);
            }

        } catch (\Exception $e) {
            $this->error("     ❌ 处理失败: " . $e->getMessage());
            \Log::error('TRX能量业务处理异常', [
                'error' => $e->getMessage(),
                'tx_hash' => $txHash,
                'amount' => $amount,
                'from_address' => $fromAddress
            ]);
        }
    }

    /**
     * 记录交易到日志文件
     *
     * @param string $address 收款地址
     * @param float $amount 金额
     * @param string $txHash 交易哈希
     * @param string $fromAddress 付款地址
     * @param int $blockTimestamp 区块时间戳
     */
    private function logTransactionToFile($address, $amount, $txHash, $fromAddress, $blockTimestamp)
    {
        $logData = [
            'timestamp' => date('Y-m-d H:i:s'),
            'address' => $address,
            'amount' => $amount,
            'tx_hash' => $txHash,
            'block_timestamp' => $blockTimestamp,
            'from_address' => $fromAddress,
            'to_address' => $address,
            'formatted_time' => date('Y-m-d H:i:s', $blockTimestamp / 1000)
        ];

        // 确保日志目录存在
        $dir = storage_path('logs');
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        // 写入日志文件
        $logFile = $dir . '/trx_transactions_' . date('Y-m-d') . '.log';
        $logLine = json_encode($logData, JSON_UNESCAPED_UNICODE) . "\n";
        file_put_contents($logFile, $logLine, FILE_APPEND | LOCK_EX);
    }

    /**
     * 发送webhook通知
     *
     * @param string $address 收款地址
     * @param float $amount 金额
     * @param string $txHash 交易哈希
     * @param string $fromAddress 付款地址
     * @param int $blockTimestamp 区块时间戳
     */
    private function sendWebhookNotification($address, $amount, $txHash, $fromAddress, $blockTimestamp)
    {
        // 获取webhook URL配置
        $webhookUrl = dujiaoka_config_get('trx_webhook_url');

        if (empty($webhookUrl)) {
            $this->info("        ⊗ 未配置webhook URL，跳过");
            return;
        }

        try {
            // 构建通知数据
            $notifyData = [
                'event' => 'trx_received',
                'address' => $address,
                'amount' => $amount,
                'tx_hash' => $txHash,
                'timestamp' => $blockTimestamp,
                'from_address' => $fromAddress,
                'to_address' => $address,
                'confirmation_time' => date('Y-m-d H:i:s'),
                'formatted_time' => date('Y-m-d H:i:s', $blockTimestamp / 1000)
            ];

            // 发送HTTP POST请求
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $webhookUrl);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($notifyData));
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'User-Agent: DujiaoKa-TRX-Monitor/1.0'
            ]);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($httpCode === 200) {
                $this->info("        ✓ Webhook发送成功 (HTTP 200)");
            } else {
                $this->warn("        ⚠ Webhook发送失败 (HTTP {$httpCode})");
            }

        } catch (\Exception $e) {
            $this->warn("        ⚠ Webhook发送异常: " . $e->getMessage());
        }
    }

    /**
     * 获取TRX地址的交易记录
     *
     * @param string $address
     * @param string $apiKey
     * @return array|null
     */
    private function getTrxTransactions($address, $apiKey)
    {
        // Tronscan API接口地址
        $apiUrl = "https://apilist.tronscanapi.com/api/transaction";

        // 构建请求参数
        $params = [
            'sort' => '-timestamp',
            'count' => 'true',
            'limit' => 50,
            'start' => 0,
            'address' => $address
        ];

        // 构建请求头
        $headers = [
            'TRON-PRO-API-KEY: ' . $apiKey,
            'Content-Type: application/json'
        ];

        // 发送HTTP请求
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiUrl . '?' . http_build_query($params));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if (curl_error($ch)) {
            throw new \Exception('Curl错误: ' . curl_error($ch));
        }

        curl_close($ch);

        if ($httpCode !== 200) {
            throw new \Exception("Tronscan API请求失败，HTTP状态码: {$httpCode}");
        }

        $data = json_decode($response, true);

        if (!$data || !isset($data['data'])) {
            return null;
        }

        // 调试模式：如果需要查看原始数据，取消下面的注释
        // $this->dumpTransactionData($data['data']);

        return $data['data'];
    }

    /**
     * 调试辅助方法：输出交易数据
     *
     * @param array $transactions 交易数组
     */
    private function dumpTransactionData($transactions)
    {
        $this->info("  ╔════════════════════════════════════════════════════════════╗");
        $this->info("  ║  🔍 从Tronscan API获取的原始交易数据                      ║");
        $this->info("  ╚════════════════════════════════════════════════════════════╝");
        $this->info("");
        $this->info("  📊 API返回的交易总数: " . count($transactions));
        $this->info("");

        // 只打印前3笔交易的详细数据（避免输出太多）
        $displayCount = min(3, count($transactions));

        for ($i = 0; $i < $displayCount; $i++) {
            $this->info("  ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━");
            $this->info("  第 " . ($i + 1) . " 笔交易数据:");
            $this->info("  ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━");
            $this->info("");

            // 使用 print_r 输出数组格式
            ob_start();
            print_r($transactions[$i]);
            $arrayOutput = ob_get_clean();

            $lines = explode("\n", $arrayOutput);
            foreach ($lines as $line) {
                $this->info("  " . $line);
            }

            $this->info("");
        }

        if (count($transactions) > $displayCount) {
            $this->info("  ... (还有 " . (count($transactions) - $displayCount) . " 笔交易未显示)");
            $this->info("");
        }

        $this->info("  ════════════════════════════════════════════════════════════");
        $this->info("");
    }

    /**
     * 检查是否是接收交易（不是发送交易）
     *
     * @param array $transaction 交易数据
     * @param string $monitorAddress 监听地址
     * @return bool 如果是接收交易返回true，发送交易返回false
     */
    private function isReceivingTransaction($transaction, $monitorAddress)
    {
        // 根据实际数据结构获取地址
        $toAddress = $transaction['toAddress'] ?? ''; // 收款地址
        $fromAddress = $transaction['ownerAddress'] ?? ''; // 付款地址

        // 如果收款地址等于监听地址，说明是接收交易（别人转给我们）
        if ($toAddress === $monitorAddress) {
            return true;
        }

        // 如果付款地址等于监听地址，说明是发送交易（我们转给别人）
        if ($fromAddress === $monitorAddress) {
            return false;
        }

        // 兼容 contractData 中的地址
        $toAddressAlt = $transaction['contractData']['to_address'] ?? '';
        $fromAddressAlt = $transaction['contractData']['owner_address'] ?? '';

        if ($toAddressAlt === $monitorAddress) {
            return true;
        }

        if ($fromAddressAlt === $monitorAddress) {
            return false;
        }

        // 默认返回true，避免误拦截
        return true;
    }

    /**
     * 检查是否为TRX转账交易
     *
     * @param array $transaction
     * @return bool
     */
    private function isTrxTransfer($transaction)
    {
        // 根据实际数据结构: contractType = 1 表示TRX转账
        $contractType = $transaction['contractType'] ?? null;

        // contractType = 1 就是TRX转账（TransferContract）
        if ($contractType === 1) {
            return true;
        }

        // 兼容其他可能的格式
        if ($contractType === 'TransferContract') {
            return true;
        }

        // 兼容旧的数据结构
        $type = $transaction['raw_data']['contract'][0]['type'] ?? null;
        if ($type === 'TransferContract') {
            return true;
        }

        return false;
    }

    /**
     * 获取交易金额
     *
     * @param array $transaction
     * @return float|null
     */
    private function getTransactionAmount($transaction)
    {
        // 根据实际数据结构: amount 字段的单位是 sun
        // 1 TRX = 1,000,000 sun
        // 例如: amount = 1500000 表示 1.5 TRX

        $amountSun = $transaction['amount'] ?? null;

        // 如果顶层没有，尝试从 contractData 获取
        if ($amountSun === null) {
            $amountSun = $transaction['contractData']['amount'] ?? null;
        }

        // 兼容旧格式（从 raw_data 获取）
        if ($amountSun === null) {
            $amountSun = $transaction['raw_data']['contract'][0]['parameter']['value']['amount'] ?? null;
        }

        if ($amountSun === null) {
            return null;
        }

        // sun 转换为 TRX
        // 1,500,000 sun = 1.5 TRX
        // 3,000,000 sun = 3 TRX
        return $amountSun / 1000000;
    }

}
