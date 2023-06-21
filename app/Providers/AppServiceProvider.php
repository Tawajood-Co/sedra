<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\{NotificationRepositoryinterface,CartRepositoryInterface};
use App\Repositories\{NotificationRepository,CartRepository};
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(NotificationRepositoryInterface::class,NotificationRepository::class);
        $this->app->bind(CartRepositoryInterface::class,CartRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
