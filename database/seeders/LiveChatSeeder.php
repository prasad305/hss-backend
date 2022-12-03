<?php

namespace Database\Seeders;

use App\Models\LiveChat;
use App\Models\LiveChatRegistration;
use App\Models\Post;
use App\Models\User;
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
        LiveChat::factory(2)->create([
            'category_id' => 2,
            'sub_category_id' => 5,
            'created_by_id' => 20,
            'admin_id' => 20,
            'star_id' => 38,
        ])->each(function ($event) {

            Post::create([
                'type' => 'liveChat',
                'user_id' => $event->star_id,
                'star_id' => $event->star_id,
                'event_id' =>  $event->id,
                'category_id' =>  $event->category_id,
                'sub_category_id' =>  $event->sub_category_id,
                'title' =>  $event->title,
                'details' =>  $event->description,

            ]);
            User::factory(5)->create()->each(function ($user) use ($event) {

                $liveChat = LiveChat::find($event->id);

                LiveChatRegistration::factory(1)->create([
                    'live_chat_id' => $event->id,
                    'user_id' => $user->id,
                    'live_chat_start_time' => (Carbon::parse($liveChat->available_start_time)->format('H:i:s')),
                    'live_chat_end_time' => (Carbon::parse($liveChat->available_start_time)->addMinutes(7)->format('H:i:s')),
                    'live_chat_date' => $event->event_date,
                ])->each(function ($registerInfo) use ($event) {
                    LiveChat::where('id', $event->id)->update([
                        'available_start_time' => (Carbon::parse($registerInfo->live_chat_end_time)->addMinutes($event->interval)->format('H:i:s')),
                    ]);
                    createSeederActivity("liveChat", $registerInfo->id, $registerInfo->user_id, $registerInfo->live_chat_id);
                });
            });
        });
    }
}
