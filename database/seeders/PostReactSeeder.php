<?php

namespace Database\Seeders;

use App\Models\PostReact;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class PostReactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for ($i = 1; $i < 21; $i++) {
            $PostReact = new PostReact();
            $PostReact->post_id =  $i;
            $PostReact->user_id = $faker->numberBetween(1, 4);
            $PostReact->react = $faker->numberBetween(0, 2);
            $PostReact->save();
        };
    }
}
