<?php

use Illuminate\Database\Seeder;
use App\Material;
use App\Brand;

class MaterialsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        $data = [100, 101,102,103,104,105];

        foreach ($data as $key) {


            $material = new Material;
            $material->description = 'Material '.$key;
            $material->code = $key;
            $material->sample = '/images/materials/1470155288.jpg';
            $material->brand_id = Brand::first()->id;
            $material->save();

        }

    }

}
