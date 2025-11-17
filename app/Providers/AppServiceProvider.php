<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Route;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;
use Blade;
use Session;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        // Laravel 9 defaults
        Paginator::useBootstrap();
        Schema::defaultStringLength(191);

        Blade::directive('toastr', function ($expression){
            return "<script>
                    toastr.{{ Session::get('alert-type') }}($expression)
                 </script>";
        });

        // === Module Auto Loader (From Laravel 11 Project) ===

        $modulesPath = base_path('app/Modules');

        if (!File::exists($modulesPath)) {
            return;
        }

        $modules = collect(File::directories($modulesPath))
            ->mapWithKeys(function ($path) {
                $moduleName = ucfirst(basename($path));
                return [$moduleName => $path];
            });

        foreach ($modules as $module => $modulePath) {
            $this->registerModule($module, $modulePath);
        }

        // Load Default API routes
        if (File::exists(base_path('routes/api.php'))) {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));
        }
    }

    private function registerModule(string $module, string $modulePath): void
    {
        $routesPath = "{$modulePath}/Routes";
        $viewsPath = "{$modulePath}/Resources/views";
        $migrationsPath = "{$modulePath}/Database/Migrations";

        // Load Web Routes
        if (File::exists("{$routesPath}/web.php")) {
            Route::middleware('web')
                ->group("{$routesPath}/web.php");
        }

        // Load API Routes
        if (File::exists("{$routesPath}/api.php")) {
            Route::middleware('api')
                ->prefix('api')
                ->group(function () use ($routesPath) {
                    require "{$routesPath}/api.php";
                });
        }

        // Views
        if (File::exists($viewsPath)) {
            View::addNamespace(strtolower($module), $viewsPath);
        }

        // Migrations
        // Uncomment if needed
        // if (File::exists($migrationsPath)) {
        //     $this->loadMigrationsFrom($migrationsPath);
        // }
    }
}
