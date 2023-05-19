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
    protected Request $request;

    /**
     * 需要记录响应的路由
     * @var array
     */
    protected $logResponsePath = [
    ];

    /**
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $this->request = $request;
        $this->enableLogRequestId();

        config('support.api_log.enable') && $this->requestLog();
        $response = $next($request);
        config('support.api_log.enable') && $this->responseLog($response);

        return $response;
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

    /**
     * 记录请求日志
     * @return void
     */
    protected function requestLog()
    {
        CustomLog::channel(CustomLogChannel::API_LOG)->info(
            sprintf('request %s %s', $this->request->getMethod(), $this->request->getPathInfo()), [
                'params' => $this->request->all(),
                'time' => Carbon::createFromTimestamp(LARAVEL_START)->toDateTimeString('microsecond')
            ]
        );
    }

    /**
     * 记录响应日志
     * @param $response
     * @return void
     */
    protected function responseLog($response)
    {
        $content = json_decode($response->getContent(), true);

        $extra = [
            'code' => $content['code'],
            'msg' => $content['msg'],
            'used_time' => round((microtime(true) - LARAVEL_START) * 1000, 2) . 'ms'
        ];

        if (in_array($this->request->getPathInfo(), $this->logResponsePath)) {
            $extra['data'] = $content['data'];
        }

        CustomLog::channel(CustomLogChannel::API_LOG)->info('response', $extra);
    }
}
