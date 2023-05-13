<?php

namespace App\Support;

use App\Traits\InstanceMake;
use Illuminate\Support\Str;

/**
 * 单次网络请求中的上下文 每条日志中将携带 uuid参数
 */
class Context
{
    use InstanceMake;

    protected string $uuid;

    public function __construct()
    {
        $this->setUuid();
    }

    /**
     * @param string $uuid
     */
    public function setUuid(): void
    {
        $this->uuid = $this->generateUuid();
    }

    /**
     * @param string $uuid
     */
    protected function generateUuid()
    {
        return sprintf('%s%s', Str::random(5), uniqid());
    }

    /**
     * @return string
     */
    public function getUuid(): string
    {
        return $this->uuid;
    }
}
