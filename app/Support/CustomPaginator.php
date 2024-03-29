<?php

namespace App\Support;

use Illuminate\Pagination\LengthAwarePaginator;

/**
 * 自定义分页器
 */
class CustomPaginator extends LengthAwarePaginator
{
    /**
     * @param LengthAwarePaginator $paginate 原始分页对象
     *
     * @return void
     */
    public function __construct(LengthAwarePaginator $paginate)
    {
        parent::__construct(
            items: $paginate->getCollection(),
            total: $paginate->total(),
            perPage: $paginate->perPage(),
            currentPage: $paginate->currentPage()
        );
    }

    /**
     * 重新定义分页的输出格式
     * @return array
     */
    public function toArray(): array
    {
        return [
            'paginate' => [
                'total' => $this->total(),
                config('support.pagination.page_param') => $this->currentPage(),
                config('support.pagination.page_size_param') => $this->perPage(),
            ],
            'list' => $this->getCollection(),
        ];
    }
}
