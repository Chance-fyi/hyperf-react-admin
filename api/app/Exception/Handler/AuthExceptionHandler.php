<?php
/**
 * Created by PhpStorm
 * Date 2022/4/12 14:53
 */

namespace App\Exception\Handler;

use App\Constants\code\CodeEnum;
use Hyperf\ExceptionHandler\ExceptionHandler;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Hyperf\Utils\Codec\Json;
use Psr\Http\Message\ResponseInterface;
use Qbhy\HyperfAuth\Exception\AuthException;
use Qbhy\SimpleJwt\Exceptions\JWTException;
use Throwable;

class AuthExceptionHandler extends ExceptionHandler
{

    public function handle(Throwable $throwable, ResponseInterface $response): ResponseInterface
    {
        $this->stopPropagation();

        $code = $throwable->getCode() ?: 999999;
        $msg = $throwable->getMessage();
        $msg === "The token is required." && $code = CodeEnum::TOKEN_DOES_NOT_EXIST;
        $msg === "Invalid token" && $code = CodeEnum::INVALID_SIGNATURE;
        $msg === "Invalid signature" && $code = CodeEnum::INVALID_SIGNATURE;
        $msg === "Token expired" && $code = CodeEnum::TOKEN_EXPIRED;
        $msg === "token expired, refresh is not supported" && $code = CodeEnum::REFRESH_TOKEN_EXPIRED;
        $msg === "The token is already on the blacklist" && $code = CodeEnum::TOKEN_ON_BLACKLIST;

        $data = Json::encode([
            "code" => $code,
            "msg" => CodeEnum::getMessage($code) ?: $throwable->getMessage(),
        ]);
        return $response->withAddedHeader('content-type', 'application/json; charset=utf-8')
            ->withStatus(200)
            ->withBody(new SwooleStream($data));
    }

    public function isValid(Throwable $throwable): bool
    {
        return $throwable instanceof AuthException || $throwable instanceof JWTException;
    }
}