<?php

return [
    /**
     * 框架分页配置
     */
    'pagination' => [
        'page_param' => 'page', // 入参页码参数名
        'page_size_param' => 'page_size', // 入参每页条数参数名
        'default_page_size' => 15, // 每页默认返回条数
        'max_page_size' => 100 // 每页最多返回几条,
    ],

    /**
     * api日志配置
     */
    'api_log' => [
        'enable' => env('API_LOG_ENABLE', false) // 是否开启api日志记录
    ],
    /**
     * sql日志配置
     */
    'sql_log' => [
        'enable' => env('SQL_LOG_ENABLE', false) // 是否开启sql日志记录
    ],
    /**
     * redis日志配置
     */
    'redis_log' => [
        'enable' => env('REDIS_LOG_ENABLE', false) // 是否开启redis日志记录
    ],

    /**
     * 自定义http客户端配置
     */
    'custom_client' => [
        'timeout' => 10 // 默认超时时间
    ],
];
