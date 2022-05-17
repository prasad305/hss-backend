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

        AuditionRoundRule::create( [
            'audition_rules_id'=>'1',
            'judge_mark'=>'40',
            'jury_mark'=>'60',
            'user_vote_mark'=>'0',
            'title'=>'sdfsdaasdf Please Follow the instruction',
            'description'=>'

            Upload good quality of videos
            do not upload sexual video
            video upload max size is 5mb
            ',
            'video_instruction'=>NULL,
            'video_start_time'=>NULL,
            'video_end_time'=>NULL,
            'instruction'=>NULL,
            'num_of_videos'=>'2',
            'uploade_date'=>'2022-05-17 15:57:19',
            'banner'=>'uploads/images/auditions/instructions/1652781545.jpg',
            'video'=>'uploads/videos/auditions/instructions/1652781545613.ami_probashi.mp4',
            'status'=>'2',
            'created_at'=>'2022-05-16 00:05:09',
            'updated_at'=>'2022-05-17 10:05:55'
            ] );


        AuditionRoundRule::create([
            'audition_rules_id' => 1,
            'judge_mark' => NULL,
            'jury_mark' => NULL,
            'user_vote_mark' => NULL,
            'description' => NULL,
            'instruction' => NULL,
            'video_instruction' => NULL,
            'num_of_videos' => NULL,
            'video_start_time' => NULL,
            'video_end_time' => NULL,
            'status' => 0,
            'created_at' => '2022-04-25 04:40:50',
            'updated_at' => '2022-04-25 04:40:50'
        ]);

        AuditionRoundRule::create([
            'audition_rules_id' => 1,
            'judge_mark' => NULL,
            'jury_mark' => NULL,
            'user_vote_mark' => NULL,
            'description' => NULL,
            'instruction' => NULL,
            'video_instruction' => NULL,
            'num_of_videos' => NULL,
            'video_start_time' => NULL,
            'video_end_time' => NULL,
            'status' => 0,
            'created_at' => '2022-04-25 04:40:50',
            'updated_at' => '2022-04-25 04:40:50'
        ]);
    }
}
