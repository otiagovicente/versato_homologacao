<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Order;
class Orderstatus extends Model
{
	protected $table = 'orderstatus';
	protected $fillable = ['description', 'color', 'icon'];

	public function orders(){
		return $this->hasMany(Order::class);
	}
}
