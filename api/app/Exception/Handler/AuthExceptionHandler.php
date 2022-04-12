<?php
/**
 * Created by PhpStorm
 * Date 2022/4/12 14:53
 */

namespace App\Exception\Handler;

use App\Constants\CodeEnum;
use Hyperf\ExceptionHandler\ExceptionHandler;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Hyperf\Utils\Codec\Json;
use Hyperf\Utils\Str;
use Psr\Http\Message\ResponseInterface;
use Qbhy\HyperfAuth\Exception\AuthException;
use Qbhy\HyperfAuth\Exception\GuardException;
use Qbhy\HyperfAuth\Exception\UnauthorizedException;
use Qbhy\HyperfAuth\Exception\UserProviderException;
use Qbhy\SimpleJwt\Exceptions\InvalidTokenException;
use Qbhy\SimpleJwt\Exceptions\JWTException;
use Qbhy\SimpleJwt\Exceptions\SignatureException;
use Qbhy\SimpleJwt\Exceptions\TokenBlacklistException;
use Qbhy\SimpleJwt\Exceptions\TokenExpiredException;
use Qbhy\SimpleJwt\Exceptions\TokenNotActiveException;
use Qbhy\SimpleJwt\Exceptions\TokenProviderException;
use Qbhy\SimpleJwt\Exceptions\TokenRefreshExpiredException;
use Throwable;

class AuthExceptionHandler extends ExceptionHandler
{

    public function handle(Throwable $throwable, ResponseInterface $response): ResponseInterface
    {
        $this->stopPropagation();

        $code = $throwable->getCode() ?: 999999;
        $msg = $throwable->getMessage();
        $msg === "The token is required." && $code = CodeEnum::TOKEN_DOES_NOT_EXIST;
        $msg === "Invalid signature" && $code = CodeEnum::INVALID_SIGNATURE;
        $msg === "Token expired" && $code = CodeEnum::TOKEN_EXPIRED;

        $data = Json::encode([
            "code" => $code,
            "msg" => CodeEnum::getMessage($code) ?: $throwable->getMessage(),
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