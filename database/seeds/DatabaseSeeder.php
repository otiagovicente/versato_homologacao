<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $this->call(BrandsTableSeeder::class);
         $this->call(SizesTableSeeder::class);
         $this->call(GridsTableSeeder::class);
         $this->call(LinesTableSeeder::class);
         $this->call(ReferencesTableSeeder::class);
         $this->call(MaterialsTableSeeder::class);
         $this->call(ColorsTableSeeder::class);
         $this->call(UsersTableSeeder::class);
         $this->call(TagsTableSeeder::class);
         $this->call(ProductsTableSeeder::class);
    }
}
