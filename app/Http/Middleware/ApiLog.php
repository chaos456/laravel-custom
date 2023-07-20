<?php

namespace App\Http\Middleware;

use App\Enums\LogChannelEnum;
use App\Support\AsyncExec\AsyncExec;
use App\Support\Log\CustomLog;
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


        return $next($request);
    }

    public function terminate($request, $response)
    {
        $cost = round((microtime(true) - LARAVEL_START) * 1000, 2) . 'ms';

        if (config('support.api_log.enable')) {
            CustomLog::channel(LogChannelEnum::API_LOG)->info(sprintf('%s %s', $request->getMethod(), $request->getPathInfo()),
                [
                    'request'        => $request->all(),
                    'request_time'   => Carbon::createFromTimestamp(LARAVEL_START)->toDateTimeString('microsecond'),
                    'cost'           => $cost
                ]
            );
        }

        AsyncExec::execute();
    }
}
