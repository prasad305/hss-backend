<?php

namespace Database\Seeders;

use App\Models\AuditionReact;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class AuditionReactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for ($i = 1; $i < 21; $i++) {
            $AuditionReact = new AuditionReact();
            $AuditionReact->audition_event_id =  $i;
            $AuditionReact->user_id = $faker->numberBetween(1, 4);
            $AuditionReact->react = $faker->numberBetween(0, 2);
            $AuditionReact->save();
        };
    }
}
