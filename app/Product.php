<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;
use Carbon\Carbon;

use App\Grid;
use App\Tag;


class Product extends Model
{
    use SoftDeletes;
    use Searchable;

    protected $fillable = ['code','brand_id', 'line_id', 'reference_id',
        'material_id', 'color_id', 'photo', 'cost', 'price', 'published', 'launch'];
    protected $dates = ['created_at', 'updated_at', 'deleted_at', 'launch'];
    protected $casts = [
        'published' => 'boolean',
    ];
    protected $hidden = ['cost'];

    public function brand(){
    	return $this->belongsTo('App\Brand');
    }
    public function line(){
    	return $this->belongsTo('App\Line');
    }
    public function reference(){
    	return $this->belongsTo('App\Reference');
    }
    public function material(){
    	return $this->belongsTo('App\Material');
    }
    public function color(){
    	return $this->belongsTo('App\Color');
    }
    public function grids(){
        return $this->belongsToMany(Grid::class);
    }
    public function gridsAndSizes(){
        return $this->belongsToMany(Grid::class)->with('sizes');
    }
    public function tags(){
        return $this->belongsToMany(Tag::class);
    }


//    public function setLaunchAttribute($value){
//        $this->attributes['launch'] = Carbon::createFromFormat('d/m/Y', $value);
//    }
//
//    public function getLaunchAttribute($value){
//        $date = new Carbon($value);
//        return $date->format('d/m/Y');
//    }

    public function getGridListAttribute(){
        return $this->grids()->pluck('id');
    }

    public function getTagListAttribute(){
        return $this->tags()->pluck('id');
    }

}
