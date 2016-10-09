<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Order;

class OrderProduct extends Model
{
    use SoftDeletes;
    use Searchable;
    //use Notifiable;

    protected $fillable = ['cost','price','discount','representative_id','representative_comision'
        ,'representative_discount','grid_id','delivery_id'];
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function orderproducts(){
        return $this->belongsTo('App\Order');
    }
}