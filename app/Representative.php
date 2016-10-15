<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Representative extends Model
{
    use Searchable;

    protected $fillable = ['code', 'user_id', 'region_id'];
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function user(){
        return $this->belongsTo('App\User');
    }
    public function region(){
        return $this->belongsTo('App\Region');
    }

    public function brands(){
        return $this->belongsToMany('App\Brand')->with('comision');
    }
}
