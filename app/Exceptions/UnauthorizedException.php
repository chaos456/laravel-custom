<?php
/**
 * User: chaos
 * Date: 2022/3/9
 * Time: 20:08
 */

namespace App\Exceptions;

use App\Constants\ResponseCode;
use App\Support\Traits\ExceptionRender;
use Exception;

class UnauthorizedException extends Exception
{
    use ExceptionRender;

    protected $responseCode = ResponseCode::UNAUTHORIZED;
}
