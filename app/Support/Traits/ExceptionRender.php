<?php

namespace App\Support\Traits;

use App\Constants\ResponseCode;
use Illuminate\Http\JsonResponse;

/**
 * 支持项目异常按标准api json响应
 */
trait ExceptionRender
{
    use ApiResponse;

    public function render(): JsonResponse
    {
        return $this->responseError($this->getMessage(), isset($this->responseCode) ? $this->responseCode : ResponseCode::FAIL);
    }
}
