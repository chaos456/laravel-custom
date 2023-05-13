<?php

namespace App\Support;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

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
            $page = $page ?: request()->integer(config('support.pagination.page_param'), 1);
            $perPage = $perPage ?: request()->integer(config('support.pagination.page_size_param'), 15);
            $maxPerPage = config('support.pagination.max_page_size');

            $instance = $this->paginate(page: $page, perPage: min($perPage, $maxPerPage));

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
            $time = Carbon::parse($date);
            return $this->where(
                fn($query) => $query->where($field, '>=', $time->startOfDay()->toDateTimeString())
                    ->where($field, '<=', $time->endOfDay()->toDateTimeString())
            );
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
            $time = Carbon::now();
            return $this->where(
                fn($query) => $query->where($field, '>=', $time->startOfDay()->toDateTimeString())
                    ->where($field, '<=', $time->endOfDay()->toDateTimeString())
            );
        };
    }

    public function whereYesterday()
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
            $time = Carbon::yesterday();
            return $this->where(
                fn($query) => $query->where($field, '>=', $time->startOfDay()->toDateTimeString())
                    ->where($field, '<=', $time->endOfDay()->toDateTimeString())
            );
        };
    }
}
