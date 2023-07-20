<?php

namespace App\Exceptions;

use App\Support\Traits\ExceptionRender;
use Exception;
use Illuminate\Http\JsonResponse;

class ServiceException extends Exception
{
    use ExceptionRender;
}
