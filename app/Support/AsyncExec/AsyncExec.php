<?php

namespace App\Support\AsyncExec;

use Closure;

/**
 * 异步执行服务
 * fpm模式下 异步（延时）执行的服务类，将在响应后继续占用fpm进程执行
 * 利用了 fastcgi_finish_request() 函数
 * 注意点：
 *      执行时间问题，限制执行时间为 10分钟，但是大量的调用会导致fpm的worker进程被占用，从而可能使得fpm进程数快速上升
 *      执行体的内存占用问题，脚本的内存占用默认为 $memoryLimit 256M ，可自行调整
 */
class AsyncExec
{
    /**
     * @var array $tasks
     */
    private static array $tasks = [];

    /**
     * @var int $memoryLimit 单位为 M
     */
    private static int $memoryLimit = 256;

    /**
     * @var int $maxExecTime 单位为 s 秒 默认为 10 分钟
     */
    private static int $maxExecTime = 600;

    /**
     * 将闭包函数放入队列中，先入先出，依次执行
     *
     * @param Closure $func
     */
    public static function defer(Closure $func): void
    {
        self::$tasks[] = $func;
    }

    /**
     * 设置最大的内存占用
     *
     * @param int $maxExecTime
     */
    public static function setMaxExecTime(int $maxExecTime): void
    {
        self::$memoryLimit = $maxExecTime;
    }

    /**
     * 设置最大的内存占用
     *
     * @param int $memoryLimit
     */
    public static function setMaxMemoryLimit(int $memoryLimit): void
    {
        self::$memoryLimit = $memoryLimit;
    }

    /**
     * 开始执行队列中的函数，最后清空这个队列
     */
    public static function execute(): void
    {
        ini_set('memory_limit', self::$memoryLimit . 'M');
        ini_set('max_execution_time', self::$maxExecTime);

        foreach (self::$tasks as $task) {
            $task();
        }

        self::$tasks = [];
    }
}
