<?php

namespace Database\Seeders;

use App\Models\LearningSessionRegistration;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Faker\Generator as Faker;

class LearningSessionRegSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for ($i = 1; $i < 21; $i++) {
            $MeetUpReg = new LearningSessionRegistration();
            $MeetUpReg->learning_session_id =  $faker->numberBetween(1, 20);
            $MeetUpReg->user_id =  $faker->numberBetween(1, 4);
            $MeetUpReg->payment_method =  $faker->text(10);
            $MeetUpReg->payment_status =  1;
            $MeetUpReg->payment_date =  Carbon::now();
            $MeetUpReg->amount =  $faker->numberBetween(500, 1000);
            $MeetUpReg->card_holder_name =  $faker->name();
            $MeetUpReg->account_no =  $faker->phoneNumber();
            $MeetUpReg->save();
        };
    }
}
