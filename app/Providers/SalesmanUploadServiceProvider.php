<?php

namespace App\Providers;

use App\Contracts\Upload;
use App\Services\SalesmanUpload;
use Illuminate\Support\ServiceProvider;

class SalesmanUploadServiceProvider extends ServiceProvider
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
	    $this->app->singleton(Upload::class, function(){
		    $config = config('services.upload');
		    return new SalesmanUpload($config['driver'], $config['public']);

	    });
    }
}
