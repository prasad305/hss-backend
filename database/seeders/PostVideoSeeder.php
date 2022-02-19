<?php

namespace Database\Seeders;

use App\Models\PostVideo;
use Illuminate\Database\Seeder;

class PostVideoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i < 21; $i++) {
            $PostVideo = new PostVideo();
            $PostVideo->post_id =  $i;
            $PostVideo->video =  "https://youtu.be/lyXjeJN9lyg";
            $PostVideo->status = 1;
            $PostVideo->save();
        }
    }
}
