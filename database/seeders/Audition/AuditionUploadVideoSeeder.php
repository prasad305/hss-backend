<?php

namespace Database\Seeders\Audition;

use App\Models\Audition\AuditionUploadVideo;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Faker\Generator as Faker;

class AuditionUploadVideoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for ($i = 1; $i < 21; $i++) {
            $auditionUploadVideo = new AuditionUploadVideo();
            $auditionUploadVideo->audition_id       =  $faker->numberBetween(1, 10);
            $auditionUploadVideo->user_id           =  $faker->numberBetween(1, 10);
            $auditionUploadVideo->round_id          =  $faker->numberBetween(1, 10);
            $auditionUploadVideo->jury_id           =    $faker->numberBetween(1, 10);
            $auditionUploadVideo->judge_id          =    $faker->numberBetween(1, 10);
            $auditionUploadVideo->video             =  null;
            $auditionUploadVideo->approval_status   =  0;
            $auditionUploadVideo->comments          =   $faker->title;
            $auditionUploadVideo->status            =  0;
            $auditionUploadVideo->save();
        }
    }
}
