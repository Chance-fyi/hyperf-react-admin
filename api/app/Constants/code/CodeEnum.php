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
}
