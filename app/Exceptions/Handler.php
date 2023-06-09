<?php

namespace App\Exceptions;

use App\Constants\CustomLogChannel;
use App\Constants\ResponseCode;
use App\Support\Context;
use App\Support\CustomLog;
use App\Support\Traits\ApiResponse;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Config;
use Illuminate\Validation\ValidationException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;
use Exception;

class Handler extends ExceptionHandler
{
    use ApiResponse;

    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param \Throwable $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $e)
    {
        if ($this->shouldntReport($e)) {
            return;
        }

        if (method_exists($e, 'report')) {
            if ($e->report() !== false) {
                return;
            }
        }

        try {
            CustomLog::channel(CustomLogChannel::EXCEPTION)->error($e);
        } catch (Exception $ex) {
            throw $e; // throw the original exception
        }
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Throwable $exception
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $e)
    {
        Config::set('support.api_log.enable', true);

        if (method_exists($e, 'render')) {
            return $e->render($request);
        } elseif ($e instanceof Responsable) {
            return $e->toResponse($request);
        }

        return match (true) {
            $e instanceof ValidationException => $this->responseError(collect($e->errors())->first()[0], ResponseCode::WRONG_PARAMS),
            $e instanceof HttpException => $this->responseError(config('app.debug') ? sprintf('HTTP %s', $e->getStatusCode()) : '系统错误'),
            default => $this->defaultExceptionRender($e)
        };
    }

    protected function defaultExceptionRender(Throwable $e)
    {
        if (config('app.debug')) {
            return $this->response(ResponseCode::FAIL, $this->convertExceptionToArray($e), sprintf('%s %s', $e->getMessage(), Context::singleton()->getRequestId()));
        } else {
            return $this->responseError(sprintf('%s %s', '系统错误', Context::singleton()->getRequestId()));
        }
    }
}
