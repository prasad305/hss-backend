<?php

namespace Database\Seeders;

use App\Models\SuperStar;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Auth;

class SuperStarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $superStar = new SuperStar();
        $superStar->admin_id = 11;
        $superStar->star_id = 29;
        $superStar->category_id = 1;
        $superStar->sub_category_id = 1;
        $superStar->description = $faker->text;
        $superStar->image = "uploads/images/star/sakib.png";
        $superStar->status = 1;
        $superStar->save();

        $superStar = new SuperStar();
        $superStar->admin_id = 12;
        $superStar->star_id = 30;
        $superStar->category_id = 1;
        $superStar->sub_category_id = 1;
        $superStar->description = $faker->text;
        $superStar->image = "uploads/images/star/tamim.png";
        $superStar->status = 1;
        $superStar->save();

        $superStar = new SuperStar();
        $superStar->admin_id = 13;
        $superStar->star_id = 31;
        $superStar->category_id = 1;
        $superStar->sub_category_id = 1;
        $superStar->description = $faker->text;
        $superStar->image = "uploads/images/star/musfiqur.png";
        $superStar->status = 1;
        $superStar->save();

        $superStar = new SuperStar();
        $superStar->admin_id = 14;
        $superStar->star_id = 32;
        $superStar->category_id = 1;
        $superStar->sub_category_id = 3;
        $superStar->description = $faker->text;
        $superStar->image = "uploads/images/star/sakib.png";
        $superStar->status = 1;
        $superStar->save();

        $superStar = new SuperStar();
        $superStar->admin_id = 15;
        $superStar->star_id = 33;
        $superStar->category_id = 1;
        $superStar->sub_category_id = 3;
        $superStar->description = $faker->text;
        $superStar->image = "uploads/images/star/sakib.png";
        $superStar->status = 1;
        $superStar->save();

        $superStar = new SuperStar();
        $superStar->admin_id = 16;
        $superStar->star_id = 34;
        $superStar->category_id = 1;
        $superStar->sub_category_id = 3;
        $superStar->description = $faker->text;
        $superStar->image = "uploads/images/star/sakib.png";
        $superStar->status = 1;
        $superStar->save();

        $superStar = new SuperStar();
        $superStar->admin_id = 17;
        $superStar->star_id = 35;
        $superStar->category_id = 1;
        $superStar->sub_category_id = 2;
        $superStar->description = $faker->text;
        $superStar->image = "uploads/images/star/sakib.png";
        $superStar->status = 1;
        $superStar->save();

        $superStar = new SuperStar();
        $superStar->admin_id = 18;
        $superStar->star_id = 36;
        $superStar->category_id = 1;
        $superStar->sub_category_id = 2;
        $superStar->description = $faker->text;
        $superStar->image = "uploads/images/star/sakib.png";
        $superStar->status = 1;
        $superStar->save();

        $superStar = new SuperStar();
        $superStar->admin_id = 19;
        $superStar->star_id = 37;
        $superStar->category_id = 1;
        $superStar->sub_category_id = 2;
        $superStar->description = $faker->text;
        $superStar->image = "uploads/images/star/sakib.png";
        $superStar->status = 1;
        $superStar->save();

        $superStar = new SuperStar();
        $superStar->admin_id = 20;
        $superStar->star_id = 38;
        $superStar->category_id = 2;
        $superStar->sub_category_id = 5;
        $superStar->description = $faker->text;
        $superStar->image = "uploads/images/star/sakib.png";
        $superStar->status = 1;
        $superStar->save();

        $superStar = new SuperStar();
        $superStar->admin_id = 21;
        $superStar->star_id = 39;
        $superStar->category_id = 2;
        $superStar->sub_category_id = 5;
        $superStar->description = $faker->text;
        $superStar->image = "uploads/images/star/sakib.png";
        $superStar->status = 1;
        $superStar->save();

        $superStar = new SuperStar();
        $superStar->admin_id = 22;
        $superStar->star_id = 40;
        $superStar->category_id = 2;
        $superStar->sub_category_id = 5;
        $superStar->description = $faker->text;
        $superStar->image = "uploads/images/star/sakib.png";
        $superStar->status = 1;
        $superStar->save();

        $superStar = new SuperStar();
        $superStar->admin_id = 23;
        $superStar->star_id = 41;
        $superStar->category_id = 2;
        $superStar->sub_category_id = 4;
        $superStar->description = $faker->text;
        $superStar->image = "uploads/images/star/sakib.png";
        $superStar->status = 1;
        $superStar->save();

        $superStar = new SuperStar();
        $superStar->admin_id = 24;
        $superStar->star_id = 42;
        $superStar->category_id = 2;
        $superStar->sub_category_id = 4;
        $superStar->description = $faker->text;
        $superStar->image = "uploads/images/star/sakib.png";
        $superStar->status = 1;
        $superStar->save();

        $superStar = new SuperStar();
        $superStar->admin_id = 25;
        $superStar->star_id = 43;
        $superStar->category_id = 2;
        $superStar->sub_category_id = 4;
        $superStar->description = $faker->text;
        $superStar->image = "uploads/images/star/sakib.png";
        $superStar->status = 1;
        $superStar->save();

        $superStar = new SuperStar();
        $superStar->admin_id = 26;
        $superStar->star_id = 44;
        $superStar->category_id = 3;
        $superStar->sub_category_id = 7;
        $superStar->description = $faker->text;
        $superStar->image = "uploads/images/star/sakib.png";
        $superStar->status = 1;
        $superStar->save();

        $superStar = new SuperStar();
        $superStar->admin_id = 27;
        $superStar->star_id = 45;
        $superStar->category_id = 3;
        $superStar->sub_category_id = 8;
        $superStar->description = $faker->text;
        $superStar->image = "uploads/images/star/sakib.png";
        $superStar->status = 1;
        $superStar->save();

        $superStar = new SuperStar();
        $superStar->admin_id = 28;
        $superStar->star_id = 46;
        $superStar->category_id = 3;
        $superStar->sub_category_id = 8;
        $superStar->description = $faker->text;
        $superStar->image = "uploads/images/star/sakib.png";
        $superStar->status = 1;
        $superStar->save();
    }
}
