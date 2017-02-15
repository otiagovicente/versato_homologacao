<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;

class Brand extends Model
{
	use SoftDeletes;
	use Searchable;

    protected $fillable = ['name', 'description', 'image', 'logo'];
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function products(){
    	return $this->hasMany('App\Product')->with('brand', 'line', 'material', 'color', 'grids');
    }

    public function retrieveProducts(){
    	     return $this->products()->with('brand', 'line', 'material', 'color', 'grids');

    }

    public function representatives(){
	    return $this->belongsToMany('App\Representative')->withPivot( 'brand_id', 'representative_id', 'commission')->withTimestamps();
    }

    public function orders(){
	    return $this->belongsToMany(Order::class)->withPivot('cost', 'price', 'discount', 'brand_id', 'customer_discount', 'representative_commission', 'representative_commission_discount', 'representative_commission_percentage', 'representative_discount', 'total', 'overalldiscount', 'amount')
		    ->withTimestamps();
    }
}