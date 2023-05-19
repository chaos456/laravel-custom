<?php

namespace App\Support;

use App\Support\Traits\InstanceMake;
use Illuminate\Support\Str;

/**
 * 单次网络请求中的上下文类
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
        return Str::uuid()->getHex()->toString();
    }

    /**
     * @return string
     */
    public function getRequestId(): string
    {
        return $this->requestId;
    }
}
