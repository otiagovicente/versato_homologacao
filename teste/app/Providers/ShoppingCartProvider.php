<?php

namespace App\Providers;

use App\Services\SalesmanShoppingCart;
use Illuminate\Support\ServiceProvider;
use App\Contracts\ShoppingCart;

class ShoppingCartProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {

	    $this->app->singleton(ShoppingCart::class, function(){
		    return new SalesmanShoppingCart();

	    });

    }
}
