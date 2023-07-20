<?php

namespace App\Exceptions;

use App\Support\Traits\ExceptionRender;
use Exception;

class CommonException extends Exception
{
    use ExceptionRender;
}
