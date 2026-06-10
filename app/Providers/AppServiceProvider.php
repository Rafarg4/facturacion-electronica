<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Empresa;
use Illuminate\Support\Facades\View;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
   

    public function boot()
    {
        View::composer('*', function ($view) {
            $empresa = Empresa::first();
            $view->with('empresa', $empresa);
        });
    }
}
