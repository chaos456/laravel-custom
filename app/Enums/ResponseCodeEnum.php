<?php

namespace App\Enums;

use App\Support\Annotation\Message;
/**
 * 存放项目所有api响应code及msg常量
 */
class ResponseCodeEnum extends BaseEnum
{
    #[Message('code', '成功')]
    const SUCCESS = 200;

    #[Message('code', '失败')]
    const FAIL = 500;

    #[Message('code', '参数错误')]
    const WRONG_PARAMS = 400;

    #[Message('code', '认证失败')]
    const UNAUTHORIZED = 401;

    #[Message('code', '权限不足')]
    const FORBIDDEN = 403;
}
