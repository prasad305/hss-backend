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
            // $audition->audition_rules_id =  $faker->numberBetween(1, 8);
            $audition->audition_round_rules_id =  $faker->numberBetween(1, 10);
            $audition->creater_id =  2;
            $audition->audition_admin_id =  $faker->numberBetween(12, 21);
            $audition->title =  $faker->text(10);
            $audition->slug =  str_replace('_', ' ', $faker->text(10));
            $audition->description = $faker->text(100);
            $audition->start_time = Carbon::now();
            $audition->end_time = Carbon::now();
            $audition->save();
        };

        $audition = new Audition();
        $audition->category_id = 1;
        // $audition->audition_rules_id =  1;
        $audition->audition_round_rules_id = 1;
        $audition->creater_id =  2;
        $audition->audition_admin_id =  12;
        $audition->status  =  3;
        $audition->title = "Monir Talent Hunt 2022";
        $audition->round_status = 0;
        $audition->slug = "monir-talent-hunt-2022";
        $audition->video = "uploads/videos/auditions/16526815938462.10-sec.mp4";
        $audition->banner = "uploads/images/auditions/1652681593.jpg";
        $audition->description = "<p>Monir Talent Hunt 2022 . description</p>";
        $audition->start_time = Carbon::parse("2022-05-20 00:00:00");
        $audition->end_time = Carbon::parse("2022-07-01 00:00:00");
        $audition->save();
    }
}
