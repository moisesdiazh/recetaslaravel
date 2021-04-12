<?php

namespace App\Providers;

use View;
use App\CategoriaReceta;
use Illuminate\Support\ServiceProvider;

class CategoriasProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register() //cuando no requieres laravel
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot() //cuando requieres hacer algo de laravel
    {
        View::composer('*', function ($view) {
            $categorias = CategoriaReceta::all(); 
            $view->with('categorias', $categorias);
        });
    }
}
