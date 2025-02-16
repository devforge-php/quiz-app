<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        $this->routes(function () {
         
            Route::middleware('api')
                ->prefix('auth')
                ->group(base_path('routes/auth.php'));
                Route::middleware('api')
                ->prefix('profile')
                ->group(base_path('routes/profile.php'));
                Route::middleware('api')
                ->prefix('admin/admin')
                ->group(base_path('routes/admin/admin.php'));
                Route::middleware('api')
                ->prefix('users/user')
                ->group(base_path('routes/users/user.php'));
        });
    }
}
