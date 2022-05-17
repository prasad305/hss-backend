<?php

namespace Database\Seeders\Audition;

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\Models\Audition\AuditionRoundRule;

class AuditionRoundRulesSeeder extends Seeder
{
    public function run(Faker $faker)
    {
        // for ($i = 1; $i < 4; $i++) {
        //     $auditionRoundRules = new AuditionRoundRule();
        //     $auditionRoundRules->audition_rules_id =  10;
        //     $auditionRoundRules->judge_mark = 30;
        //     $auditionRoundRules->jury_mark = 40;
        //     $auditionRoundRules->user_vote_mark = 30;
        //     $auditionRoundRules->description = $faker->text();
        //     $auditionRoundRules->title = $faker->title;
        //     $auditionRoundRules->video_instruction = $faker->text();
        //     $auditionRoundRules->num_of_videos = $faker->numberBetween(1, 4);
        //     $auditionRoundRules->uploade_date = $faker->date;
        //     $auditionRoundRules->save();
        // }
        // for ($i = 1; $i < 4; $i++) {
        //     $auditionRoundRules = new AuditionRoundRule();
        //     $auditionRoundRules->audition_rules_id =  1;
        //     $auditionRoundRules->judge_mark = 30;
        //     $auditionRoundRules->jury_mark = 40;
        //     $auditionRoundRules->user_vote_mark = 30;
        //     $auditionRoundRules->description = $faker->text();
        //     $auditionRoundRules->title = $faker->title;
        //     $auditionRoundRules->video_instruction = $faker->text();
        //     $auditionRoundRules->num_of_videos = $faker->numberBetween(1, 4);
        //     $auditionRoundRules->uploade_date = $faker->date;
        //     $auditionRoundRules->save();
        // }

        AuditionRoundRule::create([
            'audition_rules_id' => 1,
            'judge_mark' => 40,
            'jury_mark' => 60,
            'user_vote_mark' => 0,
            'title' => NULL,
            'description' => NULL,
            'video_instruction' => NULL,
            'video_start_time' => NULL,
            'video_end_time' => NULL,
            'instruction' => NULL,
            'num_of_videos' => NULL,
            'uploade_date' => NULL,
            'banner' => 'uploads\\images\\auditions\\9TsP4nyDlXLOpyhPxzK6-1652682816.jpg',
            'video' => NULL,
            'status' => 0,
            'created_at' => '2022-05-16 00:05:09',
            'updated_at' => '2022-05-16 00:06:04'
        ]);
    }
}
