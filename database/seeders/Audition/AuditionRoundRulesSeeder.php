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
        for ($i = 1; $i < 4; $i++) {
            $auditionRoundRules = new AuditionRoundRule();
            $auditionRoundRules->audition_rules_id =  10;
            $auditionRoundRules->judge_mark = 30;
            $auditionRoundRules->jury_mark = 40;
            $auditionRoundRules->user_vote_mark = 30;
            $auditionRoundRules->description = $faker->text();
            $auditionRoundRules->title = $faker->title;
            $auditionRoundRules->video_instruction = $faker->text();
            $auditionRoundRules->num_of_videos = $faker->numberBetween(1, 4);
            $auditionRoundRules->uploade_date = $faker->date;
            $auditionRoundRules->save();
        }
        for ($i = 1; $i < 4; $i++) {
            $auditionRoundRules = new AuditionRoundRule();
            $auditionRoundRules->audition_rules_id =  1;
            $auditionRoundRules->judge_mark = 30;
            $auditionRoundRules->jury_mark = 40;
            $auditionRoundRules->user_vote_mark = 30;
            $auditionRoundRules->description = $faker->text();
            $auditionRoundRules->title = $faker->title;
            $auditionRoundRules->video_instruction = $faker->text();
            $auditionRoundRules->num_of_videos = $faker->numberBetween(1, 4);
            $auditionRoundRules->uploade_date = $faker->date;
            $auditionRoundRules->save();
        }
    }
}
