<?php


namespace App\Bean;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

abstract class BaseBean
{
    /**
     * 构造函数
     * @param $data 数据集
     */
    public function __construct(mixed $data)
    {
        $reflectInstance = new \ReflectionClass(get_class($this));
        $properties = $reflectInstance->getProperties();
        foreach ($properties as $property) {
            $key = $property->getName();
            $this->$key = null;
        }

        if ($data instanceof Model) {
            $data = $data->toArray();
        }

        if (!empty($data)) {
            foreach ($data as $key => $val) {
                if (property_exists($this, $key) && !is_null($val)) {
                    $setMethodName = $this->getSetMethodName($key);
                    if (method_exists($this, $setMethodName)) {
                        $this->$setMethodName($val);
                    } else {
                        $this->$key = $val;
                    }
                }
            }
        }
    }

    /**
     * 获取set方法名称
     * @param $key
     * @return string
     */
    protected function getSetMethodName(string $key)
    {
        return "set" . ucfirst(Str::camel($key));
    }

    /**
     * 获取get方法名称
     * @param $key
     * @return string
     */
    protected function getGetMethodName(string $key)
    {
        return "get" . ucfirst(Str::camel($key));
    }

    public function toArray()
    {
        $data = [];

        $reflectInstance = new \ReflectionClass(get_class($this));
        $properties = $reflectInstance->getProperties();
        foreach ($properties as $property) {
            $key = Str::snake($property->getName());
            $getMethodName = $this->getGetMethodName($key);

            try {
                $data[$key] = method_exists($this, $getMethodName) ? $this->$getMethodName() : $this->$key;
            } catch (\Throwable $throwable) {
                $data[$key] = null;
            }
        }

        return $data;
    }
}
