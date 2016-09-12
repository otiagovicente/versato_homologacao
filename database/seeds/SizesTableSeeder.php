<?php

use Illuminate\Database\Seeder;
use Versato\Size;

class SizesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sizes = [35,36,37,38,39,40];

		foreach ($sizes as $number) {

            //echo $size;
			$size = new Size;
			$size->size = $number;
			$size->brand_id = 1;
			$size->locale = 'AR';
			$size->save();
		}

    }
}
