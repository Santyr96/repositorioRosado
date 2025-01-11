<?php

namespace App\Providers;

use DragonCode\Support\Facades\Http\Url;
use Illuminate\Foundation\Vite;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Vite as FacadesVite;
use Illuminate\Support\ServiceProvider;

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
        if (App::environment('production')) {
            FacadesVite::useBuildDirectory('build');
        }

        if(config('app.env') === 'production'){
            URL::forceScheme('https');
        }
    }
}
