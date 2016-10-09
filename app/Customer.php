<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Customer extends Model
{
    use Searchable;

    protected $fillable = ['code', 'cuit', 'company', 'name', 'logo', 'address', 'geo', 'region_id'];

    protected $dates = ['updated_at', 'created_at', 'deleted_at'];



}

