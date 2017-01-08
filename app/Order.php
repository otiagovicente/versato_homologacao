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
        'representative_commission', 'representative_commission_discount', 'representative_discount', 'customer_discount', 'deliverycenter_id', 'comment', 'total'];
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function products(){
        return $this->belongsToMany(Product::class)->withPivot('cost', 'price','discount', 'customer_discount','representative_id', 'representative_commission', 'representative_discount', 'total_discount', 'grid_id', 'total', 'amount')
            ->with('line','material','color', 'grids')->withTimestamps();
    }
    public function representative(){
        return $this->belongsTo(Representative::class)->with('user');
    }
    public function customer(){
        return $this->belongsTo(Customer::class);
    }
    public function deliverycenter(){
        return $this->belongsTo(Deliverycenter::class);
    }
}
