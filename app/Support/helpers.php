<?php


/**
 * @param string|null $name
 * @return \Illuminate\Redis\Connections\Connection|Redis
 */
function redis(string|null $name = null)
{
    return \Illuminate\Support\Facades\Redis::connection($name);
}


