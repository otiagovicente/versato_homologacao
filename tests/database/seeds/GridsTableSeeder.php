<?php

use Illuminate\Database\Seeder;
use App\Size;
use App\Grid;

class GridsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


       	$grids = [
            101 => [
                'description'=>'Tarea A',
                'locale' => 'AR',
                'amounts' => [1,2,3,3,2,1]
            ],
            102=> [
                'description'=>'Tarea B',
                'locale' => 'AR',
                'amounts' => [0,2,3,3,2,2]
             ],
            103=> [
                'description'=>'Tarea D',
                'locale' => 'AR',
                'amounts' => [1,3,3,2,2,1]
            ],
            104=> [
                'description'=>'Tarea H',
                'locale' => 'AR',
                'amounts' => [2,3,3,3,1,0]
             ],

       	];

       	$sizes = Size::all();

       	foreach ($grids as $key => $record) {

			$grid = new Grid;
			$grid->description = $record['description'];
			$grid->code = $key;
            $grid->brand_id = 1;
            $grid->locale = 'AR';
			$grid->save();

            $i = 0;
			foreach ($sizes as $size) {
			    $amount = $record['amounts'][$i];
			    $i++;
                $grid->sizes()->attach($size->id,['amount'=> $amount]);
                if ($i > 5){$i = 0;}
			}
		}
    }
}
