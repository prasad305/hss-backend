<?php

namespace Database\Seeders;

use App\Models\MeetupEvent;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Faker\Generator as Faker;

class MeetupEventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for ($i = 1; $i < 21; $i++) {
            $MeetEvent = new MeetupEvent();
            $MeetEvent->created_by_id =  $faker->numberBetween(1, 4);
            $MeetEvent->star_id =  $faker->numberBetween(4, 5);
            $MeetEvent->meetup_type =  'Offline';
            $MeetEvent->title =  $faker->text(10);
            $MeetEvent->end_time =  Carbon::now()->addDays(-2);
            $MeetEvent->start_time =  Carbon::now()->addDays(-10);
            $MeetEvent->description =  $faker->text(50);
            $MeetEvent->venue =  $faker->country();
            $MeetEvent->total_seat =  $faker->numberBetween(200, 500);
            $MeetEvent->banner =  $faker->imageUrl($width = 300, $height = 200);
            $MeetEvent->video =  "https://youtu.be/lyXjeJN9lyg";
            // $MeetEvent->time =  Carbon::now()->setTime(22, 32, 5);
            $MeetEvent->fee =  $faker->numberBetween(400, 500);
            $MeetEvent->status = 1;
            $MeetEvent->save();
        }
    }
}
