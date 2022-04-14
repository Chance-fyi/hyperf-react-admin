<?php

declare(strict_types=1);
/**
 * Created by PhpStorm
 * Date 2022/4/12 11:07
 */

namespace App\Service;

use App\Constants\code\AuthCodeEnum;
use App\Exception\ErrorException;
use App\Model\User;

class LoginService
{
    public function login(array $data): User
    {
        /** @var User $user */
        $user = User::query()->where('username',$data['username'])->first();

        if (!$user){
            throw new ErrorException(AuthCodeEnum::AUTH_LOGIN_FAILED);
        }

        if (!password_verify($data['password'],$user->password)){
            throw new ErrorException(AuthCodeEnum::AUTH_LOGIN_FAILED);
        }

        return $user;
    }
}