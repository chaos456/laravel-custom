<?php

namespace App\Rules;

/**
 * 手机号验证
 */
class PhoneRule extends BaseRule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     *
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return preg_match('/^1[123456789][0-9]{9}$/', $value);
    }
}
