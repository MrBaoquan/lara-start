<?php

namespace Mrba\LaraStart\Controllers;

use App\Http\Resources\User as ResourcesUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mrba\LaraStart\Resources\User;

class UserController extends APIController
{
    // 当前用户信息
    public function userinfo()
    {
        return $this->responseJson(new User(Auth::user()));
    }

    public function updateUserInfo(Request $request)
    {
        $input = $request->only('name', 'nick_name');
        Auth::user()->update($input);
        return $this->responseJson(new ResourcesUser(Auth::user()));
    }
}
