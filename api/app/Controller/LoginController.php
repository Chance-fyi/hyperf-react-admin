<?php

declare(strict_types=1);
/**
 * Created by PhpStorm
 * Date 2022/4/11 16:15
 */

namespace App\Controller;

use App\Constants\code\CodeEnum;
use App\Request\login\LoginRequest;
use App\Service\LoginService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\Middleware;
use Hyperf\HttpServer\Annotation\PostMapping;
use Qbhy\HyperfAuth\AuthMiddleware;

#[Controller(prefix: "api")]
class LoginController extends AbstractController
{
    #[Inject]
    protected LoginService $loginService;

    #[PostMapping(path: "login")]
    public function login(LoginRequest $request): array
    {
        $data = $request->validated();

        $user = $this->loginService->login($data);

        $token = $this->auth->login($user);

        return $this->response(CodeEnum::SUCCESS, [
            "token" => $token
        ], "登录成功");
    }

    #[GetMapping(path: "login/refreshToken")]
    public function refreshToken(): array
    {
        $token = $this->auth->refresh();

        if (!$token) {
            return $this->response(CodeEnum::TOKEN_DOES_NOT_EXIST);
        }

        return $this->response(CodeEnum::SUCCESS, [
            "token" => $token
        ]);
    }

    #[GetMapping(path: "logout")]
    #[Middleware(AuthMiddleware::class)]
    public function logout(): array
    {
        $this->auth->logout();
        return $this->response(CodeEnum::SUCCESS);
    }
}