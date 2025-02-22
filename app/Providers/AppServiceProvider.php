<?php

namespace App\Providers;

use App\Models\ClassTime;
use App\Models\ClassSession;
use App\Observers\ClassTimeObserver;
use Illuminate\Foundation\AliasLoader;
use App\Observers\ClassSessionObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void {}

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        ClassTime::observe(ClassTimeObserver::class);
        ClassSession::observe(ClassSessionObserver::class);
    }
}
