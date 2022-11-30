<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\Models\User;
use App\Models\Auction;
use Carbon\Carbon;

class AuctionSeeder extends Seeder
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
            $auction = new Auction();
            $auction->created_by_id = $userInfoForFootball[$i]->id;
            $auction->admin_id = $userInfoForFootball[$i]->parent_user;
            $auction->star_id = $userInfoForFootball[$i]->id;
            $auction->category_id = 2;
            $auction->subcategory_id = 4;
            $auction->title = $faker->sentence;
            $auction->keyword = 'football';
            $auction->type = 'football';
            $auction->owner_id = $userInfoForFootball[$i]->id;
            $auction->base_price = $faker->numberBetween(100, 200);
            $auction->details = $faker->text(25);
            $auction->product_image = 'seeder_media/image/live-chat.jpg';
            $auction->banner = 'seeder_media/image/live-chat.jpg';
            $auction->bid_from = Carbon::now();
            $auction->bid_to = Carbon::now()->addDays(15);
            $auction->result_date = Carbon::now()->addDays(20);
            $auction->product_delivery_date = Carbon::now()->addDays(30);
            $auction->status = 1;
            $auction->star_approval = 1;
            $auction->product_status = 1;
            $auction->save();
        }

        $userInfoForCricket= User::where('user_type','star')->where('category_id',2)->where('sub_category_id',5)->get();
        $totalUserInfoForCricket = User::where('user_type','star')->where('category_id',2)->where('sub_category_id',5)->count();

        for ($i=0; $i < $totalUserInfoForCricket; $i++) { 
            $auction = new Auction();
            $auction->created_by_id = $userInfoForCricket[$i]->id;
            $auction->admin_id = $userInfoForCricket[$i]->parent_user;
            $auction->star_id = $userInfoForCricket[$i]->id;
            $auction->category_id = 2;
            $auction->subcategory_id = 5;
            $auction->title = $faker->sentence;
            $auction->keyword = 'Cricket';
            $auction->type = 'Cricket';
            $auction->owner_id = $userInfoForCricket[$i]->id;
            $auction->base_price = $faker->numberBetween(100, 200);
            $auction->details = $faker->text(25);
            $auction->product_image = 'seeder_media/image/live-chat.jpg';
            $auction->banner = 'seeder_media/image/live-chat.jpg';
            $auction->bid_from = Carbon::now();
            $auction->bid_to = Carbon::now()->addDays(15);
            $auction->result_date = Carbon::now()->addDays(20);
            $auction->product_delivery_date = Carbon::now()->addDays(30);
            $auction->status = 1;
            $auction->star_approval = 1;
            $auction->product_status = 1;
            $auction->save();
        }

    }
}
