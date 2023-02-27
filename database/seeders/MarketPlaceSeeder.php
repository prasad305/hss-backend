<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\Models\User;
use App\Models\Marketplace;
use Carbon\Carbon;

class MarketPlaceSeeder extends Seeder
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
            $marketplace = new Marketplace();
            $marketplace->title = $faker->sentence;
            $marketplace->category_id = 2;
            $marketplace->subcategory_id = 4;
            $marketplace->slug = 'football';
            $marketplace->description = $faker->text(25);
            $marketplace->terms_conditions = $faker->text(25);
            $marketplace->unit_price = $faker->numberBetween(500, 1000);
            $marketplace->total_items = $faker->numberBetween(40, 70);
            $marketplace->total_selling = $faker->numberBetween(10, 20);
            $marketplace->tax = $faker->numberBetween(150, 250);
            $marketplace->superstar_id = $userInfoForFootball[$i]->id;
            $marketplace->created_by_id = $userInfoForFootball[$i]->id;
            $marketplace->superstar_admin_id = $userInfoForFootball[$i]->parent_user;
            $marketplace->keywords = 'football';
            $marketplace->post_status = 1;
            $marketplace->status = 1;
            $marketplace->image = 'seeder_media/image/post.png';
            $marketplace->approved_date = Carbon::now();;
            $marketplace->save();
        }

        $userInfoForCricket = User::where('user_type','star')->where('category_id',2)->where('sub_category_id',5)->get();
        $totalUserInfoForCricket = User::where('user_type','star')->where('category_id',2)->where('sub_category_id',5)->count();
        for ($i=0; $i < $totalUserInfoForCricket; $i++) { 
            $marketplace = new Marketplace();
            $marketplace->title = $faker->sentence;
            $marketplace->category_id = 2;
            $marketplace->subcategory_id = 5;
            $marketplace->slug = 'cricket';
            $marketplace->description = $faker->text(25);
            $marketplace->terms_conditions = $faker->text(25);
            $marketplace->unit_price = $faker->numberBetween(500, 1000);
            $marketplace->total_items = $faker->numberBetween(40, 70);
            $marketplace->total_selling = $faker->numberBetween(10, 20);
            $marketplace->tax = $faker->numberBetween(150, 250);
            $marketplace->superstar_id = $userInfoForCricket[$i]->id;
            $marketplace->created_by_id = $userInfoForCricket[$i]->id;
            $marketplace->superstar_admin_id = $userInfoForCricket[$i]->parent_user;
            $marketplace->keywords = 'cricket';
            $marketplace->post_status = 1;
            $marketplace->status = 1;
            $marketplace->image = 'seeder_media/image/post.png';
            $marketplace->approved_date = Carbon::now();;
            $marketplace->save();
        }

    }
}
