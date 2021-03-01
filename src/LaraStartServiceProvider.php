<?php

namespace Mrba\LaraStart;

use Illuminate\Support\ServiceProvider;

class LaraStartServiceProvider extends ServiceProvider
{

    protected $routeMiddleware = [
        'wechat.mock' => Middleware\MockWechatOAuth::class,
        'proxy.wechat.oauth' => Middleware\ProxyWechatOAuth::class
    ];

    protected $commands = [
        Console\Commands\PublishCommand::class,
        Console\Commands\InstallCommand::class,
        Console\Commands\EnvCommand::class
    ];

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->commands($this->commands);
        $this->registerMiddleware();
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
        $this->loadRoutesFrom(__DIR__ . '/../routes.php');

        $this->registerPublishing();
    }

    // 资源发布
    protected function registerPublishing()
    {
        $this->publishes([
            __DIR__ . '/../config/larastart.php' => config_path('larastart.php')
        ]);

        $this->publishes([__DIR__ . '/../database/migrations' => database_path('migrations')]);
    }

    // 中间件注册
    protected function registerMiddleware()
    {
        foreach ($this->routeMiddleware as $key => $middleware) {
            app('router')->aliasMiddleware($key, $middleware);
        }
    }
}
