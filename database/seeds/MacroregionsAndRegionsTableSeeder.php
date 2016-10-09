<?php

use Illuminate\Database\Seeder;

use App\Macroregion;
use App\Region;

class MacroregionsAndRegionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        $MacroregionData = [
            'code' => '12345',
            'description' => 'Gran Buenos Aires',
            'brand_id' => 1,
            'geo' => '{lat: -34.6248187, lng: -58.3761432}'
        ];

        $Macroregion = new Macroregion($MacroregionData);
        $Macroregion->save();

        $RegionData = [
            'code' => '12345',
            'description' => 'Capital Federal',
            'brand_id' => 1,
            'macroregion_id' => 1,
            'geo' => '{lat: -34.6248187, lng: -58.3761432}'
        ];
        $Region = new Region($RegionData);
        $Region->save();





    }

}
