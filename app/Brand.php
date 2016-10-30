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
    	return $this->hasMany('App\Product');
    }

    public function retrieveProducts(){
    	return $this->products()->with('brand')->with('line')->with('reference')->with('material')->with('color')->with('grids');
    }

    public function representatives(){
        return $this->belongsToMany('App\Representative')->with('comission');
    }

}