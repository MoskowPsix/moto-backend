<?php

namespace App\Providers;

use App\Contracts\Services\GoogleSheetServiceContract;
use App\Services\GoogleSheetService;
use Illuminate\Support\ServiceProvider;

class ServicesServiceProvider extends ServiceProvider
{
    public array $bindings = [
        GoogleSheetServiceContract::class                          => GoogleSheetService::class,
    ];
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
