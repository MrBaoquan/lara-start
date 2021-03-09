<?php

namespace Mrba\LaraStart\Controllers;

use Mrba\LaraStart\Controllers\ApiResponse\APIErrorCode;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Mrba\LaraStart\Models\WXUser as User;

class AuthController extends APIController
{
    public function login(Request $request)
    {
        $openid = $request->input('openid');
        $user = User::where('openid', $openid)->first();
        if (!isset($user)) {
            $user = User::create([
                'name' => $openid,
                'email' => $openid . '@default.com',
                'password' => Hash::make($openid),
                'openid' => $openid
            ]);
        }
        return $this->responseJson([
            'access_token' => $this->createToken($user)->plainTextToken
        ]);
    }

    public function wechat(Request $request)
    {
        $user = session('wechat.oauth_user.default'); // 拿到授权用户资料
        $userInfo = Arr::except($user['raw'], 'privilege');
        $redirectUrl = $request->input('redirect');
        parse_str(Arr::get(parse_url($redirectUrl), 'query', ''), $queries);
        $redirectUrl = (explode('?', $redirectUrl))[0] . '?' . http_build_query(array_merge($queries, $userInfo));
        return redirect()->to($redirectUrl);
    }

    public function ProxyAuthWechat(Request $request)
    {
        $input = $request->all();
        $openid = Arr::get($input, 'openid');
        $user = config('larastart.users_model')::where('openid', Arr::get($input, 'openid'))->first();
        $appUrl = $request->query('redirect');
        if (!isset($appUrl)) {
            return $this->responseError(APIErrorCode::InvalidParams);
        }

        if (!isset($user)) {
            $user = config('larastart.users_model')::create([
                'name' => Arr::get($input, 'nickname', $openid),
                'nick_name' => Arr::get($input, 'nickname', '新用户_' . substr($openid, -5)),
                'email' => Arr::get($input, 'email', $openid . '@example.com'),
                'password' => Hash::make($openid),
                'openid' => $openid,
                'gender' => Arr::get($input, 'sex', 0),
                'avatar_url' => Arr::get($input, 'headimgurl'),
                'country' => Arr::get($input, 'country'),
                'province' => Arr::get($input, 'province'),
                'city' => Arr::get($input, 'city')
            ]);
        }
        return redirect()
            ->to('http://' . $appUrl . '?access_token=' . $this->createToken($user)->plainTextToken);
    }

    private function createToken($user)
    {
        $user->tokens()->delete();
        return $user->createToken('auth');
    }
}
