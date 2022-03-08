<?php

namespace Database\Seeders;

use App\Models\AuditionEventRegistration;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class AuditionEventRegSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for ($i = 1; $i < 21; $i++) {
            $AuditionReg = new AuditionEventRegistration();
            $AuditionReg->audition_event_id =  $faker->numberBetween(1, 20);
            $AuditionReg->user_id =  $faker->numberBetween(1, 4);
            $AuditionReg->payment_method =  $faker->text(10);
            $AuditionReg->payment_status =  1;
            $AuditionReg->payment_date =  Carbon::now();
            $AuditionReg->amount =  $faker->numberBetween(500, 1000);
            $AuditionReg->card_holder_name =  $faker->name();
            $AuditionReg->account_no =  $faker->phoneNumber();
            $AuditionReg->image =  $faker->imageUrl($width = 300, $height = 200);
            $AuditionReg->video =  'https://youtu.be/lyXjeJN9lyg';
            $AuditionReg->comment_count =  $faker->numberBetween(5, 10);
            $AuditionReg->save();
        };
    }
}
