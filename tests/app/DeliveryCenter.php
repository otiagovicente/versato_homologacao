<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Deliverycenter extends Model
{
    protected $fillable = ['name', 'description','address','city','state','zip','geo','customer_id'];

    public function customer(){
        $this->hasOne('App\Customer');
    }

}