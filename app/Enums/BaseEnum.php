<?php

namespace App\Enums;

use App\Support\Annotation\AnnotationScan;
use App\Support\Traits\InstanceMake;

/**
 * 枚举 基类
 */
abstract class BaseEnum
{
    use AnnotationScan, InstanceMake;

    /**
     * 字段含义映射
     *
     * @var array
     */
    protected $columnMap = [];

    /**
     * 当前字段名
     *
     * @var string
     */
    protected $column = '';

    /**
     * @param string $column 字段名
     */
    public function __construct(string $column = '')
    {
        $this->column = $column;

        if (method_exists($this, 'loadColumnMap')) {
            $this->columnMap = $this->loadColumnMap();
        }
    }

    /**
     * 实例化
     *
     * @param string $column 字段名
     *
     * @return static
     */
    public static function useColumn(string $column = ''): static
    {
        $instance = self::instance($column);
        $instance->column($column);
        return $instance;
    }

    /**
     * 返回字段值的含义
     *
     * @param mixed $value
     * @param mixed $default 默认值
     *
     * @return string|null
     */
    public function translate(mixed $value, mixed $default = ''): ?string
    {
        return $this->columnMap[$this->column][$value] ?? $default;
    }

    /**
     * 判断是否包含某个值
     *
     * @param mixed $value
     *
     * @return bool
     */
    public function has(mixed $value): bool
    {
        return isset($this->columnMap[$this->column][$value]);
    }

    /**
     * 获取值集合
     *
     * @return array
     */
    public function values()
    {
        return empty($this->column) ? [] : $this->columnMap[$this->column];
    }

    /**
     * 指定字段名
     *
     * @param string $column 字段名
     *
     * @return static
     */
    public function column(string $column): static
    {
        $this->column = $column;

        return $this;
    }
}
