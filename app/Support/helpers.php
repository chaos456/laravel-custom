<?php

use App\Exceptions\ServiceException;
use Illuminate\Support\Facades\RateLimiter;

/**
 * @param string|null $name
 * @return \Illuminate\Redis\Connections\Connection|Redis
 */
function redis(string|null $name = null)
{
    return \Illuminate\Support\Facades\Redis::connection($name);
}


