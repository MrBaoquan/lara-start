<?php

return [
    "wechat_oauth_proxy" => env('WECHAT_OAUTH_PROXY'),
    'users_table' => 'users',
    'users_model' => Mrba\LaraStart\Models\WXUser::class,
];
