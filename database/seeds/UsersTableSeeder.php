<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
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
                'name' => 'Tiago',
                'lastname' => 'Vicente',
                'mobile' => '+55 51 9916 2573',
                'occupation' => 'Marketing',
                'about' => 'Design Estrategico e Planejamento de Marketing',
                'facebook' => 'tiagovicentes',
                'twitter' => '@otiagovicente',
                'instagram' => 'otiagovicente',
                'email' => 'otiagovicente@gmail.com',
                'role' => 1,
                'photo' => '/images/users/tiago.jpg',
                'password' => \Hash::make('tiago683368'),
            ],
            1 => [
                'name' => 'Bruno',
                'lastname' => 'Medeiros',
                'mobile' => '+55 51 9124 9710',
                'occupation' => 'Sistemas',
                'about' => 'Analista de sistemas',
                'facebook' => 'brunomedeiros',
                'twitter' => '@brunosmedeiros',
                'instagram' => 'brunomedeiros',
                'email' => '',
                'role' => 1,
                'photo' => '/images/users/tiago.jpg',
                'password' => \Hash::make('teste123'),
            ],

        ];
        foreach ($data as $item){

            $user = new User;
            $user->create($item);

        }


    }
}
