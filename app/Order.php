<?php

namespace App;

use App\OrderProduct;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Scout\Searchable;

class Order extends Model
{
    use SoftDeletes;
    use Searchable;
    use Notifiable;

    protected $fillable = ['cost','price','overalldiscount','status_id','customer_id','representative_id',
        'representative_comision','representative_discount', 'delivery_id', 'comment', 'total'];
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function products(){
        return $this->belongsToMany(Product::class)->withPivot('cost', 'price','discount', 'representative_id', 'representative_comission', 'representative_discount', 'client_discount', 'grid_id', 'total')
            ->with('line','material','color', 'grids')->withTimestamps();
    }
    public function representative(){
        return $this->belongsTo(Representative::class)->with('user');
    }
    public function customer(){
        return $this->belongsTo(Customer::class);
    }
}
