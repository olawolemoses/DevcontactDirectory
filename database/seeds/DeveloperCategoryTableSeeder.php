<?php

use Illuminate\Database\Seeder;

use App\DeveloperCategory;

class DeveloperCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       DeveloperCategory::truncate();

       $faker = \Faker\Factory::create();

       // And now, let's create a few articles in our database:
       for ($i = 0; $i < 35; $i++) {
           DeveloperCategory::create([
               'category_id' => $faker->randomElement(array ('1','2','3','4', '5')),
               'developer_id' => (($i + 1) % 21) > 0 ? ($i + 1) % 21 : 1
           ]);
       }
    }
}
