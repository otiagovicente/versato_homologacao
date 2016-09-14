<?php

use Illuminate\Database\Seeder;
use App\Tag;

class TagsTableSeeder extends Seeder
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
                'description' => 'Rasteirinha',
                'brand_id' => 1
            ],
            1 => [
                'description' => 'Scarpin',
                'brand_id' => 1
            ],
            2 => [
                'description' => 'Sapato Aberto',
                'brand_id' => 1
            ],
            3 => [
                'description' => 'Sapato Fechado',
                'brand_id' => 1
            ],
            4 => [
                'description' => 'Ana Bela',
                'brand_id' => 1
            ],
            5 => [
                'description' => 'Plataforma',
                'brand_id' => 1
            ],
            6 => [
                'description' => 'Tênis',
                'brand_id' => 1
            ],
            7 => [
                'description' => 'Sandalha',
                'brand_id' => 1
            ],
            8 => [
                'description' => 'Esportivo',
                'brand_id' => 1
            ],
            9 => [
                'description' => 'Mocassim',
                'brand_id' => 1
            ],
            10 => [
                'description' => 'Meia Pata',
                'brand_id' => 1
            ],
            11 => [
                'description' => 'Dock Side',
                'brand_id' => 1
            ],
            12 => [
                'description' => 'Clog',
                'brand_id' => 1
            ],
            13 => [
                'description' => 'Sneaker',
                'brand_id' => 1
            ],
            14 => [
                'description' => 'Peep Toe',
                'brand_id' => 1
            ],
            15 => [
                'description' => 'Gladiator',
                'brand_id' => 1
            ],
            16 => [
                'description' => 'Oxford',
                'brand_id' => 1
            ],
            17 => [
                'description' => 'Jellies',
                'brand_id' => 1
            ],
            18 => [
                'description' => 'Cone Heel',
                'brand_id' => 1
            ],
            19 => [
                'description' => 'Boot',
                'brand_id' => 1
            ],
        ];

        foreach ($data as $record => $value) {

            $tag = new Tag($value);
            $tag->save();

        }
    }
}
