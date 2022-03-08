<?php

namespace Database\Seeders;

use App\Models\PostImage;
use Carbon\Carbon;
use Faker\Generator as Faker;

use Illuminate\Database\Seeder;

class PostImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for ($i = 1; $i < 21; $i++) {
            $PostImage = new PostImage();
            $PostImage->post_id =  $i;
            $PostImage->image = $faker->imageUrl($width = 300, $height = 200);
            $PostImage->status = 1;
            $PostImage->save();
        };
    }
}
