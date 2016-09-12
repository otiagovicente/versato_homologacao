<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;

class Material extends Model
{
	use SoftDeletes;
    use Searchable;

    protected $fillable = ['code', 'description', 'sample', 'brand_id'];
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function products(){
    	return $this->hasMany('App\Product');
    }

}
