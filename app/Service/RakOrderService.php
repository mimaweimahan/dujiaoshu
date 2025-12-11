<?php

namespace App\Service;

use App\Models\Order;
use App\Service\RakApiClient;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

/**
 * Rak 订单处理服务
 * 
 * @package App\Service
 */
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
            // 检查是否启用 Rak
            if (!config('rak.enabled', false)) {
                Log::info('Rak 功能未启用', ['order_sn' => $order->order_sn]);
                return false;
            }

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

            // 验证必要参数
            if (empty($rakConfig['sample_id']) || empty($rakConfig['config_options_data'])) {
                Log::error('Rak 订单配置参数不完整', [
                    'order_sn' => $order->order_sn,
                    'config' => $rakConfig,
                ]);
                return false;
            }

            // 调用 Rak API 创建订单
            $rakOrderResult = $this->rakApiClient->createOrder(
                $rakConfig['sample_id'],
                $rakConfig['config_options_data'],
                $rakConfig['billing_cycle'] ?? 'Monthly',
                $order->buy_amount ?? 1,
                $rakConfig['discount_ids'] ?? null
            );

            if (!$rakOrderResult) {
                Log::error('Rak API 创建订单失败', ['order_sn' => $order->order_sn]);
                return false;
            }

            // 检查 API 响应是否成功
            if (!isset($rakOrderResult['order_result']) || !isset($rakOrderResult['pay_result'])) {
                Log::error('Rak API 响应格式错误', [
                    'order_sn' => $order->order_sn,
                    'response' => $rakOrderResult,
                ]);
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
     * 检查订单是否为 Rak 商品（公共方法）
     *
     * @param Order $order
     * @return bool
     */
    public function isRakProduct(Order $order): bool
    {
        if (!$order->goods_id || $order->goods_id == 0) {
            return false;
        }

        $goods = $order->goods;
        if (!$goods) {
            return false;
        }
        
        // 方式1：检查商品名称或描述中是否包含 Rak 关键词
        $rakKeywords = ['rak', 'raksmart', '云服务器', '云机'];
        $goodsName = strtolower($goods->gd_name . ' ' . ($goods->gd_description ?? ''));
        
        foreach ($rakKeywords as $keyword) {
            if (strpos($goodsName, strtolower($keyword)) !== false) {
                return true;
            }
        }
        
        // 方式2：检查订单的 other_input 字段中是否包含 rak 配置
        if (!empty($order->other_input)) {
            $otherInput = json_decode($order->other_input, true);
            if (is_array($otherInput) && isset($otherInput['rak'])) {
                return true;
            }
        }
        
        // 方式3：检查商品的自定义字段（如果商品表有扩展字段）
        // 这里可以根据实际需求扩展
        
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
        if (!empty($order->other_input)) {
            $config = json_decode($order->other_input, true);
            if (is_array($config) && isset($config['rak'])) {
                return $config['rak'];
            }
        }
        
        // 方式2：从商品的自定义字段获取（如果商品表有扩展字段）
        // 这里可以根据实际需求扩展
        
        // 方式3：从订单备注中解析（如果备注字段包含 JSON）
        if (!empty($order->info)) {
            $info = json_decode($order->info, true);
            if (is_array($info) && isset($info['rak'])) {
                return $info['rak'];
            }
        }
        
        return null;
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
            $invoicePaid = $rakOrderResult['pay_result']['data']['invoicepaid'] ?? 'false';
            
            // 构建发货信息
            $deliveryInfo = [
                'service_ids' => $serviceIds,
                'invoice_id' => $invoiceId,
                'amount' => $amount,
                'invoice_paid' => $invoicePaid,
                'order_time' => now()->toDateTimeString(),
                'rak_order_result' => $rakOrderResult,
            ];
            
            // 更新订单信息（将服务器信息作为卡密信息）
            $order->info = $serviceIds ?: json_encode($deliveryInfo, JSON_UNESCAPED_UNICODE);
            $order->save();
            
            DB::commit();
            
            Log::info('Rak 订单处理成功', [
                'order_sn' => $order->order_sn,
                'service_ids' => $serviceIds,
                'invoice_id' => $invoiceId,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Rak 订单结果处理失败: ' . $e->getMessage(), [
                'order_sn' => $order->order_sn,
                'trace' => $e->getTraceAsString(),
            ]);
            throw $e;
        }
    }
}

