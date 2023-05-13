<?php

namespace App\Traits;

use App\Constants\ResponseCode;
use Illuminate\Http\JsonResponse;

trait ApiResponse
{
    /**
     * 标准返回
     * @param int $code 返回码
     * @param array|object $data 返回数据
     * @param string $msg 返回信息
     * @return JsonResponse
     */
    public function response(int $code, array|object $data = [], string $msg = ''): JsonResponse
    {
        if ($msg === '' && isset(ResponseCode::MESSAGE[$code])) {
            $msg = ResponseCode::MESSAGE[$code];
        }

        if (empty($data)) {
            $data = (object)[];
        }

        return response()->json([
            'code' => $code,
            'data' => $data,
            'msg'  => $msg
        ]);
    }

    /**
     * 标准成功返回
     * @param array|object $data 返回数据
     * @param int $responseCode
     * @return JsonResponse
     */
    public function responseSuccess(array|object $data = [], int $responseCode = ResponseCode::SUCCESS): JsonResponse
    {
        return $this->response($responseCode, $data);
    }

    /**
     * 标准失败返回
     * @param string $msg 返回信息
     * @param int $code 失败码
     * @return JsonResponse
     */
    public function responseError(string $msg = '', int $code = ResponseCode::FAIL): JsonResponse
    {
        return $this->response($code, [], $msg);
    }
}
