<?php

declare(strict_types=1);

namespace App\Constants\code;

use Hyperf\Constants\AbstractConstants;
use Hyperf\Constants\Annotation\Constants;

#[Constants]
class CodeEnum extends AbstractConstants
{
    /**
     * @Message("操作成功")
     */
    const SUCCESS = 000000;
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
    /**
     * @Message("Token已过期,请重新登陆")
     */
    const REFRESH_TOKEN_EXPIRED = 100005;
    /**
     * @Message("Token进入黑名单,请重新登陆")
     */
    const TOKEN_ON_BLACKLIST = 100006;
}
