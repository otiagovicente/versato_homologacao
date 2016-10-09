<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Grid;

class Size extends Model
{

    protected $fillable = ['size'];
    protected $dates = ['created_at', 'updated_at'];

    public function grids(){
    	return $this->belongsToMany('App\Grid')->withPivot('amount')->withTimestamps();
    }
}
