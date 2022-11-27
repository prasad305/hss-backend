<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class LearningSessionFactory extends Factory
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
            'registration_end_date' =>  Carbon::now()->addDays(20),
            'registration_start_date' =>  Carbon::now(),
            'description' => $this->faker->paragraph(),
            'instruction' => $this->faker->paragraph(),
            'banner' => 'uploads/images/learning_session/Shakib_learning.png',
            'participant_number' => $this->faker->numberBetween(100, 200),
            'video' => 'uploads/videos/learnings/shakib_cricket.mp4',
            'event_date' =>  Carbon::now(),
            'start_time' =>  Carbon::now()->setTime(22, 32, 5),
            'end_time' =>  Carbon::now()->setTime(24, 32, 5),
            'fee' => $this->faker->numberBetween(400, 500),
            'status' => 2,
            'total_amount' => $this->faker->numberBetween(100, 150),
        ];
    }
}
