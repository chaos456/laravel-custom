<?php

namespace App\Enums;

use App\Support\Annotation\Message;
/**
 * 存放项目所有api响应code及msg常量
 */
class ExampleEnum extends BaseEnum
{
    #[Message('sex', '男')]
    const SEX_MALE = 1;

    #[Message('sex', '女')]
    const SEX_FEMALE = 2;

    #[Message('status', '开启')]
    const STATUS_OPEN = 1;

    #[Message('status', '关闭')]
    const STATUS_CLOSE = 2;
}
