<?php

namespace Database\Seeders;

use App\Models\SuperStar;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Auth;

class SuperStartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $superStar = new SuperStar();
        $superStar->admin_id = 1;
        $superStar->star_id = 4;
        $superStar->category_id = 1;
        $superStar->sub_category_id = 2;
        $superStar->description = $faker->text;
        $superStar->image = "uploads/images/star/sakib.png";
        $superStar->status = 1;
        $superStar->save();

        $superStar = new SuperStar();
        $superStar->admin_id = 1;
        $superStar->star_id = 8;
        $superStar->category_id = 1;
        $superStar->sub_category_id = 2;
        $superStar->description = $faker->text;
        $superStar->image = "uploads/images/star/tamim.png";
        $superStar->status = 1;
        $superStar->save();

        $superStar = new SuperStar();
        $superStar->admin_id = 1;
        $superStar->star_id = 9;
        $superStar->category_id = 1;
        $superStar->sub_category_id = 2;
        $superStar->description = $faker->text;
        $superStar->image = "uploads/images/star/musfiqur.png";
        $superStar->status = 1;
        $superStar->save();

        $superStar = new SuperStar();
        $superStar->admin_id = 1;
        $superStar->star_id = 4;
        $superStar->category_id = 1;
        $superStar->sub_category_id = 2;
        $superStar->description = $faker->text;
        $superStar->image = "uploads/images/star/sakib.png";
        $superStar->status = 1;
        $superStar->save();
    }
}
