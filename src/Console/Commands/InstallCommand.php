<?php

namespace Mrba\LaraStart\Console\Commands;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lrstart:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // horizon 资源发布
        $this->call('horizon:install');


        // laravel-admin 安装
        $this->call('admin:install');
        $this->call('telescope:install');

        // 迁移数据库 sanctum
        $this->call('migrate');
        return 0;
    }
}
