<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Faker\Generator as Faker;
use App\Models\LiveChatRegistration;


class LiveChatRegistrationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for ($i = 1; $i < 21; $i++) {
            $liveChatReg = new LiveChatRegistration();
            $liveChatReg->live_chat_id =  $faker->numberBetween(1, 8);
            $liveChatReg->user_id =  $faker->numberBetween(6, 10);
            $liveChatReg->payment_method =  null;
            $liveChatReg->payment_status =  1;
            $liveChatReg->payment_date =  Carbon::now()->addDays(-2);
            $liveChatReg->amount =  $faker->numberBetween(500, 1000);
            $liveChatReg->card_holder_name =  $faker->name();
            $liveChatReg->account_no =  $faker->phoneNumber();
            $liveChatReg->live_chat_start_time = Carbon::now()->addDays(5)->addMinutes(100);
            $liveChatReg->live_chat_end_time =  Carbon::now()->addDays(5)->addMinutes(105);
            $liveChatReg->live_chat_date =  Carbon::now()->addDays(5);
            $liveChatReg->video =  null;
            $liveChatReg->comment_count =  $faker->numberBetween(1, 10);
            $liveChatReg->publish_status =  1;
            $liveChatReg->save();
        };
    }
}
