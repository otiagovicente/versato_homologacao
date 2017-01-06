<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Size;
use App\Product;


class Grid extends Model
{
	use SoftDeletes;

    protected $fillable = ['code','description', 'brand_id'];
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    
    public function sizes(){
    	return $this->belongsToMany('App\Size')->withPivot('amount')->withTimestamps();
    }

    public function products(){
    	return $this->belongsToMany(Product::class);
    }

	public function getTotalAttribute($value)
	{

		$total = 0;
		$sizes = $this->sizes()->get();
		foreach ($sizes as $size){
			$total += $size->pivot->amount;
		}


		return $total;
	}
}
