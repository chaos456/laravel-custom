<?php
namespace App\Support\Traits;


/**
 * 用于快速构建类的实例
 */
trait InstanceMake
{
    protected static $singleton;

    /**
     * 返回类的实例
     * @param ...$parameters
     * @return static
     */
    public static function make(...$parameters): static
    {
        return new static(...$parameters);
    }

    /**
     * 返回类的单例
     * @param ...$parameters
     * @return static
     */
    public static function singleton(...$parameters): static
    {
        if (is_null(static::$singleton)) {
            static::$singleton = new static(...$parameters);
        }

        return static::$singleton;
    }
}
