<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\Models\User;
use App\Models\SouvenirCreate;
use Carbon\Carbon;

class SouvenirSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $userInfoForFootball = User::where('user_type','star')->where('category_id',2)->where('sub_category_id',4)->get();
        $totalUserInfoForFootball = User::where('user_type','star')->where('category_id',2)->where('sub_category_id',4)->count();

        for ($i=0; $i < $totalUserInfoForFootball; $i++) { 
            $souvenir = new SouvenirCreate();
            $souvenir->title = $faker->sentence;
            $souvenir->slug = 'football';
            $souvenir->category_id = 2;
            $souvenir->sub_category_id = 4;
            $souvenir->description = $faker->text(25);
            $souvenir->instruction = $faker->text(25);
            $souvenir->price = $faker->numberBetween(500, 1000);
            $souvenir->delivery_charge = $faker->numberBetween(100, 200);
            $souvenir->tax = $faker->numberBetween(150, 250);
            $souvenir->admin_id = $userInfoForFootball[$i]->parent_user;
            $souvenir->star_id = $userInfoForFootball[$i]->id;
            $souvenir->banner = 'seeder_media/image/post.png';
            $souvenir->video = 'seeder_media/video/post.mp4';
            $souvenir->approval_status = 1;
            $souvenir->status = 1;
            $souvenir->save();
        }

        $userInfoForCricket = User::where('user_type','star')->where('category_id',2)->where('sub_category_id',5)->get();
        $totalUserInfoForCricket = User::where('user_type','star')->where('category_id',2)->where('sub_category_id',5)->count();

        for ($i=0; $i < $totalUserInfoForCricket; $i++) { 
            $souvenir = new SouvenirCreate();
            $souvenir->title = $faker->sentence;
            $souvenir->slug = 'cricket';
            $souvenir->category_id = 2;
            $souvenir->sub_category_id = 4;
            $souvenir->description = $faker->text(25);
            $souvenir->instruction = $faker->text(25);
            $souvenir->price = $faker->numberBetween(500, 1000);
            $souvenir->delivery_charge = $faker->numberBetween(100, 200);
            $souvenir->tax = $faker->numberBetween(150, 250);
            $souvenir->admin_id = $userInfoForCricket[$i]->parent_user;
            $souvenir->star_id = $userInfoForCricket[$i]->id;
            $souvenir->banner = 'seeder_media/image/post.png';
            $souvenir->video = 'seeder_media/video/post.mp4';
            $souvenir->approval_status = 1;
            $souvenir->status = 1;
            $souvenir->save();
        }

    }
}
