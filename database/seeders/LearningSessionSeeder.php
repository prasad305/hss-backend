<?php

namespace Database\Seeders;

use App\Models\LearningSession;
use App\Models\LearningSessionRegistration;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Faker\Generator as Faker;

class LearningSessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        LearningSession::factory(2)->create([
            'category_id' => 2,
            'sub_category_id' => 5,
            'created_by_id' => 20,
            'admin_id' => 20,
            'star_id' => 38,
        ])->each(function ($event) use ($faker) {
            if ($event->id % 2 == 0) {
                LearningSession::where('id', $event->id)->update([
                    'assignment' => 1,
                    'assignment_fee' => 700,
                    'assignment_instruction' => $faker->paragraph(),
                    'assignment_video_slot_number' => 1,
                    'assignment_reg_start_date' => Carbon::now()->addDay(10),
                    'assignment_reg_end_date' => Carbon::now()->addDay(30),
                ]);
            }
            Post::create([

                'type' => 'learningSession',
                'user_id' => $event->star_id,
                'star_id' => $event->star_id,
                'event_id' =>  $event->id,
                'category_id' =>  $event->category_id,
                'sub_category_id' =>  $event->sub_category_id,
                'title' =>  $event->title,
                'details' =>  $event->description,

            ]);
            User::factory(5)->create()->each(function ($user) use ($event) {
                LearningSessionRegistration::factory(1)->create([
                    'learning_session_id' => $event->id,
                    'user_id' => $user->id,
                ]);
            });
        });
    }
}
