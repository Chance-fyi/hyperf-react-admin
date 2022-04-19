<?php

declare(strict_types=1);
/**
 * Created by PhpStorm
 * Date 2022/4/18 16:23
 */

namespace App\Controller;

use App\Constants\code\CodeEnum;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\Middleware;
use Qbhy\HyperfAuth\AuthMiddleware;

#[Controller(prefix: "api/user")]
#[Middleware(AuthMiddleware::class)]
class UserController extends AbstractController
{
    #[GetMapping(path: "currentUser")]
    public function currentUser(): array
    {
        $user = $this->auth->user();
        unset($user["password"]);
        return $this->response(CodeEnum::SUCCESS, $user);
    }
}