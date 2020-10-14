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
        
        foreach (range(1, 20) as $index) {
            DB::table('suppliers')->insert([
                'code' => $faker->word,
                'name' => $faker->word,
            ]);
        }
        
        // foreach (range(1, 20) as $index) {
        //     DB::table('purchases')->insert([
        //         'purchase_code' => 'PC'.$faker->randomNumber($nbDigits = NULL, $strict = false),
        //         'date' => $faker->dateTimeBetween($startDate = '-1 years', $endDate = 'now'),
        //         'marking' => $faker->word,
        //         'item_id' => $index,
        //         'quantity' => 100,
        //         'ctns' => 100,
        //         'volume' => 1,
        //         'pl' => $faker->word,
        //         'resi' => $faker->word,
        //         'expected_date' => $faker->dateTimeBetween($startDate = '-1 years', $endDate = 'now'),
        //         'status' => 1,
        //         'remarks' => $faker->text($maxNbChars = 200)
        //     ]);
        // }
    }
}