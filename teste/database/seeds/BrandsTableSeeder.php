<?php

use Illuminate\Database\Seeder;
use App\Brand;

class BrandsTableSeeder extends Seeder
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
                'name' => 'Massimo Chiesa',
                'description' => 'Marca Argentina',
                'image' => '/images/brands/Massimo Chiesa1471237857.jpg'
            ],
              1 => [
                'name' => 'Massas da Vó Lú',
                'description' => 'Marca Brasileira de Massas',
                'image' => '/images/brands/massasvolu.png'
            ],
              2 => [
                'name' => 'Mambo',
                'description' => 'Agência brasileira de Comportamento e Conceito',
                'image' => '/images/brands/mambo.png'
            ]

        ];

        foreach ($data as $item){
            $brand = new Brand;
            $brand->create($item);
        }

    }
}
