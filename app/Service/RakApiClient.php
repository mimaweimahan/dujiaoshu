<?php

namespace App\Service;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;

/**
 * Rak API 客户端
 * 
 * @package App\Service
 */
class RakApiClient
{
    private $client;
    private $apiKey;
    private $baseUrl;
    private $timeout;

    public function __construct()
    {
        $this->baseUrl = config('rak.api_base_url');
        $this->apiKey = config('rak.api_key');
        $this->timeout = config('rak.timeout', 30);
        
        $this->client = new Client([
            'base_uri' => $this->baseUrl,
            'timeout' => $this->timeout,
            'headers' => [
                'X-API-Key' => $this->apiKey,
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ],
        ]);
    }

    /**
     * 获取可用地区
     *
     * @param string $type 产品类型 (instance|metal|disk|eip)
     * @param int $offset 偏移量
     * @param int $limit 限制数量
     * @return array|null
     */
    public function getRegions(string $type = 'instance', int $offset = 0, int $limit = 10): ?array
    {
        try {
            $response = $this->client->get('regions', [
                'query' => [
                    'type' => $type,
                    'offset' => $offset,
                    'limit' => $limit,
                ],
            ]);
            
            $body = json_decode($response->getBody()->getContents(), true);
            return $body['regions'] ?? null;
        } catch (GuzzleException $e) {
            Log::error('Rak API 获取地区失败: ' . $e->getMessage(), [
                'type' => $type,
                'error' => $e->getMessage(),
            ]);
            return null;
        }
    }

    /**
     * 获取云产品列表
     *
     * @param string $type 产品类型
     * @param string|null $region 地区
     * @param string|null $productName 产品名称（模糊搜索）
     * @param int $offset 偏移量
     * @param int $limit 限制数量
     * @param int $sampleOptionsShowFixed 是否显示固定配置项
     * @return array|null
     */
    public function getPlans(
        string $type = 'instance',
        ?string $region = null,
        ?string $productName = null,
        int $offset = 0,
        int $limit = 10,
        int $sampleOptionsShowFixed = 0
    ): ?array {
        try {
            $query = [
                'type' => $type,
                'offset' => $offset,
                'limit' => $limit,
                'sample_options_show_fixed' => $sampleOptionsShowFixed,
            ];
            
            if ($region) {
                $query['region'] = $region;
            }
            
            if ($productName) {
                $query['product_name'] = $productName;
            }
            
            $response = $this->client->get('plans', [
                'query' => $query,
            ]);
            
            $body = json_decode($response->getBody()->getContents(), true);
            return $body['productSamples'] ?? null;
        } catch (GuzzleException $e) {
            Log::error('Rak API 获取产品列表失败: ' . $e->getMessage(), [
                'type' => $type,
                'region' => $region,
                'error' => $e->getMessage(),
            ]);
            return null;
        }
    }

    /**
     * 获取产品价格
     *
     * @param string $sampleId 产品ID
     * @param array $configOptionsData 配置选项数据
     * @param string $billingCycle 计费周期 (Monthly|Quarterly|SemiAnnually|Annually)
     * @param int $quantity 数量
     * @return array|null
     */
    public function getPrice(
        string $sampleId,
        array $configOptionsData,
        string $billingCycle = 'Monthly',
        int $quantity = 1
    ): ?array {
        try {
            $response = $this->client->post('price', [
                'json' => [
                    'sample_id' => $sampleId,
                    'configoptions_data' => $configOptionsData,
                    'billingcycle' => $billingCycle,
                    'quantity' => $quantity,
                ],
            ]);
            
            $body = json_decode($response->getBody()->getContents(), true);
            return $body;
        } catch (GuzzleException $e) {
            Log::error('Rak API 获取价格失败: ' . $e->getMessage(), [
                'sample_id' => $sampleId,
                'error' => $e->getMessage(),
            ]);
            return null;
        }
    }

    /**
     * 创建订单
     *
     * @param string $sampleId 产品ID
     * @param array $configOptionsData 配置选项数据
     * @param string $billingCycle 计费周期
     * @param int $quantity 数量
     * @param array|null $discountIds 优惠券ID数组
     * @return array|null
     */
    public function createOrder(
        string $sampleId,
        array $configOptionsData,
        string $billingCycle = 'Monthly',
        int $quantity = 1,
        ?array $discountIds = null
    ): ?array {
        try {
            $payload = [
                'sample_id' => $sampleId,
                'configoptions_data' => $configOptionsData,
                'billingcycle' => $billingCycle,
                'quantity' => $quantity,
            ];
            
            if ($discountIds && !empty($discountIds)) {
                $payload['discount_ids'] = $discountIds;
            }
            
            Log::info('Rak API 创建订单请求', [
                'payload' => $payload,
            ]);
            
            $response = $this->client->post('order', [
                'json' => $payload,
            ]);
            
            $body = json_decode($response->getBody()->getContents(), true);
            
            Log::info('Rak API 创建订单响应', [
                'response' => $body,
            ]);
            
            return $body;
        } catch (GuzzleException $e) {
            Log::error('Rak API 创建订单失败: ' . $e->getMessage(), [
                'sample_id' => $sampleId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return null;
        }
    }
}

