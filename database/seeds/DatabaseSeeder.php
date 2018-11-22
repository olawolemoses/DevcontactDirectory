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
        // $this->call('UsersTableSeeder');
        $this->call(DeveloperContactTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);
        $this->call(DeveloperCategoryTableSeeder::class);
    }
}
