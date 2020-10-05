<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        $faker = Faker::create();

        foreach (range(1, 50) as $index) {
            DB::table('orders')->insert([
                'purchase_code' => 'PC'.$faker->randomNumber($nbDigits = NULL, $strict = false),
                'date' => $faker->dateTimeBetween($startDate = '-1 years', $endDate = 'now'),
                'marking' => 1,
                'items' => 1,
                'qty' => 100,
                'ctns' => 100,
                'volume' => 1,
                'pl' => $faker->word,
                'resi' => $faker->word,
                'expected_date' => $faker->dateTimeBetween($startDate = '-1 years', $endDate = 'now'),
                'status' => 4,
                'invoice' => $faker->word,
                'remarks' => $faker->text($maxNbChars = 200)
            ]);
        }

        foreach (range(1, 20) as $index) {
            DB::table('markings')->insert([
                'name' => $faker->word,
            ]);
        }

        foreach (range(1, 20) as $index) {
            DB::table('items')->insert([
                'name' => $faker->word,
            ]);
        }
    }
}