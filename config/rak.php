<?php

return [
    // API 基础配置
    'api_base_url' => env('RAK_API_BASE_URL', 'https://rak-api.raksmart.com/rakapi/v1/'),
    'api_key' => env('RAK_API_KEY', ''),
    
    // 默认配置
    'default_region' => env('RAK_DEFAULT_REGION', 'sv'),
    'default_type' => env('RAK_DEFAULT_TYPE', 'instance'),
    
    // 请求超时设置
    'timeout' => env('RAK_API_TIMEOUT', 30),
    
    // 是否启用 Rak 自动发货
    'enabled' => env('RAK_ENABLED', false),
];

