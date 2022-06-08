<?php

namespace Database\Seeders;

use App\Models\GreetingType;
use Illuminate\Database\Seeder;

class GreetingTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $greetingType = new GreetingType();
        $greetingType->status = 1;
        $greetingType->greeting_type = 'Anniversary Greeting';
        $greetingType->save();

        $greetingType = new GreetingType();
        $greetingType->status = 1;
        $greetingType->greeting_type = 'Birthday Greeting';
        $greetingType->save();

        $greetingType = new GreetingType();
        $greetingType->status = 1;
        $greetingType->greeting_type = 'Surprise Greeting';
        $greetingType->save();

        $greetingType = new GreetingType();
        $greetingType->status = 1;
        $greetingType->greeting_type = 'Seasonal Greeting';
        $greetingType->save();

        $greetingType = new GreetingType();
        $greetingType->status = 1;
        $greetingType->greeting_type = 'Congratulations Greeting';
        $greetingType->save();

        $greetingType = new GreetingType();
        $greetingType->status = 1;
        $greetingType->greeting_type = 'Encouragement Greeting';
        $greetingType->save();

        $greetingType = new GreetingType();
        $greetingType->status = 1;
        $greetingType->greeting_type = 'Special Occasion Greeting';
        $greetingType->save();

        $greetingType = new GreetingType();
        $greetingType->status = 1;
        $greetingType->greeting_type = 'Others';
        $greetingType->save();
    }
}
