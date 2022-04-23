<?php

namespace Database\Seeders\Audition;

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\Models\Audition\AuditionRoundRule;

class AuditionRoundRulesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for ($i = 1; $i < 10; $i++) {
            $auditionRoundRules = new AuditionRoundRule();
            $auditionRoundRules->audition_rules_id =  $faker->numberBetween(1, 8);
            $auditionRoundRules->judge_mark = 30;
            $auditionRoundRules->jury_mark = 40;
            $auditionRoundRules->user_vote_mark = 30;
            $auditionRoundRules->description = $faker->text();
            $auditionRoundRules->instruction = $faker->title;
            $auditionRoundRules->video_instruction = $faker->text();
            $auditionRoundRules->num_of_videos = $faker->numberBetween(1, 4);
            $auditionRoundRules->video_start_time = $faker->date;
            $auditionRoundRules->video_end_time = $faker->date;
            $auditionRoundRules->save();
        }
    }
}
