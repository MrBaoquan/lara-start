<?php

namespace Mrba\LaraStart\Controllers;

use App\Http\Resources\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // 当前用户信息
    public function userinfo()
    {
        return $this->responseJson(new User(Auth::user()));
    }
}
