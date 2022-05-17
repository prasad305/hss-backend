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
        // for ($i = 0; $i < 10; $i++) {
        //     $auditionJudgeInstruction = new AuditionJudgeInstruction();
        //     $auditionJudgeInstruction->audition_id =  $faker->numberBetween(1, 10);
        //     $auditionJudgeInstruction->star_id =  $faker->numberBetween(1, 10);
        //     $auditionJudgeInstruction->round_id =  $faker->numberBetween(1, 10);
        //     $auditionJudgeInstruction->title =   $faker->title;
        //     $auditionJudgeInstruction->banner =  $faker->text(50);
        //     $auditionJudgeInstruction->video =  null;
        //     $auditionJudgeInstruction->status =  0;
        //     $auditionJudgeInstruction->description =  $faker->paragraph;
        //     $auditionJudgeInstruction->time_boundary =  $faker->date;
        //     $auditionJudgeInstruction->date =  $faker->date;
        //     $auditionJudgeInstruction->save();
        // }



        AuditionJudgeInstruction::create([
            'audition_id' => 10,
            'star_id' => 44,
            'round_id' => 1,
            'title' => 'fvb kb dfbgdb dbhfdb',
            'banner' => 'uploads/images/auditions/9TsP4nyDlXLOpyhPxzK6-1652682816.jpg',
            'video' => 'uploads/videos/auditions/qgJF2QPBlj5W2VBuCVd5-1652682816.png',
            'status' => 0,
            'description' => 'asdfhbsd sdgbdxbgdkbg',
            'time_boundary' => '2022-05-20 06:32:51',
            'date' => NULL,
            'created_at' => '2022-05-16 00:33:36',
            'updated_at' => '2022-05-16 00:33:36'
        ]);


        AuditionJudgeInstruction::create([
            'audition_id' => 10,
            'star_id' => 43,
            'round_id' => 1,
            'title' => 'fvb kb dfbgdb dbhfdb',
            'banner' => 'uploads/images/auditions/9TsP4nyDlXLOpyhPxzK6-1652682816.jpg',
            'video' => 'uploads/videos/auditions/qgJF2QPBlj5W2VBuCVd5-1652682816.png',
            'status' => 0,
            'description' => 'asdfhbsd sdgbdxbgdkbg',
            'time_boundary' => '2022-05-20 06:32:51',
            'date' => NULL,
            'created_at' => '2022-05-16 00:33:36',
            'updated_at' => '2022-05-16 00:33:36'
        ]);


        AuditionJudgeInstruction::create([
            'audition_id' => 10,
            'star_id' => 42,
            'round_id' => 1,
            'title' => 'fvb kb dfbgdb dbhfdb',
            'banner' => 'uploads/images/auditions/9TsP4nyDlXLOpyhPxzK6-1652682816.jpg',
            'video' => 'uploads/videos/auditions/qgJF2QPBlj5W2VBuCVd5-1652682816.png',
            'status' => 0,
            'description' => 'asdfhbsd sdgbdxbgdkbg',
            'time_boundary' => '2022-05-20 06:32:51',
            'date' => NULL,
            'created_at' => '2022-05-16 00:33:36',
            'updated_at' => '2022-05-16 00:33:36'
        ]);
    }
}
