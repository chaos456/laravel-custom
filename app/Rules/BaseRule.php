<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

/**
 * 验证规则 基类
 */
abstract class BaseRule implements Rule
{

    /**
     * 验证错误默认返回信息
     *
     * @return string
     */
    public function message()
    {
        return sprintf(':attribute 不合法');
    }
}
