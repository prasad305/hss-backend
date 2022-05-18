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
        // for ($i = 0; $i < 10; $i++) {
        //     $auditionUploadVideo = new AuditionUploadVideo();
        //     $auditionUploadVideo->audition_id                   =  $faker->numberBetween(1, 10);
        //     $auditionUploadVideo->user_id                       =  $faker->numberBetween(1, 10);
        //     $auditionUploadVideo->round_id                      =  $faker->numberBetween(1, 10);
        //     $auditionUploadVideo->jury_id                       =  $faker->numberBetween(1, 10);
        //     $auditionUploadVideo->judge_id                      =  $faker->numberBetween(1, 10);
        //     $auditionUploadVideo->video                         =  null;
        //     $auditionUploadVideo->approval_status               =  0;
        //     $auditionUploadVideo->audition_admin_comment        =  $faker->title;
        //     $auditionUploadVideo->approval_status               =  0;
        //     $auditionUploadVideo->save();
        // }


        AuditionUploadVideo::create([
            'audition_id' => '10',
            'user_id' => '6',
            'round_id' => '3',
            'jury_id' => '9',
            'judge_id' => '5',
            'audition_admin_id' => NULL,
            'video' => NULL,
            'approval_status' => '0',
            'judge_approval_status' => '0',
            'audition_admin_comment' => 'Mr.',
            'judge_comment' => NULL,
            'jury_comment' => NULL,
            'created_at' => '2022-05-17 09:48:11',
            'updated_at' => '2022-05-17 09:48:11'
        ]);



        AuditionUploadVideo::create([
            'audition_id' => '10',
            'user_id' => '53',
            'round_id' => '1',
            'jury_id' => NULL,
            'judge_id' => NULL,
            'audition_admin_id' => NULL,
            'video' => 'uploads/videos/auditions/165278180624360.Nature Beautiful short video 720p HD.mp4',
            'approval_status' => '0',
            'judge_approval_status' => '0',
            'audition_admin_comment' => NULL,
            'judge_comment' => NULL,
            'jury_comment' => NULL,
            'created_at' => '2022-05-17 10:03:26',
            'updated_at' => '2022-05-17 10:03:26'
        ]);


        AuditionUploadVideo::create([
            'audition_id' => '10',
            'user_id' => '53',
            'round_id' => '1',
            'jury_id' => NULL,
            'judge_id' => NULL,
            'audition_admin_id' => NULL,
            'video' => 'uploads/videos/auditions/165278180658481.ami_probashi.mp4',
            'approval_status' => '0',
            'judge_approval_status' => '0',
            'audition_admin_comment' => NULL,
            'judge_comment' => NULL,
            'jury_comment' => NULL,
            'created_at' => '2022-05-17 10:03:26',
            'updated_at' => '2022-05-17 10:03:26'
        ]);



        AuditionUploadVideo::create([
            'audition_id' => '10',
            'user_id' => '10',
            'round_id' => '1',
            'jury_id' => NULL,
            'judge_id' => NULL,
            'audition_admin_id' => NULL,
            'video' => 'uploads/videos/auditions/165278303645250.Nature Beautiful short video 720p HD.mp4',
            'approval_status' => '0',
            'judge_approval_status' => '0',
            'audition_admin_comment' => NULL,
            'judge_comment' => NULL,
            'jury_comment' => NULL,
            'created_at' => '2022-05-17 10:23:56',
            'updated_at' => '2022-05-17 10:23:56'
        ]);




        AuditionUploadVideo::create([
            'audition_id' => '10',
            'user_id' => '10',
            'round_id' => '1',
            'jury_id' => NULL,
            'judge_id' => NULL,
            'audition_admin_id' => NULL,
            'video' => 'uploads/videos/auditions/165278303646291.ami_probashi.mp4',
            'approval_status' => '0',
            'judge_approval_status' => '0',
            'audition_admin_comment' => NULL,
            'judge_comment' => NULL,
            'jury_comment' => NULL,
            'created_at' => '2022-05-17 10:23:56',
            'updated_at' => '2022-05-17 10:23:56'
        ]);


        AuditionUploadVideo::create([
            'audition_id' => '10',
            'user_id' => '52',
            'round_id' => '1',
            'jury_id' => NULL,
            'judge_id' => NULL,
            'audition_admin_id' => NULL,
            'video' => 'uploads/videos/auditions/165278312727250.audition.mp4',
            'approval_status' => '0',
            'judge_approval_status' => '0',
            'audition_admin_comment' => NULL,
            'judge_comment' => NULL,
            'jury_comment' => NULL,
            'created_at' => '2022-05-17 10:25:27',
            'updated_at' => '2022-05-17 10:25:27'
        ]);



        AuditionUploadVideo::create([
            'audition_id' => '10',
            'user_id' => '52',
            'round_id' => '1',
            'jury_id' => NULL,
            'judge_id' => NULL,
            'audition_admin_id' => NULL,
            'video' => 'uploads/videos/auditions/165278312796731.ami_probashi.mp4',
            'approval_status' => '0',
            'judge_approval_status' => '0',
            'audition_admin_comment' => NULL,
            'judge_comment' => NULL,
            'jury_comment' => NULL,
            'created_at' => '2022-05-17 10:25:27',
            'updated_at' => '2022-05-17 10:25:27'
        ]);
    }
}
