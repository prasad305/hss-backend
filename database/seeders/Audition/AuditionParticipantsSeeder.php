<?php

namespace Database\Seeders\Audition;

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Faker\Generator as Faker;
use App\Models\Audition\AuditionParticipant;

class AuditionParticipantsSeeder extends Seeder
{
    public function run(Faker $faker)
    {
        // for ($i = 1; $i < 10; $i++) {
        //     $auditionParticipant = new AuditionParticipant();
        //     $auditionParticipant->audition_id =  $faker->numberBetween(1, 10);
        //     $auditionParticipant->user_id =  $faker->numberBetween(1, 10);
        //     $auditionParticipant->wining_status = $faker->numberBetween(0, 1);
        //     $auditionParticipant->save();
        // }

        Auditionparticipant::create([
            'audition_round_rules_id' => 1,
            'user_id' => 10,
            'audition_id' => 10,
            'wining_status' => 1,
            'certificates' => NULL,
            'status' => 0,
            'created_at' => '2022-05-16 11:20:53',
            'updated_at' => '2022-05-17 05:03:10'
        ]);

        Auditionparticipant::create([
            'audition_round_rules_id' => 1,
            'user_id' => 12,
            'audition_id' => 10,
            'wining_status' => NULL,
            'certificates' => NULL,
            'status' => 0,
            'created_at' => '2022-05-17 04:53:21',
            'updated_at' => '2022-05-17 05:03:10'
        ]);
    }
}
