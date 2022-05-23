<?php

namespace Database\Seeders;

use App\Models\AuditionEvent;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Faker\Generator as Faker;

class AuditionEventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for ($i = 1; $i < 21; $i++) {
            $MeetEvent = new AuditionEvent();
            $MeetEvent->created_by_id =  $faker->numberBetween(4, 5);
            $MeetEvent->star_id =  $faker->numberBetween(4, 5);
            $MeetEvent->title =  $faker->text(10);
            $MeetEvent->registration_end_date =  Carbon::now()->addDays(20);
            $MeetEvent->registration_start_date =  Carbon::now();
            $MeetEvent->description =  $faker->text(50);
            $MeetEvent->venue =  $faker->country();
            $MeetEvent->total_seat =  $faker->numberBetween(200, 500);
            $MeetEvent->banner =  $faker->imageUrl($width = 300, $height = 200);;
            $MeetEvent->participant_number =  $faker->numberBetween(100, 200);
            $MeetEvent->video =  "https://youtu.be/lyXjeJN9lyg";
            $MeetEvent->date =  Carbon::now();
            $MeetEvent->time =  Carbon::now()->setTime(22, 32, 5);
            $MeetEvent->fee =  $faker->numberBetween(400, 500);
            $MeetEvent->status = 1;
            $MeetEvent->total_amount = $faker->numberBetween(100, 150);
            $MeetEvent->save();
        }
    }
}
