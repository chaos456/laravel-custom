<?php

/**
 * 获取redis使用对象，且利于对编辑器代码友好提示
 * @param string|null $name
 * @return \Illuminate\Redis\Connections\Connection|Redis
 */
function redis(string|null $name = null)
{
    return \Illuminate\Support\Facades\Redis::connection($name);
}
