<?php

namespace App\Providers;

use App\Support\Log\LogContext;
use App\Support\Macros\BuilderMacro;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    public function boot()
    {
        // 设置carbon地区
        Carbon::setLocale('zh');

        // 为Eloquent\Builder新增自定义宏方法
        Builder::mixin(new BuilderMacro());

        // 打通日志链路
        LogContext::instance()->setLogId();
        $logger = app()->make('log');
        $logger->pushProcessor(function ($record) {
            if (LogContext::instance()->getLogId()) {
                $record['extra']['log_id'] = LogContext::instance()->getLogId();
            }

            return $record;
        });
    }
}
