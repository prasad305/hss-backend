<?php

namespace Database\Seeders;

use App\Models\Payment;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Faker\Generator as Faker;


class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for ($i = 0; $i < 10; $i++) {
            $auditionUploadVideo = new Payment();
            $auditionUploadVideo->user_id               =  $faker->numberBetween(1, 10);
            $auditionUploadVideo->event_id              =  $faker->numberBetween(1, 10);
            $auditionUploadVideo->round_id              =  $faker->numberBetween(1, 10);
            $auditionUploadVideo->event_type            =    'audition';
            $auditionUploadVideo->payment_type          =    'cash';
            $auditionUploadVideo->card_holder_name      =  $faker->name;
            $auditionUploadVideo->card_number           =  $faker->numberBetween(20000,1000000);
            $auditionUploadVideo->date                  =   Carbon::now();
            $auditionUploadVideo->status                =  0;
            $auditionUploadVideo->save();
        }
    }
}
