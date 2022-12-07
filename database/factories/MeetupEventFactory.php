<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class MeetupEventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' =>  $this->faker->sentence(),
            'slug' =>  $this->faker->slug(),
            'meetup_type' => "Offline",
            'start_time' => Carbon::now()->setTime(22, 32, 5),
            'end_time' => Carbon::now()->setTime(23, 32, 5),
            'description' =>  $this->faker->paragraph(),
            'instruction' =>  $this->faker->paragraph(),
            'total_seat' =>  $this->faker->numberBetween(200, 500),
            'banner' =>  'seeder_media/image/post.png',
            'video' =>  'seeder_media/video/meetup-offline.mp4',
            'event_date' =>  Carbon::now(20),
            'reg_start_date' =>  Carbon::now(5),
            'reg_end_date' =>  Carbon::now(15),
            'venue' =>  $this->faker->city(),
            'fee' =>  $this->faker->numberBetween(400, 500),
            'status' => 2,
        ];
    }
}
