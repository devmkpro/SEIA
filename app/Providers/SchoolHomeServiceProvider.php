<?php

namespace App\Providers;

use App\Models\School;
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
                    $decrypted_code = decrypt($school_cookie);
                    $school_home = School::where('code', $decrypted_code)->first();
                } catch (\Exception $e) {
                    report($e);
                }
            }

            $view->with('school_home', $school_home);
        });
    }
}
