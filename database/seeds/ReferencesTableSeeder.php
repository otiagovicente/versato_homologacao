<?php

use Illuminate\Database\Seeder;
use App\Reference;
use App\Brand;


class ReferencesTableSeeder extends Seeder
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


            $reference = new Reference;
            $reference->description = 'Referencia '.$key;
            $reference->code = $key;
            $reference->brand_id = Brand::first()->id;
            $reference->save();

        }

    }
}
