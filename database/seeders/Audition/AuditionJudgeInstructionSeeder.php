<?php

namespace Database\Seeders\Audition;

use App\Models\Audition\AuditionJudgeInstruction;
use Illuminate\Database\Seeder;
use App\Models\AuditionEvent;
use Carbon\Carbon;
use Faker\Generator as Faker;

class AuditionJudgeInstructionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for ($i = 0; $i < 10; $i++) {
            $auditionJudgeInstruction = new AuditionJudgeInstruction();
            $auditionJudgeInstruction->audition_id =  $faker->numberBetween(1, 10);
            $auditionJudgeInstruction->star_id =  $faker->numberBetween(1, 10);
            $auditionJudgeInstruction->round_id =  $faker->numberBetween(1, 10);
            $auditionJudgeInstruction->title =   $faker->title;
            $auditionJudgeInstruction->banner =  $faker->text(50);
            $auditionJudgeInstruction->video =  null;
            $auditionJudgeInstruction->status =  0;
            $auditionJudgeInstruction->description =  $faker->paragraph;
            $auditionJudgeInstruction->time_boundary =  $faker->date;
            $auditionJudgeInstruction->date =  $faker->date;
            $auditionJudgeInstruction->save();
        }
    }
}
