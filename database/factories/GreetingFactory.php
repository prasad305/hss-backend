<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class GreetingFactory extends Factory
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
            'user_required_day' => 5,
            'instruction' => $this->faker->paragraph(),
            'banner' => 'seeder_media/image/greetings.jpg',
            'star_approve_status' => 1,
            'video' => 'seeder_media/video/greetings.mp4',
            'cost' => $this->faker->numberBetween(400, 500),
            'status' => 2,
        ];
    }
}
