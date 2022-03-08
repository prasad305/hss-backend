<?php

namespace Database\Seeders;

use App\Models\AuditionComment;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class AuditionCommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for ($i = 1; $i < 21; $i++) {
            $AuditionComment = new AuditionComment();
            $AuditionComment->audition_event_id =  $i;
            $AuditionComment->user_id =  $faker->numberBetween(1, 4);
            $AuditionComment->parent_comment_id = null;
            $AuditionComment->comment =  $faker->text(20);
            $AuditionComment->react_no = $faker->numberBetween(0, 2);
            $AuditionComment->status = 1;
            $AuditionComment->save();
        };
    }
}
