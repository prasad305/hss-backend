<?php

namespace Database\Seeders\Audition;

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\Models\Audition\AuditionRules;

class AuditionRulesSeeder extends Seeder
{

    public function run(Faker $faker)
    {
        for ($i = 1; $i < 8; $i++) {
            $auditionRules = new AuditionRules();
            $auditionRules->category_id =  $faker->numberBetween(1, 8);
            $auditionRules->round_num = $faker->numberBetween(1, 3);
            $auditionRules->judge_num = $faker->numberBetween(1, 3);
            $auditionRules->jury_num = $faker->numberBetween(1, 3);
            $auditionRules->month = $faker->numberBetween(1, 12);
            $auditionRules->day = $faker->numberBetween(1, 31);
            $auditionRules->save();
        }
    }
}
