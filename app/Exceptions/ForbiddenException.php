<?php
/**
 * User: chaos
 * Date: 2022/3/9
 * Time: 20:12
 */

namespace App\Exceptions;

use App\Constants\ResponseCode;
use App\Support\Traits\ApiResponse;
use Exception;
use Illuminate\Http\Request;

class ForbiddenException extends Exception
{
    use ApiResponse;

    public function render(Request $request)
    {
        return $this->responseError($this->getMessage(), ResponseCode::FORBIDDEN);
    }
}
