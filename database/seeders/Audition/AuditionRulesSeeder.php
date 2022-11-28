<?php

namespace Database\Seeders\Audition;

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\Models\Audition\AuditionRules;

class AuditionRulesSeeder extends Seeder
{

    public function run(Faker $faker)
    {
        // AuditionRules::create([
        //     'category_id' => 1,
        //     'round_num' => 0,
        //     'judge_num' => 3,
        //     'jury_num' => 3,
        //     'month' => 1,
        //     'day' => 12,
        //     'status' => 1,
        // ]);

    }
}
