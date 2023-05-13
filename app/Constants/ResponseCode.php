<?php

namespace App\Constants;

/**
 * api响应code及msg常量
 */
class ResponseCode
{
    const SUCCESS = 1; // 成功

    const FAIL = 0; // 失败

    const WRONG_PARAMS = 400; // 参数错误

    const UNAUTHORIZED = 401; // 认证失败

    const FORBIDDEN = 403; // 权限不足

    const MESSAGE = [
        self::SUCCESS => '成功',
        self::FAIL => '失败',
        self::WRONG_PARAMS => '参数错误',
        self::UNAUTHORIZED => '认证失败',
        self::FORBIDDEN => '权限不足',
    ];
}
