<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        /* Added By PalkyInc */
        $this->app->bind('path.public', function() {
        return base_path().'/public_html'; // como moficar esta linea para que me imprima correctamente
        });
        /* Para que funcione desde public_html */
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
