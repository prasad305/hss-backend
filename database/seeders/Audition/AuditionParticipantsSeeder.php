<?php

namespace Database\Seeders\Audition;

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Faker\Generator as Faker;
use App\Models\Audition\AuditionParticipant;

class AuditionParticipantsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for ($i = 1; $i < 10; $i++) {
            $auditionParticipant = new AuditionParticipant();
            $auditionParticipant->audition_id =  $faker->numberBetween(1, 10);
            $auditionParticipant->user_id =  $faker->numberBetween(1, 10);
            $auditionParticipant->wining_status = $faker->numberBetween(0, 1);
            $auditionParticipant->save();
        }
    }
}
