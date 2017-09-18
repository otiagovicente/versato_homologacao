<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;
use App\Macroregion;

class Region extends Model
{
    use SoftDeletes;
    use Searchable;

    protected $fillable = ['code', 'description', 'geo', 'brand_id', 'macroregion_id'];
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function representatives(){
        return $this->belongsToMany('App\Representative')->withTimestamps();
    }

    public function macroregion(){
        return $this->belongsTo(Macroregion::class, 'macroregion_id');
    }
}
