<?php

namespace Database\Seeders\Audition;

use App\Models\Audition\AuditionUserVoting;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Faker\Generator as Faker;

class AuditionUserVotingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for ($i = 1; $i < 21; $i++) {
            $auditionUserVoting = new AuditionUserVoting();
            $auditionUserVoting->video_id           =  $faker->numberBetween(1, 10);
            $auditionUserVoting->audition_id          =  $faker->numberBetween(1, 10);
            $auditionUserVoting->user_id           =    $faker->numberBetween(1, 10);
            $auditionUserVoting->round_id          =    $faker->numberBetween(1, 10);
            $auditionUserVoting->comments          =   $faker->title;
            $auditionUserVoting->status            =  0;
            $auditionUserVoting->save();
        }
    }
}
