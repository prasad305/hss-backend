<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\TermAndCondition;

class TermAndConditionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = TermAndCondition::class;
    
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(),
            'details' => $this->faker->text(150),
            'status' => 1,
        ];
    }
}
