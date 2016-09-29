<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;

class Region extends Model
{
    use SoftDeletes;
    use Searchable;

    protected $fillable = ['id','code', 'description', 'geo', 'brand_id', 'masterregion_id'];
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
}
