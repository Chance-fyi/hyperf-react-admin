<?php
/**
 * Created by PhpStorm
 * Date 2022/4/11 17:12
 */

namespace App\Middleware;

use Hyperf\HttpMessage\Stream\SwooleStream;
use Hyperf\Utils\Codec\Json;
use Hyperf\Utils\Context;
use Hyperf\Validation\Middleware\ValidationMiddleware as Middleware;
use Hyperf\Validation\UnauthorizedException;
use Psr\Http\Message\ResponseInterface;

class ValidationMiddleware extends Middleware
{
    protected function handleUnauthorizedException(UnauthorizedException $exception): ResponseInterface
    {
        return Context::override(ResponseInterface::class, function (ResponseInterface $response) {
            $data = Json::encode([
                'code' => 403,
                'msg' => '没有权限'
            ]);
            return $response->withStatus(403)
                ->withAddedHeader('content-type', 'application/json; charset=utf-8')
                ->withBody(new SwooleStream($data));
        });
    }
}