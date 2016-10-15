<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use App\Shop;

class Customer extends Model
{
    use Searchable;

    protected $fillable = ['code', 'cuit', 'company', 'name', 'logo', 'address', 'city','state', 'zip', 'phone1', 'phone2','phone3','email', 'geo', 'region_id'];

    protected $dates = ['updated_at', 'created_at', 'deleted_at'];



    public function shops(){
        return $this->hasMany('App\Shop');
    }

}

