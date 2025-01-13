<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ActionServiceProvider extends ServiceProvider
{
    public array $bindings = [
        \App\Contracts\Actions\Auth\LoginActionContract::class      => \App\Actions\Auth\LoginAction::class,
        \App\Contracts\Actions\Auth\RegisterActionContract::class   => \App\Actions\Auth\RegisterAction::class,
        \App\Contracts\Actions\Auth\LogoutActionContract::class     => \App\Actions\Auth\LogoutAction::class
    ];
    /**
     * Register services.
     */
    public function register(): void
    {

    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
