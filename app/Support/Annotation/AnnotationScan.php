<?php

namespace App\Support\Annotation;



/**
 * 注解扫描
 */
trait AnnotationScan
{
    /**
     * 注解扫描状态
     *
     * @var bool
     */
    protected static $annotationScanned = false;

    /**
     * 扫描到的注解字段集
     *
     * @var array
     */
    protected static $annotationColumns = [];

    /**
     * 重写BaseEnum中的loadColumnMap方法
     *
     * @return array
     */
    protected function loadColumnMap()
    {
        $this->scanColumns();

        return self::$annotationColumns;
    }

    /**
     * 扫描注释上的字段集
     *
     * @return void
     */
    protected function scanColumns(): void
    {
        if (static::$annotationScanned) {
            return;
        }

        try {
            $reflection = new \ReflectionClass(static::class);

            // 扫描常量上的注解
            foreach ($reflection->getReflectionConstants() as $constant) {
                $message = $constant->getAttributes(Message::class)[0] ?? null;

                if (count($arguments = ($message?->getArguments() ?? [])) != 2) {
                    continue;
                }

                ['0' => $column, '1' => $message] = $arguments;
                $value = $constant->getValue();

                static::$annotationColumns[$column][$value] ??= $message;
            }

            static::$annotationScanned = true;
        } catch (\Throwable) {
        }
    }
}
