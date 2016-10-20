<?php

use Illuminate\Database\Seeder;
use App\Customer;
use App\Shop;
use App\Deliverycenter;


class CustomersTableSeeder extends Seeder
{


    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $customerData = [
            'code' => '12345',
            'cuit' => '123456',
            'name' => 'Falabella',
            'company' => 'Falabella Inc.',
            'address' => 'Av. Juan de Garay, 737',
            'city' => 'Buenos Aires',
            'state' => 'Buenos Aires',
            'zip' => 'C1153ABF',
            'geo' => '{"lat":-34.6248187,"lng":-58.3761432}',
            'email' => 'falabella@exemplo.com',
            'phone1' => '+55 51 9916 2573',
            'phone2' => '+55 51 9916 2573',
            'phone3' => '+55 51 9916 2573',
            'logo' => 'https://s3-sa-east-1.amazonaws.com/sistema-versato/customers/ae4bf7c5d28894e534fa4b3ee5c0e084.jpeg',
            'region_id' => 1,
        ];



        $i = 0;
        while($i < 10){
            $customer = new Customer($customerData);
            $customer->save();
            $i++;
        }


        $shopData = [
            'name' => 'Tienda Calle Florida',
            'description' => 'Tienda 2 de Calle Florida',
            'logo' => 'https://s3-sa-east-1.amazonaws.com/sistema-versato/customers/ae4bf7c5d28894e534fa4b3ee5c0e084.jpeg',
            'address' => 'Av. Juan de Garay, 737',
            'geo' => '{"lat":-34.6248187,"lng":-58.3761432}',
            'customer_id' => 1

        ];

        $shop = new Shop($shopData);
        $shop->save();

        $deliverycenterData = [
            'name' => 'Falabella',
            'description' => 'Falabella Centro de Entregas',
            'address' => 'Av. Juan de Garay, 737',
            'city' => 'Buenos Aires',
            'state' => 'Buenos Aires',
            'zip' => 'C1153ABF',
            'geo' => '{"lat":-34.6248187,"lng":-58.3761432}',
            'customer_id' => 1
        ];

        $deliverycenter = new Deliverycenter($deliverycenterData);
        $deliverycenter->save();


    }
}

