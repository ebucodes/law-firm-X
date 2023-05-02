<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $faker = Faker::create();

        for ($i = 0; $i < 50; $i++) {
            Client::insert([
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'email' => $faker->unique()->safeEmail,
                'date_profiled' => $faker->date,
                'primary_legal_counsel' => $faker->name,
                'date_of_birth' => $faker->date,
                'profile_image' => $faker->imageUrl,
                'case_details' => $faker->paragraph,
            ]);
        }
    }
}
