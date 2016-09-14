<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Product;
use App\Brand;
use App\Grid;
use App\Line;
use App\Reference;
use App\Material;
use App\Color;
use App\Tag;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $products = [
                0 => [
                        'code' => '1234554321',
                        'line_id' => 2,
                        'reference_id' => 3,
                        'material_id' => 4,
                        'color_id' => 1,
                        'cost' => 200.00,
                        'price' => 480.20,
                        'photo' => '/images/products/1472697621.jpg',
                        'grids' => [1,2],
                        'tags'  => [3,4],
                        'published' => true,
                        'launch' => '01/09/2016',
                        'brand_id' => 1
                    ],
                1 => [
                        'code' => '5432112345',
                        'line_id' => 1,
                        'reference_id' => 3,
                        'material_id' => 4,
                        'color_id' => 1,
                        'cost' => 200.00,
                        'price' => 480.20,
                        'photo' => '/images/products/1472429100.jpg',
                        'grids' => [1,3],
                        'tags'  => [1,3],
                        'published' => true,
                        'launch' => '01/09/2016',
                        'brand_id' => 1


                    ],
                2 =>[
                        'code' => '1234567890',
                        'line_id' => 4,
                        'reference_id' => 3,
                        'material_id' => 2,
                        'color_id' => 1,
                        'cost' => 200.00,
                        'price' => 480.20,
                        'photo' => '/images/products/1472449067.jpg',
                        'grids' => [1,4],
                        'tags'  => [2,4],
                        'published' => true,
                        'launch' => '01/09/2016',
                        'brand_id' => 1


                    ],
                3 => [
                        'code' => '5345654324',
                        'line_id' => 3,
                        'reference_id' => 2,
                        'material_id' => 4,
                        'color_id' => 1,
                        'cost' => 200.00,
                        'price' => 480.20,
                        'photo' => '/images/products/1472449338.jpg',
                        'grids' => [1,3],
                        'tags'  => [5,4],
                        'published' => true,
                        'launch' => '01/09/2016',
                        'brand_id' => 1


                    ],
                4 => [
                        'code' => '0987654321',
                        'line_id' => 2,
                        'reference_id' => 3,
                        'material_id' => 2,
                        'color_id' => 1,
                        'cost' => 200.00,
                        'price' => 480.20,
                        'photo' => '/images/products/1472498857.jpg',
                        'grids' => [1,2],
                        'tags'  => [1,3],
                        'published' => true,
                        'launch' => '01/09/2016',
                        'brand_id' => 1


                    ]
                ];





                foreach($products as $product){


                    $model = new Product;

                    $model->code = $product['code'];
                    $model->line_id = $product['line_id'];
                    $model->reference_id = $product['reference_id'];
                    $model->material_id = $product['material_id'];
                    $model->color_id = $product['color_id'];
                    $model->cost = $product['cost'];
                    $model->price = $product['price'];
                    $model->photo = $product['photo'];
                    $model->published = $product['published'];
                    $model->launch = Carbon::now();
                    $model->brand_id = $product['brand_id'];

                    $model->save();

                    $tags = $product['tags'];

                    foreach ($tags as $tag){
                        $model->tags()->attach($tag);
                    }

                    foreach ($product['grids'] as $grid) {
                        $model->grids()->attach($grid);
                    }

                }



    }
}
