<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\OrderProduct;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;

class Order extends Model
{
    use SoftDeletes;
    use Searchable;
    //use Notifiable;

    protected $fillable = ['cost','price','overalldiscount','status_id','customer_id','representative_id',
        'representative_comision','representative_discount'];
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function orderproducts(){
        return $this->belongsToMany(OrderProduct::class);
    }
}
