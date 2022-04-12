<?php

declare(strict_types=1);
/**
 * Created by PhpStorm
 * Date 2022/4/11 16:15
 */

namespace App\Controller;

use App\Request\login\LoginRequest;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\PostMapping;

#[Controller]
class LoginController extends AbstractController
{
    #[PostMapping(path: "/login")]
    public function login(LoginRequest $request)
    {
        $request->validated();
    }
}