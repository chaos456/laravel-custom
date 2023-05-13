<?php

namespace App\Support;

use Illuminate\Database\Eloquent\Builder;
use Carbon;

class BuilderMacro
{
    public function customPaginate(): callable
    {
        /**
         * 自定义分页
         *
         * @param int $page 页码
         * @param int $perPage 每页数量
         * @return CustomPaginator
         */
        return function (int $page = null, int $perPage = null): CustomPaginator {
            /** @var Builder $this */
            $page = $page ?: request()->integer('page', 1);
            $perPage = $perPage ?: request()->integer('per_page', 15);

            $instance = $this->paginate(perPage: $perPage, page: $page);

            return new CustomPaginator($instance);
        };
    }

    public function whereEqDate(): callable
    {
        /**
         * 查询时间字段日期为某天的
         *
         * @param string $field
         * @param string $date 日期
         * @return Builder
         */
        return function (string $field, string $date) {
            /**
             * @var Builder $this
             * @var Builder $query
             */
            return $this->where(function ($query) use ($field, $date) {
                $query->where($field, '>=', $date . ' 00:00:00')
                    ->where($field, '<=', $date . ' 23:59:59');
            });
        };
    }

    public function whereToday(): callable
    {
        /**
         * 查询时间字段日期为今天的
         *
         * @param string $field
         * @return Builder
         */
        return function (string $field) {
            /**
             * @var Builder $this
             * @var Builder $query
             */
            return $this->where(function ($query) use ($field) {
                $date = date('Y-m-d');
                $query->where($field, '>=', $date . ' 00:00:00')
                    ->where($field, '<=', $date . ' 23:59:59');
            });
        };
    }
}
