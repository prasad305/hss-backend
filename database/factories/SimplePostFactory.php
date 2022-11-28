<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SimplePostFactory extends Factory
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
            'created_by_id' => 38,
            'admin_id' => 38,
            'star_id' => 20,
            'category_id' => 2,
            'subcategory_id' => 5,
            'image' => 'uploads/images/post/shakib_simple_post_photo.jpg',
            'description' => $this->faker->paragraph(),
            'star_approval' => 1,
            'status' => 1,
        ];
    }
}
