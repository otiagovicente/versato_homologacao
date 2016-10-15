<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeliveryCenter extends Model
{
    private $fillable = ['name', 'description','address','city','state','zip','geo','customer_id'];

    public function customer(){
        $this->hasOne('App\Customer');
    }

}