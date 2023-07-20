<?php

namespace App\Enums;

/**
 * 存放项目所有redis key常量
 */
class RedisKeyEnum
{
    const SERIAL = 'serial:%s:%s_%s'; // 接口串行化-防并发
}
