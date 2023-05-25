<?php

namespace App\Exceptions;

use App\Support\Traits\ExceptionRender;
use Exception;

class ServiceException extends Exception
{
    use ExceptionRender;
}
