<?php

namespace Database\Seeders;

use App\Models\LiveChat;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class LiveChatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $demoDate = Carbon::now();

        for ($i = 1; $i <= 10; $i++) {
            $liveChat = new LiveChat();
            $liveChat->created_by_id = $faker->numberBetween(1, 10);
            $liveChat->category_id = $faker->numberBetween(1, 6);
            $liveChat->star_id =  $faker->numberBetween(5, 7);
            $liveChat->admin_id = 3;
            $liveChat->title = 'Demo live chat title -' . $i;
            $liveChat->description = "It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution";
            $liveChat->event_date = Carbon::now()->addDays(5);
            $liveChat->start_time = Carbon::now()->addDays(5)->addMinutes(10);
            $liveChat->end_time =  Carbon::now()->addDays(5)->addMinutes(40);
            $liveChat->banner = 'demo_image/banner.jpg';
            $liveChat->video = 'https://youtu.be/gvyUuxdRdR4';
            $liveChat->total_seat = 40;
            $liveChat->total_amount = 39;
            $liveChat->fee = $faker->numberBetween(100, 5000);;
            $liveChat->participant_number = 20;
            $liveChat->registration_end_date =  Carbon::now()->addDays(20);
            $liveChat->registration_start_date =  Carbon::now();
            $liveChat->max_time_per_person = 90;
            // $liveChat->publish_status = 10;
            $liveChat->status = true;
            $liveChat->save();
        }
    }
}
