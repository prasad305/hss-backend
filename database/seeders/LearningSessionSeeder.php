<?php

namespace Database\Seeders;

use App\Models\LearningSession;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Faker\Generator as Faker;

class LearningSessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for ($i = 1; $i < 21; $i++) {
            $LearningSession = new LearningSession();
            $LearningSession->created_by_id =  $faker->numberBetween(1, 4);
            $LearningSession->star_id =  $faker->numberBetween(4, 5);
            $LearningSession->title =  $faker->text(10);
            $LearningSession->registration_end_date =  Carbon::now()->addDays(-2);
            $LearningSession->registration_start_date =  Carbon::now()->addDays(-10);
            $LearningSession->description =  $faker->text(50);
            $LearningSession->venue =  $faker->country();
            $LearningSession->total_seat =  $faker->numberBetween(200, 500);
            $LearningSession->banner =  $faker->imageUrl($width = 300, $height = 200);;
            $LearningSession->participant_number =  $faker->numberBetween(100, 200);
            $LearningSession->video =  "https://youtu.be/lyXjeJN9lyg";
            $LearningSession->date =  Carbon::now();
            $LearningSession->time =  Carbon::now()->setTime(22, 32, 5);
            $LearningSession->fee =  $faker->numberBetween(400, 500);
            $LearningSession->status = 1;
            $LearningSession->total_amount = $faker->numberBetween(100, 150);
            $LearningSession->save();
        }
    }
}
