<?php

namespace App\Providers;

use App\Services\TodoService;
use App\Services\implement\UserService;
use App\Services\UserServiceInterface;
use App\Services\TodoServiceInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        Model::unguard();

        // 
        $this->app->bind(UserServiceInterface::class, UserService::class);
        $this->app->bind(TodoServiceInterface::class, TodoService::class);
    }
}
