<?php

namespace App\Support;

use Illuminate\Support\Collection;

/**
 * 自定义简单分页器
 */
class CustomSimplePaginator extends Collection
{
    /**
     * 重新定义分页的输出格式
     * @return array
     */
    public function toArray(): array
    {
        return [
            'list' => $this->items,
        ];
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
