<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Region;
use App\Customer;

class Shop extends Model
{
    use Searchable;
    use SoftDeletes;

    protected $fillable = ['name', 'description', 'logo', 'address','geo','customer_id'];
    protected $dates    = ['created_at', 'updated_at', 'deleted_at'];

    public function region(){
    	return $this->belongsTo('App\Region');
    }
    public function customer(){
    	return $this->belongsTo('App\Customer');
    }
}
