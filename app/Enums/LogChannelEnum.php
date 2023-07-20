<?php

namespace App\Enums;

/**
 * 所有自定义的日志channel常量
 */
class LogChannelEnum
{
    const API_LOG = 'apiLog'; // 记录api日志

    const EXCEPTION = 'exception'; // 记录异常日志

    const SQL = 'sql'; // 记录sql日志

    const REDIS = 'redis'; // 记录sql日志

    const RABBIT = 'rabbit'; // rabbit
}
