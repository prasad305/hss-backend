<?php

namespace Database\Seeders;

use App\Models\PostComment;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Faker\Generator as Faker;

class PostCommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for ($i = 1; $i < 21; $i++) {
            $PostComment = new PostComment();
            $PostComment->post_id =  $i;
            $PostComment->user_id =  $faker->numberBetween(1, 4);
            $PostComment->parent_comment_id = null;
            $PostComment->comment =  $faker->text(20);
            $PostComment->react_no = $faker->numberBetween(0, 2);
            $PostComment->status = 1;
            $PostComment->save();
        };
    }
}
