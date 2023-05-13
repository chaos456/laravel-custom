<?php

namespace App\Http\Middleware;

use App\Constants\CustomLogChannel;
use App\Support\Context;
use App\Support\CustomLog;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
        $this->enableRequestId();

        config('support.api_log.enable') && $this->requestLog();
        $response = $next($request);
        config('support.api_log.enable') && $this->responseLog($response);

        return $response;
    }

    protected function enableRequestId()
    {
        Log::withContext(['request_id' => Context::singleton()->getUuid()]);
        CustomLog::setWithRequestId(true);
    }

    /**
     * 记录请求日志
     * @return void
     */
    protected function requestLog()
    {
        CustomLog::channel(CustomLogChannel::API_LOG)->info(
            sprintf('REQUEST %s %s', $this->request->getMethod(), $this->request->getPathInfo()), [
                'body' => $this->request->all()
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

        CustomLog::channel(CustomLogChannel::API_LOG)->info('RESPONSE', $extra);
    }
}
