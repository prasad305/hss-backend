<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PackageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {    
        return [
            'title' => $this->faker->sentence(3),
            'club_points' => $this->faker->numberBetween(200, 300),
            'love_points' => $this->faker->numberBetween(400, 500),
            'auditions' => $this->faker->numberBetween(10, 20),
            'learning_session' => $this->faker->numberBetween(10, 20),
            'live_chats' => $this->faker->numberBetween(10, 20),
            'meetup' => $this->faker->numberBetween(10, 20),
            'greetings' => $this->faker->numberBetween(10, 20),
            'qna' => $this->faker->numberBetween(10, 20),
            'color_code' => $this->faker->hexcolor(),
            'price' => $this->faker->numberBetween(100, 500),
            'status' => 1,
        ];
    }
}
