<?php

namespace Database\Seeders;

use App\Models\MeetupEvent;
use App\Models\MeetupEventRegistration;
use App\Models\Post;
use App\Models\User;
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
        MeetupEvent::factory(2)->create([
            'category_id' => 2,
            'sub_category_id' => 5,
            'created_by_id' => 20,
            'admin_id' => 20,
            'star_id' => 38,
        ])->each(function ($event) {
            if ($event->id % 2 == 0) {
                MeetupEvent::where('id', $event->id)->update([
                    'meetup_type' => "Online",
                    'event_link' => "asdfghgddddg",

                ]);
            }
            Post::create([

                'type' => 'meetup',
                'user_id' => $event->star_id,
                'star_id' => $event->star_id,
                'event_id' =>  $event->id,
                'category_id' =>  $event->category_id,
                'sub_category_id' =>  $event->sub_category_id,
                'title' =>  $event->title,
                'details' =>  $event->description,

            ]);
            User::factory(5)->create()->each(function ($user) use ($event) {
                MeetupEventRegistration::factory(1)->create([
                    'meetup_event_id' => $event->id,
                    'user_id' => $user->id,
                ]);
            });
        });
    }
}
