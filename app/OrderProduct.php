<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Order;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;

class OrderProduct extends Model
{
    use SoftDeletes;
    use Searchable;
    //use Notifiable;

    protected $fillable = ['cost','price','discount','representative_id','representative_comision'
        ,'representative_discount','grid_id', 'order_id', 'product_id'];
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function orders(){
        return $this->belongsToMany('Order');
    }
}

