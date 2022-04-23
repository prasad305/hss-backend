<?php

namespace Database\Seeders\Audition;

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\Models\Audition\Audition;
use Carbon\Carbon;

class AuditionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for ($i = 1; $i < 10; $i++) {
            $audition = new Audition();
            $audition->category_id =  $faker->numberBetween(1, 8);
            $audition->audition_rules_id =  $faker->numberBetween(1, 8);
            $audition->audition_round_rules_id =  $faker->numberBetween(1, 10);
            $audition->creater_id =  2;
            $audition->audition_admin_id =  20;
            $audition->title =  $faker->text(10);
            $audition->slug =  str_replace('_', ' ', $faker->text(10));
            $audition->description = $faker->text(100);
            $audition->start_time = Carbon::now();
            $audition->end_time = Carbon::now();
            $audition->save();
        };
    }
}
