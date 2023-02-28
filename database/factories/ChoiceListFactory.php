<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ChoiceListFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => rand(65,75),
            'category' => rand(1,6),
            'star_id' => "[38,39,40,41]",
            'unfollowed_star_id' => "[]",
        ];
    }
}
