<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Macroregion extends Model
{
    use Searchable;
    use SoftDeletes;

    protected $fillable = ['code', 'description', 'brand_id', 'geo'];
    protected $dates    = ['created_at', 'updated_at', 'deleted_at'];
}
