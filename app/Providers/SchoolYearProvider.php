<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class SchoolYearProvider extends ServiceProvider
{
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
        view()->composer('*', function ($view) {
            $view->with('school_year', \App\Models\SchoolYear::where('active', 1)->first());
        });
    }
}
