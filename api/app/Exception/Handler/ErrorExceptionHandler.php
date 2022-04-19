<?php
/**
 * Created by PhpStorm
 * Date 2022/4/12 10:50
 */

namespace App\Exception\Handler;

use App\Exception\ErrorException;
use Hyperf\ExceptionHandler\ExceptionHandler;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Hyperf\Utils\Codec\Json;
use Psr\Http\Message\ResponseInterface;
use Throwable;

class ErrorExceptionHandler extends ExceptionHandler
{

    public function handle(Throwable $throwable, ResponseInterface $response): ResponseInterface
    {
        $this->stopPropagation();
        /** @var ErrorException $throwable */
        $data = Json::encode([
            "code" => $throwable->getCode(),
            "msg" => $throwable->getMessage(),
        ]);
        return $response->withAddedHeader('content-type', 'application/json; charset=utf-8')
            ->withStatus(200)
            ->withBody(new SwooleStream($data));
    }

    public function isValid(Throwable $throwable): bool
    {
        return $throwable instanceof ErrorException;
    }
}