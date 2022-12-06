<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class MeetupEventRegistrationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'payment_method' =>  "paytm",
            'payment_status' =>  1,
            'payment_date' =>  Carbon::now(),
            'amount' =>  $this->faker->numberBetween(500, 1000),
        ];
    }
}
