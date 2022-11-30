<?php

namespace Database\Seeders;

use App\Models\GeneralPostPayment;
use App\Models\Post;
use App\Models\SimplePost;
use App\Models\User;
use Illuminate\Database\Seeder;

class SimplePostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SimplePost::factory(2)->create()->each(function ($post) {
            if ($post->id % 2 == 0) {

                SimplePost::where('id', $post->id)->update([
                    'post_type' => "general",
                    'type' => 'paid',
                    'fee' => 500,
                ]);
            } else {
                SimplePost::where('id', $post->id)->update([
                    'post_type' => "general",
                    'type' => 'free',
                ]);
            }
            Post::create([
                'type' => 'general',
                'user_id' => $post->star_id,
                'star_id' => $post->star_id,
                'event_id' =>  $post->id,
                'category_id' =>  $post->category_id,
                'sub_category_id' =>  $post->subcategory_id,
                'title' =>  $post->title,
                'details' =>  $post->description,
            ]);
        });
    }
}
