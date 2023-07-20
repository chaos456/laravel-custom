<?php

namespace App\Support\Log;

use App\Support\Traits\InstanceMake;
use Illuminate\Support\Str;

/**
 * 单次网络请求/命令/队列中的日志上下文类
 */
class LogContext
{
    use InstanceMake;

    /**
     * 日志id 单次网络请求/命令/队列中的log_id应保持一致
     * @var string
     */
    protected string $logId = '';

    /**
     * @param string $uuid
     */
    public function setLogId(): void
    {
        $this->logId = Str::uuid()->getHex()->toString();
    }

    /**
     * @return string
     */
    public function getLogId(): string
    {
        return $this->logId;
    }
}
