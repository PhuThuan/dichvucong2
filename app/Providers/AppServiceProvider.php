<?php

namespace App\Providers;

use App\Console\Commands;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    protected $defer = false;
    public function register(): void
    {
        $this->commands(
            'App\Console\Commands\CrudCommand',
            'App\Console\Commands\CrudControllerCommand',
            'App\Console\Commands\CrudModelCommand',
            'App\Console\Commands\CrudMigrationCommand',
            'App\Console\Commands\CrudViewCommand',
            'App\Console\Commands\CrudLangCommand',
            'App\Console\Commands\CrudApiCommand',
            'App\Console\Commands\CrudApiControllerCommand'
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        
    }
    
}
