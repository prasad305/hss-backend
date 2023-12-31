<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class FAQFactory extends Factory
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
            'details' => $this->faker->text(150),
            'status' => 1,
        ];
    }
}
