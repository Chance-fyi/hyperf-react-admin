<?php
/**
 * Created by PhpStorm
 * Date 2022/4/12 10:48
 */

namespace App\Exception;

use App\Constants\CodeEnum;
use Hyperf\Server\Exception\ServerException;
use Throwable;

class ErrorException extends ServerException
{
    public function __construct(int $code = 0, string $message = null, Throwable $previous = null)
    {
        if (is_null($message)) {
            $message = CodeEnum::getMessage($code);
        }

        parent::__construct($message, $code, $previous);
    }
}