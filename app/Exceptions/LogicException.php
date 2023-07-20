<?php

namespace App\Exceptions;

use App\Support\Traits\ExceptionRender;
use Exception;

class LogicException extends Exception
{
    use ExceptionRender;
}
