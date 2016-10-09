<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App\Brand;
use App\Http\Controllers\BrandsController;
class CheckBrand
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    protected $except = ['BrandsController@select', 'BrandsController@getSelected'];
    public function handle($request, Closure $next)
    {
        if(Auth::check() && !$request->session()->has('brand')){

            $brand = new Brand;
            $brand = $brand->first();
            $brandsController = new BrandsController;
            $brandsController->setSelected($request, $brand);
            return $next($request);
        }
        return $next($request);
    }
}
