<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Contracts\Search;
use AlgoliaSearch\Client;
use App\Services\AlgoliaSearch;

class SearchServiceProvider extends ServiceProvider
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

        $this->app->singleton(Search::class, function(){
            $config = config('services.algolia');
            return new AlgoliaSearch(
                new Client($config['app_id'], $config['api_key'])
            );
                     
        });

    }
}
