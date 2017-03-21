<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;
class Color extends Model
{
	use SoftDeletes;
	use Searchable;
	
    protected $fillable = ['code', 'description', 'color', 'pantone', 'brand_id'];
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function products(){
        return $this->hasMany('App\Product')->with('line', 'material', 'color', 'brand');
    }
}
