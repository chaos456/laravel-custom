<?php

namespace App\Support\Traits;


/**
 * 用于快速创建类的实例
 */
trait InstanceMake
{
    protected static $instance;

    /**
     * 返回类的单例
     * @param ...$parameters
     * @return static
     */
    public static function instance(...$parameters): static
    {
        if (is_null(static::$instance)) {
            static::$instance = new static(...$parameters);
        }

        return static::$instance;
    }

    /**
     * 返回类的实例
     * @param ...$parameters
     * @return static
     */
    public static function make(...$parameters): static
    {
        return new static(...$parameters);
    }
}
