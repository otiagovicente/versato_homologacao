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

    protected $fillable = ['cost','price','total_discount','status_id','customer_id','representative_id',
        'representative_commission', 'deliverycenter_id', 'comment', 'total', 'representative_commission_total',
        'representative_commission_price', 'company_total_discount', 'total_without_discount', 'company_real_discount', 'products_amount', 'representative_commission_discount', 'representative_commission_percentage', 'company_discount', 'representative_discount'];
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function products(){
        return $this->belongsToMany('App\Product')->withPivot('product_id','cost','price', 'grid_id',
            'representative_commission', 'total', 'representative_commission_total', 'representative_commission_company',
            'representative_commission_price', 'company_total_discount', 'total_without_discount', 'products_amount',
            'representative_commission_discount', 'representative_commission_percentage', 'company_discount', 'representative_discount')
            ->withTimestamps();
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
