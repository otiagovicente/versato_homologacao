<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Contracts\OrderConformer;
use App\Services\SalesmanOrderConformer;

class OrderConformerProvider extends ServiceProvider
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

	    $this->app->singleton(OrderConformer::class, function(){
		    return new SalesmanOrderConformer();

	    });
    }
}
