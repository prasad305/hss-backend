<?php

namespace Database\Seeders;

use App\Models\Audition\Audition;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

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
            $audition->creater_id =  2;
            $audition->admin_id =  20;
            $audition->title =  $faker->text(10);
            $audition->slug =  str_replace('_', ' ', $faker->text(10));
            $audition->description = $faker->text(100);
            $audition->start_time = Carbon::now();
            $audition->end_time = Carbon::now();
            $audition->round_status =  $faker->numberBetween(1, 3);
            $audition->template_id = $faker->numberBetween(1, 3);
            $audition->save();
        };
    }
}
