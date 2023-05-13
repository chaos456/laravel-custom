<?php

namespace App\Exceptions;

use App\Constants\CustomLogChannel;
use App\Constants\ResponseCode;
use App\Support\Context;
use App\Support\CustomLog;
use App\Traits\ApiResponse;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Reflector;
use Illuminate\Validation\ValidationException;
use Throwable;

class Handler extends ExceptionHandler
{
    use ApiResponse;

    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
        ServiceException::class,
        UnauthorizedException::class,
        ForbiddenException::class
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        // 验证错误
        $this->renderable(function (ValidationException $e, $request) {
            return $this->responseError(collect($e->errors())->first()[0], ResponseCode::WRONG_PARAMS);
        });

        // 捕获业务异常
        $this->renderable(function (Throwable $e, $request) {
            $msg = config('app.debug') ? $e->getMessage() : '系统错误';
            $msg .= ' ' . Context::singleton()->getUuid();
            return $this->responseError($msg);
        });
    }

    public function report(Throwable $e)
    {
        $e = $this->mapException($e);

        if ($this->shouldntReport($e)) {
            return;
        }

        if (Reflector::isCallable($reportCallable = [$e, 'report']) &&
            $this->container->call($reportCallable) !== false) {
            return;
        }

        foreach ($this->reportCallbacks as $reportCallback) {
            if ($reportCallback->handles($e) && $reportCallback($e) === false) {
                return;
            }
        }

        try {
            CustomLog::channel(CustomLogChannel::EXCEPTION)->error($e);
        } catch (Throwable $ex) {
            throw $e;
        }
    }
}
