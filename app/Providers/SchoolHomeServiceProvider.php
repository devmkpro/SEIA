<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class SchoolHomeServiceProvider extends ServiceProvider
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
            $school_cookie = request()->cookie('school_home');
            $school_home = null;

            if ($school_cookie) {
                $school_home = \App\Models\School::where('uuid', decrypt($school_cookie))->first();
            }

            $view->with('school_home', $school_home);
        });
    }
}
