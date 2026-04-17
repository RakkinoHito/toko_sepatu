<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if (config('app.debug')) {
            error_reporting(E_ALL);
            ini_set('display_errors', 1);
        }
    }
}