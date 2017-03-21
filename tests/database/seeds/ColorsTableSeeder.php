<?php

use Illuminate\Database\Seeder;
use App\Color;
use App\Brand;

class ColorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [

            0 => [
                'code' => 12345,
                'description' => 'Camel',
                'color' => '#e6be3c',
                'brand_id' => Brand::first()->id,
            ],
            1 => [
                'code' => 43215,
                'description' => 'Marsala',
                'color' => '#cc1010',
                'brand_id' => Brand::first()->id,
            ],
            2 => [
                'code' => 54326,
                'description' => 'Azul Cobalto',
                'color' => '#0909e0',
                'brand_id' => Brand::first()->id,
            ],
            3 => [
                'code' => 94304,
                'description' => 'Verde Água',
                'color' => '#55e0b4',
                'brand_id' => Brand::first()->id,
            ],

        ];

        foreach ($data as $item){
            $color = new Color;
            $color->create($item);
        }

    }
}

