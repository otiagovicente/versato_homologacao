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

    protected $fillable = ['code', 'code_beirario', 'brand_id', 'line_id',
        'material_id', 'color_id', 'photo', 'cost', 'price', 'published', 'launch'];
    protected $dates = ['created_at', 'updated_at', 'deleted_at', 'launch'];
    protected $casts = [
        'published' => 'boolean',
        'line_id' => 'integer',
        'material_id' => 'integer',
        'color_id' => 'integer',

    ];


//    protected $hidden = ['cost'];

    public function brand(){
    	return $this->belongsTo('App\Brand');
    }
    public function line(){
    	return $this->belongsTo('App\Line');
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

    public function grids_select(){
        return $this->belongsToMany(Grid::class)->select(['id as value', 'description as label']);
    }
    public function tags_select(){
        return $this->belongsToMany(Tag::class)->select(['id as value', 'description as label']);
    }



    public function setLineIdAttribute($value){
        $this->attributes['line_id'] = (int) $value;
    }
    public function setReferenceIdAttribute($value){
        $this->attributes['reference_id'] = (int) $value;
    }
    public function setMaterialIdAttribute($value){
        $this->attributes['material_id'] = (int) $value;
    }
    public function setColorIdAttribute($value){
        $this->attributes['color_id'] = (int) $value;
    }

    public function getGridListAttribute(){
        return $this->grids()->pluck('id');
    }

    public function getTagListAttribute(){
        return $this->tags()->pluck('id');
    }
	public function toSearchableArray()
	{
		$data = $this->toArray();
		$data['line'] = $this->line->toArray();
		$data['color'] = $this->color->toArray();
		$data['material'] = $this->material->toArray();
		$data['brand'] = $this->brand->toArray();
		$data['name'] = $this->line->description.' '.$this->material->description.' '.$this->color->description;

		return $data;
	}

  public function order(){
      return $this->belongsToMany('App\Order')->withPivot('order_id', 'product_id','cost','price', 'grid_id',
          'representative_commission', 'total', 'representative_commission_total', 'representative_commission_company',
          'representative_commission_price', 'company_total_discount', 'total_without_discount', 'products_amount',
          'representative_commission_discount', 'representative_commission_percentage', 'company_discount', 'representative_discount')
          ->withTimestamps();
  }

}
