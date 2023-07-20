<?php

namespace App\Http\Middleware;


use App\Enums\RedisKeyEnum;
use App\Exceptions\CommonException;
use App\Exceptions\ServiceException;
use Illuminate\Cache\RedisLock;
use Illuminate\Http\Request;
use Closure;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;
use JsonException;

class Serial
{
    /**
     * 接口防并发中间件-实现接口幂等性 ->  限制对资源的并发访问
     *
     * 用法举例:->middleware('serial:order_id,1') 表示对此地址的同一 order_id 为唯一值请求进行串行化处理，1秒超时，
     * @param Request $request
     * @param Closure $next
     * @param string $var 用于唯一标识的变量
     * @param int $timeOutSeconds n秒内超时
     * @return mixed
     * @throws ServiceException
     */
    public function handle(Request $request, Closure $next, string $var, int $timeOutSeconds = 5)
    {
        $key = sprintf(RedisKeyEnum::SERIAL, $request->path(), $var, $this->parseUniqueValue($request, $var));

        $owner = Str::uuid()->toString();

        $redisLock = new RedisLock(Redis::connection(), $key, $timeOutSeconds, $owner);
        if (!$redisLock->acquire()) {
            throw new CommonException('当前资源正在被处理，请稍后再试~');
        }

        try {
            $response = $next($request);
        } finally {
            $redisLock->release();// 释放锁
        }

        return $response;
    }

    /**
     * 处理传入变量获取唯一值
     *
     * @param Request $request
     * @param string $var
     * @return string
     */
    private function parseUniqueValue(Request $request, string $var): string
    {
        $value = $request->input($var);

        if (is_string($value) || is_numeric($value)) {
            return (string)$value;
        }

        if (is_array($value) || is_object($value)) {
            try {
                return md5(json_encode($value, JSON_THROW_ON_ERROR));
            } catch (JsonException) {
                return '';
            }
        }

        return '';
    }

}
