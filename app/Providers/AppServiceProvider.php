<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Sanctum\Sanctum;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
       // if($this->app->environment('production')) {
           // URL::forceScheme('https');
        //}

        Blade::directive('schoolRole', function ($expression) {
            list($role, $school) = explode(',', trim($expression, '()'));
            return "<?php if(auth()->user()->hasRoleForSchool($role, $school)): ?>";
        });

        Blade::directive('endschoolRole', function () {
            return '<?php endif; ?>';
        });

        Blade::directive('schoolPermission', function ($expression) {
            list($permission, $school) = explode(',', trim($expression, '()'));
            return "<?php if(auth()->user()->hasPermissionForSchool($permission, $school)): ?>";
        });

        Blade::directive('endschoolPermission', function () {
            return '<?php endif; ?>';
        });

    }
}
