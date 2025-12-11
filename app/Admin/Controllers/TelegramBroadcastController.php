<?php
/**
 * Telegram批量群发控制器
 * 
 * @author    Custom Development
 * @copyright Custom Development
 */

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Jobs\TelegramBroadcast;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TelegramBroadcastController extends Controller
{
    /**
     * 显示批量群发页面
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        // 获取有Telegram ID的用户数量
        $userCount = User::whereNotNull('telegram_id')->count();
        
        // 返回视图，传递用户数量
        return view('admin.telegram_broadcast', [
            'user_count' => $userCount
        ]);
    }

    /**
     * 处理批量群发请求
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function send(Request $request)
    {
        // 验证请求数据
        $request->validate([
            'message' => 'required|string', // 消息内容必填
            'message_type' => 'required|in:text,photo,video', // 消息类型必填，只能是text、photo或video
            'media_url' => 'nullable|url', // 媒体URL可选，如果填写必须是有效的URL
        ], [
            'message.required' => '消息内容不能为空', // 自定义错误消息
            'message_type.required' => '消息类型不能为空',
            'message_type.in' => '消息类型只能是text、photo或video',
            'media_url.url' => '媒体URL格式不正确',
        ]);

        try {
            // 获取请求参数
            $message = $request->input('message'); // 消息内容
            $messageType = $request->input('message_type'); // 消息类型
            $mediaUrl = $request->input('media_url'); // 媒体URL

            // 验证：如果是图片或视频消息，必须提供媒体URL
            if (in_array($messageType, ['photo', 'video']) && empty($mediaUrl)) {
                return response()->json([
                    'status' => false,
                    'message' => '发送图片或视频消息时，必须提供媒体URL'
                ], 400);
            }

            // 获取所有有Telegram ID的用户
            $users = User::whereNotNull('telegram_id') // telegram_id不为空
                ->where('telegram_id', '!=', '') // telegram_id不为空字符串
                ->get(['id', 'telegram_id', 'email']); // 只获取需要的字段

            // 如果没有用户，返回错误
            if ($users->isEmpty()) {
                return response()->json([
                    'status' => false,
                    'message' => '没有找到绑定Telegram的用户'
                ], 400);
            }

            // 计数器：成功加入队列的任务数
            $queuedCount = 0;

            // 遍历所有用户，为每个用户创建发送任务
            foreach ($users as $user) {
                // 跳过telegram_id为空的用户（双重保险）
                if (empty($user->telegram_id)) {
                    continue;
                }

                // 将发送任务加入队列
                TelegramBroadcast::dispatch(
                    $user->telegram_id, // Telegram ID
                    $message, // 消息内容
                    $messageType, // 消息类型
                    $mediaUrl // 媒体URL
                );

                // 计数器加1
                $queuedCount++;
            }

            // 记录操作日志
            Log::info('Telegram批量群发任务已加入队列', [
                'user_count' => $users->count(), // 总用户数
                'queued_count' => $queuedCount, // 加入队列的任务数
                'message_type' => $messageType, // 消息类型
                'admin_user' => auth('admin')->user()->username ?? 'unknown' // 操作管理员
            ]);

            // 返回成功响应
            return response()->json([
                'status' => true,
                'message' => "成功将 {$queuedCount} 条消息加入发送队列，请稍后查看发送结果",
                'data' => [
                    'total_users' => $users->count(), // 总用户数
                    'queued_count' => $queuedCount // 加入队列的任务数
                ]
            ]);

        } catch (\Exception $e) {
            // 记录错误日志
            Log::error('Telegram批量群发失败: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);

            // 返回错误响应
            return response()->json([
                'status' => false,
                'message' => '批量群发失败: ' . $e->getMessage()
            ], 500);
        }
    }
}

