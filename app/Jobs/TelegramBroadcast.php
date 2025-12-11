<?php
/**
 * Telegram批量群发任务
 * 
 * @author    Custom Development
 * @copyright Custom Development
 */

namespace App\Jobs;

use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class TelegramBroadcast implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * 任务最大尝试次数
     *
     * @var int
     */
    public $tries = 2;

    /**
     * 任务运行的超时时间
     *
     * @var int
     */
    public $timeout = 30;

    /**
     * Telegram用户ID
     * @var string
     */
    private $telegramId;

    /**
     * 消息内容
     * @var string
     */
    private $message;

    /**
     * 消息类型: text, photo, video
     * @var string
     */
    private $messageType;

    /**
     * 媒体文件URL（用于图片和视频）
     * @var string|null
     */
    private $mediaUrl;

    /**
     * 创建任务实例
     *
     * @param string $telegramId Telegram用户ID
     * @param string $message 消息内容
     * @param string $messageType 消息类型
     * @param string|null $mediaUrl 媒体文件URL
     * @return void
     */
    public function __construct(string $telegramId, string $message, string $messageType = 'text', ?string $mediaUrl = null)
    {
        $this->telegramId = $telegramId; // 设置Telegram用户ID
        $this->message = $message; // 设置消息内容
        $this->messageType = $messageType; // 设置消息类型
        $this->mediaUrl = $mediaUrl; // 设置媒体文件URL
    }

    /**
     * 执行任务
     *
     * @return void
     */
    public function handle()
    {
        try {
            // 获取Telegram Bot Token
            $botToken = dujiaoka_config_get('telegram_bot_api_token');
            
            // 如果Bot Token为空，记录错误并返回
            if (empty($botToken)) {
                Log::error('Telegram Bot Token未配置');
                return;
            }

            // 创建HTTP客户端
            $client = new Client([
                'timeout' => 30, // 设置超时时间为30秒
                'proxy' => '' // 代理设置为空
            ]);

            // 根据消息类型发送不同的消息
            switch ($this->messageType) {
                case 'photo': // 图片消息
                    $this->sendPhoto($client, $botToken);
                    break;
                case 'video': // 视频消息
                    $this->sendVideo($client, $botToken);
                    break;
                case 'text': // 文本消息
                default:
                    $this->sendText($client, $botToken);
                    break;
            }

            // 记录成功日志
            Log::info('TelegramBroadcast 发送成功', [
                'telegram_id' => $this->telegramId,
                'type' => $this->messageType
            ]);

        } catch (\Exception $exception) {
            // 记录失败日志
            Log::error('TelegramBroadcast 发送失败: ' . $exception->getMessage(), [
                'telegram_id' => $this->telegramId,
                'type' => $this->messageType
            ]);
        }
    }

    /**
     * 发送文本消息
     *
     * @param Client $client HTTP客户端
     * @param string $botToken Bot Token
     * @return void
     */
    private function sendText(Client $client, string $botToken)
    {
        // 构建API URL
        $apiUrl = 'https://api.telegram.org/bot' . $botToken . '/sendMessage';
        
        // 发送POST请求
        $client->post($apiUrl, [
            'form_params' => [
                'chat_id' => $this->telegramId, // 接收者的Telegram ID
                'text' => $this->message, // 消息内容
                'parse_mode' => 'HTML' // 支持HTML格式
            ]
        ]);
    }

    /**
     * 发送图片消息
     *
     * @param Client $client HTTP客户端
     * @param string $botToken Bot Token
     * @return void
     */
    private function sendPhoto(Client $client, string $botToken)
    {
        // 构建API URL
        $apiUrl = 'https://api.telegram.org/bot' . $botToken . '/sendPhoto';
        
        // 发送POST请求
        $client->post($apiUrl, [
            'form_params' => [
                'chat_id' => $this->telegramId, // 接收者的Telegram ID
                'photo' => $this->mediaUrl, // 图片URL
                'caption' => $this->message, // 图片说明文字
                'parse_mode' => 'HTML' // 支持HTML格式
            ]
        ]);
    }

    /**
     * 发送视频消息
     *
     * @param Client $client HTTP客户端
     * @param string $botToken Bot Token
     * @return void
     */
    private function sendVideo(Client $client, string $botToken)
    {
        // 构建API URL
        $apiUrl = 'https://api.telegram.org/bot' . $botToken . '/sendVideo';
        
        // 发送POST请求
        $client->post($apiUrl, [
            'form_params' => [
                'chat_id' => $this->telegramId, // 接收者的Telegram ID
                'video' => $this->mediaUrl, // 视频URL
                'caption' => $this->message, // 视频说明文字
                'parse_mode' => 'HTML' // 支持HTML格式
            ]
        ]);
    }
}

