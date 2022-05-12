<?php

namespace Database\Seeders\Audition;

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\Models\Audition\AuditionRules;

class AuditionRulesSeeder extends Seeder
{

    public function run(Faker $faker)
    {
        AuditionRules::create([

            'category_id' => 7,
            'round_num' => 4,
            'judge_num' => 3,
            'jury_num' => 3,
            'month' => 5,
            'day' => 3,
            'status' => 1,
        ]);

        AuditionRules::create([

            'category_id' => 1,
            'round_num' => 3,
            'judge_num' => 3,
            'jury_num' => 3,
            'month' => 1,
            'day' => 12,
            'status' => 1,
        ]);

        AuditionRules::create([

            'category_id' => 4,
            'round_num' => 0,
            'judge_num' => 3,
            'jury_num' => 2,
            'month' => 3,
            'day' => 1,
            'status' => 1,
        ]);

        AuditionRules::create([

            'category_id' => 5,
            'round_num' => 0,
            'judge_num' => 3,
            'jury_num' => 2,
            'month' => 8,
            'day' => 7,
            'status' => 1,
        ]);

        AuditionRules::create([

            'category_id' => 6,
            'round_num' => 0,
            'judge_num' => 4,
            'jury_num' => 5,
            'month' => 7,
            'day' => 7,
            'status' => 1,
        ]);

        AuditionRules::create([

            'category_id' => 3,
            'round_num' => 0,
            'judge_num' => 3,
            'jury_num' => 3,
            'month' => 7,
            'day' => 22,
            'status' => 1,
        ]);

        AuditionRules::create([

            'category_id' => 2,
            'round_num' => 0,
            'judge_num' => 2,
            'jury_num' => 2,
            'month' => 2,
            'day' => 2,
            'status' => 1,
        ]);

        AuditionRules::create([
            'category_id' => 8,
            'round_num' => 0,
            'judge_num' => 4,
            'jury_num' => 4,
            'month' => 4,
            'day' => 4,
            'status' => 1,
        ]);
    }
}
