<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;


/*
 *  Used Models
 */
use App\Product;
use App\Brand;

class Tag extends Model
{

    use Searchable;

    protected $fillable = ['description', 'brand_id'];

    public function products(){
        return $this->belongsToMany(Product::class);
    }

    public function brand(){
        return $this->belongsTo(Brand::class);
    }


}
