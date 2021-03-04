<?php

namespace Mrba\LaraStart\Controllers;


use Illuminate\Support\Facades\Auth;
use Mrba\LaraStart\Resources\User;

class UserController extends APIController
{
    // 当前用户信息
    public function userinfo()
    {
        return $this->responseJson(new User(Auth::user()));
    }
}
