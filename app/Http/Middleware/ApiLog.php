<?php

namespace App\Http\Middleware;

use App\Constants\CustomLogChannel;
use App\Support\Context;
use App\Support\CustomLog;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;

class ApiLog
{
    /**
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $this->enableLogRequestId();

        return $next($request);
    }

    /**
     * 使日志支持request id
     * @return void
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    protected function enableLogRequestId()
    {
        $logger = app()->make('log');
        $logger->pushProcessor(function ($record) {
            $record['extra']['request_id'] = Context::singleton()->getRequestId();
            return $record;
        });

        CustomLog::setWithRequestId(true);
    }

    public function terminate($request, $response)
    {
        $cost = round((microtime(true) - LARAVEL_START) * 1000, 2) . 'ms';

        if (config('support.api_log.enable')) {
            CustomLog::channel(CustomLogChannel::API_LOG)->info(sprintf('%s %s', $request->getMethod(), $request->getPathInfo()),
                [
                    'request'        => $request->all(),
                    'request_header' => $request->header(),
                    'request_time'   => Carbon::createFromTimestamp(LARAVEL_START)->toDateTimeString('microsecond'),
                    'cost'           => $cost
                ]
            );
        }
    }
}
