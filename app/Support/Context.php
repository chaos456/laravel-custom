<?php

namespace App\Support;

use App\Support\Traits\InstanceMake;
use Illuminate\Support\Str;

/**
 * 单次网络请求中的上下文
 * 每条日志中将携带 uuid参数
 */
class Context
{
    use InstanceMake;

    protected string $requestId;

    public function __construct()
    {
        $this->setRequestId();
    }

    /**
     * @param string $uuid
     */
    public function setRequestId(): void
    {
        $this->requestId = $this->generateRequestId();
    }

    /**
     * @param string $uuid
     */
    protected function generateRequestId()
    {
        return sprintf('%s%s', Str::random(5), uniqid());
    }

    /**
     * @return string
     */
    public function getRequestId(): string
    {
        return $this->requestId;
    }
}
