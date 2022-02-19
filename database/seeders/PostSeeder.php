<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Faker\Generator as Faker;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for ($i = 1; $i < 10; $i++) {
            $Post = new Post();
            $Post->type =  'meetup';
            $Post->event_id =  $faker->numberBetween(1, 20);
            $Post->user_id =  $faker->numberBetween(1, 4);
            $Post->comment_number = $faker->numberBetween(1, 5);
            $Post->react_number = $faker->numberBetween(1, 5);
            $Post->share_number = $faker->numberBetween(1, 5);
            $Post->title = $faker->text(20);
            $Post->details = $faker->text(100);
            $Post->share_link = null;
            $Post->status = 1;
            $Post->save();
        };
    }
}
