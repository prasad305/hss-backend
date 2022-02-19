<?php

namespace Database\Seeders;

use App\Models\UserEducation;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class UserEducationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for ($i = 1; $i < 5; $i++) {
            $UserEducation = new UserEducation();
            $UserEducation->user_id = $i;
            $UserEducation->subject = $faker->text(10);
            $UserEducation->institute = $faker->text(10);
            $UserEducation->passing_year = Carbon::create(2009, 1, 31, 0);
            $UserEducation->grade = $faker->numberBetween(2, 4);
            $UserEducation->save();
        }
    }
}
