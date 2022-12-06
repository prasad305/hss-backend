<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class QnAFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(),
            'slug' => $this->faker->slug(),
            'description' => $this->faker->paragraph(),
            'instruction' => $this->faker->paragraph(),
            'event_date' => Carbon::now()->addDay(5),
            'start_time' => Carbon::now()->setTime(20, 32, 5),
            'available_start_time' => Carbon::now()->setTime(20, 32, 5),
            'end_time' =>  Carbon::now()->setTime(23, 32, 5),
            'banner' => 'seeder_media/image/qna.png',
            'video' => 'seeder_media/video/qna.mp4',
            'fee' => $this->faker->numberBetween(100, 5000),
            'registration_start_date' =>  Carbon::now(),
            'registration_end_date' =>  Carbon::now()->addDays(20),
            'max_time' => 15,
            'min_time' => 3,
            'time_interval' => 2,
            'star_approval' => 1,
            'status' => 2,
        ];
    }
}
