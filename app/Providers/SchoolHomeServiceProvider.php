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
                try {
                    $decrypted_uuid = decrypt($school_cookie);
                    $school_home = \App\Models\School::where('uuid', $decrypted_uuid)->first();
                } catch (\Exception $e) {
                    report($e);
                }
            }

            $view->with('school_home', $school_home);
        });
    }
}
