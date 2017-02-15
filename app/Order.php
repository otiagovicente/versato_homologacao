<?php

namespace App;

use App\OrderProduct;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Scout\Searchable;
use App\Brand;
class Order extends Model
{
    use SoftDeletes;
    use Searchable;
    use Notifiable;

    protected $fillable = ['cost','price','overalldiscount','status_id','customer_id','representative_id', 'discount',
        'representative_commission', 'representative_commission_discount','representative_percentage', 'representative_discount', 'customer_discount', 'deliverycenter_id', 'comment', 'total'];
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
    public function brands()
    {
	    return $this->belongsToMany(Brand::class)->withPivot('cost', 'price', 'discount', 'brand_id', 'customer_discount', 'representative_id', 'representative_commission', 'representative_commission_discount', 'representative_commission_percentage', 'representative_discount', 'total', 'overalldiscount', 'amount')
		    ->withTimestamps();

    }
    public function deliverycenter(){
        return $this->belongsTo(Deliverycenter::class);
    }

    public function toSearchableArray()
	{
		$data = $this->toArray();
		$data['updated_at'] =  Carbon::parse($data['updated_at'])->timestamp;
		$data['deleted_at'] =  Carbon::parse($data['deleted_at'])->timestamp;
		$data['created_at'] =  Carbon::parse($data['created_at'])->timestamp;
		$data['products'] = $this->products->toArray();
		$data['representative'] = $this->representative->toArray();
		$data['customer'] = $this->customer->toArray();

		return $data;
	}
}
