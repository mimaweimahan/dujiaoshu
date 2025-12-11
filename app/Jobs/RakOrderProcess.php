<?php

namespace App\Jobs;

use App\Models\Order;
use App\Service\RakOrderService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

/**
 * Rak 订单处理队列任务
 * 
 * @package App\Jobs
 */
class RakOrderProcess implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * 最大重试次数
     */
    public $tries = 3;

    /**
     * 超时时间（秒）
     */
    public $timeout = 60;

    /**
     * 订单号
     */
    private $orderSN;

    /**
     * Create a new job instance.
     *
     * @param string $orderSN 订单号
     */
    public function __construct(string $orderSN)
    {
        $this->orderSN = $orderSN;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $order = Order::where('order_sn', $this->orderSN)->first();
        if (!$order) {
            Log::error('Rak 订单处理失败：订单不存在', ['order_sn' => $this->orderSN]);
            return;
        }

        // 检查订单状态，只有已支付的订单才处理
        if ($order->status != \App\Models\Order::STATUS_COMPLETED) {
            Log::info('Rak 订单处理跳过：订单状态不正确', [
                'order_sn' => $this->orderSN,
                'status' => $order->status,
            ]);
            return;
        }

        $rakOrderService = new RakOrderService();
        $result = $rakOrderService->processOrder($order);
        
        if (!$result) {
            Log::warning('Rak 订单处理失败', ['order_sn' => $this->orderSN]);
            // 如果处理失败，抛出异常以便重试
            throw new \Exception('Rak 订单处理失败');
        }
    }

    /**
     * 任务失败时的处理
     *
     * @param \Exception $exception
     * @return void
     */
    public function failed(\Exception $exception)
    {
        Log::error('Rak 订单处理任务最终失败', [
            'order_sn' => $this->orderSN,
            'error' => $exception->getMessage(),
        ]);
    }
}

