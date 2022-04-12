<?php

declare(strict_types=1);
/**
 * Created by PhpStorm
 * Date 2022/4/11 16:15
 */

namespace App\Controller;

use App\Constants\CodeEnum;
use App\Request\login\LoginRequest;
use App\Service\LoginService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\Middleware;
use Hyperf\HttpServer\Annotation\PostMapping;
use Qbhy\HyperfAuth\AuthMiddleware;

#[Controller]
class LoginController extends AbstractController
{
    #[Inject]
    protected LoginService $loginService;

    #[PostMapping(path: "/login")]
    public function login(LoginRequest $request): array
    {
        $data = $request->validated();

        $user = $this->loginService->login($data);

        $token =  $this->auth->login($user);

        return $this->response(CodeEnum::LOGIN_SUCCESSFUL,[
            "token" => $token
        ]);
    }

    #[GetMapping(path: "/login/refreshToken")]
    public function refreshToken()
    {
        return $this->auth->refresh();
    }
}