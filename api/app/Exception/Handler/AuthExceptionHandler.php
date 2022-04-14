<?php
/**
 * Created by PhpStorm
 * Date 2022/4/12 14:53
 */

namespace App\Exception\Handler;

use App\Constants\code\AuthCodeEnum;
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
        $msg === "The token is required." && $code = AuthCodeEnum::TOKEN_DOES_NOT_EXIST;
        $msg === "Invalid signature" && $code = AuthCodeEnum::INVALID_SIGNATURE;
        $msg === "Token expired" && $code = AuthCodeEnum::TOKEN_EXPIRED;
        $msg === "token expired, refresh is not supported" && $code = AuthCodeEnum::REFRESH_TOKEN_EXPIRED;
        $msg === "The token is already on the blacklist" && $code = AuthCodeEnum::TOKEN_ON_BLACKLIST;

        $data = Json::encode([
            "code" => $code,
            "msg" => AuthCodeEnum::getMessage($code) ?: $throwable->getMessage(),
        ]);
        return $response->withAddedHeader('content-type', 'application/json; charset=utf-8')
            ->withStatus(401)
            ->withBody(new SwooleStream($data));
    }

    public function isValid(Throwable $throwable): bool
    {
        return $throwable instanceof AuthException || $throwable instanceof JWTException;
    }
}