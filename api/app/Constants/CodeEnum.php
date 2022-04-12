<?php

declare(strict_types=1);

namespace App\Constants;

use Hyperf\Constants\AbstractConstants;
use Hyperf\Constants\Annotation\Constants;

#[Constants]
class CodeEnum extends AbstractConstants
{
    /**
     * @Message("登陆成功")
     */
    const LOGIN_SUCCESSFUL = 000000;

    /**
     * @Message("账号或密码错误")
     */
    const AUTH_LOGIN_FAILED = 100001;

    /**
     * @Message("Token不存在")
     */
    const TOKEN_DOES_NOT_EXIST = 100002;

    /**
     * @Message("Token无效")
     */
    const INVALID_SIGNATURE = 100003;

    /**
     * @Message("Token已过期")
     */
    const TOKEN_EXPIRED = 100004;
}
