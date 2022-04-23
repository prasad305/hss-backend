<?php

namespace Database\Seeders\Audition;

use App\Models\Audition\AuditionJudgeMark;
use App\Models\Audition\AuditionUploadVideo;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Faker\Generator as Faker;


class AuditionJudgeMarkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for ($i = 0; $i < 10; $i++) {
            $auditionJudgeMark = new AuditionJudgeMark();
            $auditionJudgeMark->judge_id =  $faker->numberBetween(1, 10);
            $auditionJudgeMark->participant_id =  $faker->numberBetween(1, 10);
            $auditionJudgeMark->marks =  $faker->numberBetween(1, 5);
            $auditionJudgeMark->comments =   $faker->title;
            $auditionJudgeMark->status =  0;
            $auditionJudgeMark->save();
        }
    }
}
