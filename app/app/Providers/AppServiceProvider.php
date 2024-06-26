<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Packages\Repository\TodoRepository;
use Packages\Repository\TodoRepositoryInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(TodoRepositoryInterface::class, function() {
            return new TodoRepository();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
