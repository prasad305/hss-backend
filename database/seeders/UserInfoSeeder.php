<?php

namespace Database\Seeders;

use App\Models\UserInfo;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

class UserInfoSeeder extends Seeder


{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for ($i = 0; $i < 10; $i++) {

            $SubCategorty = new UserInfo();
            $SubCategorty->user_id = $faker->numberBetween(1, 4);
            $SubCategorty->nid = $faker->phoneNumber();
            $SubCategorty->passport = $faker->phoneNumber(20);
            $SubCategorty->gender = $faker->boolean();
            $SubCategorty->country = $faker->country();
            $SubCategorty->dob = Carbon::now()->addDays(-10);
            $SubCategorty->save();
        }
    }
}
