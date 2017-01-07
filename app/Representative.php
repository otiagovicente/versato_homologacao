<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;


class Representative extends Model
{
    use Searchable;

    protected $fillable = ['code', 'user_id', 'token', 'qrcode'];
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $hidden = ['token', 'qrcode'];

    public function user(){
        return $this->belongsTo('App\User');
    }
    public function regions(){
        return $this->belongsToMany('App\Region')->withTimestamps();
    }

    public function brands(){
        return $this->belongsToMany('App\Brand')->withPivot('comission')->withTimestamps();
    }

    public function orders(){
        return $this->hasMany('App\Order');
    }
	public function toSearchableArray()
	{
		$data = $this->toArray();
		$data['user'] = $this->user->toArray();

		return $data;
	}
}
