<?php

use Illuminate\Database\Seeder;
use App\Line;
use App\Brand;

class LinesTableSeeder extends Seeder
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


            $line = new Line;
            $line->description = 'Linha '.$key;
            $line->code = $key;
            $line->brand_id = Brand::first()->id;
            $line->save();

        }


    }
}
