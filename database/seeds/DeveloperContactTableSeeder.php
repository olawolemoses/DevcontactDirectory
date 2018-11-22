<?php

use Illuminate\Database\Seeder;

use App\DeveloperContact;

class DeveloperContactTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       DeveloperContact::truncate();

       $faker = \Faker\Factory::create();

       // And now, let's create a few articles in our database:
       for ($i = 0; $i < 20; $i++) {
           $firstname = $faker->firstName;
           $lastname = $faker->lastName;
           DeveloperContact::create([
               'firstname' => $firstname,
               'lastname' => $faker->lastName,
               'email' => $faker->email,
               'phoneno' => $faker->phoneNumber,
               'skypeid' => $faker->domainWord . '.' . $firstname,
               'linkedin' => 'http://www.linkedin.com/' . '/' . $firstname . '-' . $lastname,
               'country' => $faker->randomElement(array ('Ghana','Nigeria')),
           ]);
       }
    }
}
