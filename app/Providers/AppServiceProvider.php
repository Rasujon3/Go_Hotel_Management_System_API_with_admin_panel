<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        /**
         * ==========================================
         * Basic Laravel configurations
         * ==========================================
         */
        Schema::defaultStringLength(191);
        Paginator::useBootstrap();

        /**
         * ==========================================
         * Toastr Blade Directive
         * ==========================================
         */
        Blade::directive('toastr', function ($expression) {
            return "<script>
                    toastr.{{ Session::get('alert-type') }}($expression)
                 </script>";
        });

        /**
         * ==========================================
         * Load Modular Architecture (Web + API)
         * ==========================================
         * NOTE:
         * - Do NOT load routes/api.php manually
         * - Laravel RouteServiceProvider already handles it
         */

        $modulesPath = base_path('app/Modules');

        if (!File::exists($modulesPath)) {
            return;
        }

        $modules = File::directories($modulesPath);

        foreach ($modules as $modulePath) {
            $this->registerModule($modulePath);
        }
    }

    /**
     * Register a single module
     */
    private function registerModule(string $modulePath): void
    {
        $routesPath     = $modulePath . '/Routes';
        $viewsPath      = $modulePath . '/Resources/views';

        /**
         * ------------------------------------------
         * Load WEB Routes (Session + Auth Enabled)
         * ------------------------------------------
         */
        if (File::exists($routesPath . '/web.php')) {
            Route::middleware('web')
                ->group($routesPath . '/web.php');
        }

        /**
         * ------------------------------------------
         * Load API Routes (Stateless)
         * ------------------------------------------
         */
        if (File::exists($routesPath . '/api.php')) {
            Route::middleware('api')
                ->prefix('api')
                ->group($routesPath . '/api.php');
        }

        /**
         * ------------------------------------------
         * Load Views with Module Namespace
         * ------------------------------------------
         */
        if (File::exists($viewsPath)) {
            $moduleName = strtolower(basename($modulePath));
            View::addNamespace($moduleName, $viewsPath);
        }
    }
}
