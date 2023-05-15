<?php

namespace App\Exceptions;

use App\Support\Traits\ApiResponse;
use Exception;
use Illuminate\Http\Request;

class ServiceException extends Exception
{
    use ApiResponse;

    public function render(Request $request)
    {
        return $this->responseError($this->getMessage());
    }
}
