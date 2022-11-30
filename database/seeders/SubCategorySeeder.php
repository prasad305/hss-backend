<?php

namespace Database\Seeders;

use App\Models\SubCategory;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

class SubCategorySeeder extends Seeder
{
   
    public function run(Faker $faker)
    {
        // for flim star //
        $SubCategorty = new SubCategory();
        $SubCategorty->category_id = 1;
        $SubCategorty->name = 'Bollywood';
        $SubCategorty->slug = 'bollywood';
        $SubCategorty->icon = 'seeder_media/image/category-icon.png';
        $SubCategorty->image = 'seeder_media/image/category-image.jpeg';
        $SubCategorty->status = true;
        $SubCategorty->save();

        $SubCategorty = new SubCategory();
        $SubCategorty->category_id = 1;
        $SubCategorty->name = 'Dhallywood';
        $SubCategorty->slug = 'dhallywood';
        $SubCategorty->icon = 'seeder_media/image/category-icon.png';
        $SubCategorty->image = 'seeder_media/image/category-image.jpeg';
        $SubCategorty->status = true;
        $SubCategorty->save();

        $SubCategorty = new SubCategory();
        $SubCategorty->category_id = 1;
        $SubCategorty->name = 'Tollywood';
        $SubCategorty->slug = 'tollywood';
        $SubCategorty->icon = 'seeder_media/image/category-icon.png';
        $SubCategorty->image = 'seeder_media/image/category-image.jpeg';
        $SubCategorty->status = true;
        $SubCategorty->save();

        $SubCategorty = new SubCategory();
        $SubCategorty->category_id = 2;
        $SubCategorty->name = 'Football';
        $SubCategorty->slug = 'football';
        $SubCategorty->icon = 'seeder_media/image/category-icon.png';
        $SubCategorty->image = 'seeder_media/image/category-image.jpeg';
        $SubCategorty->status = true;
        $SubCategorty->save();

        $SubCategorty = new SubCategory();
        $SubCategorty->category_id = 2;
        $SubCategorty->name = 'Cricket';
        $SubCategorty->slug = 'cricket';
        $SubCategorty->icon = 'seeder_media/image/category-icon.png';
        $SubCategorty->image = 'seeder_media/image/category-image.jpeg';
        $SubCategorty->status = true;
        $SubCategorty->save();

        $SubCategorty = new SubCategory();
        $SubCategorty->category_id = 2;
        $SubCategorty->name = 'Badminton';
        $SubCategorty->slug = 'badminton';
        $SubCategorty->icon = 'seeder_media/image/category-icon.png';
        $SubCategorty->image = 'seeder_media/image/category-image.jpeg';
        $SubCategorty->status = true;
        $SubCategorty->save();


        $SubCategorty = new SubCategory();
        $SubCategorty->category_id = 3;
        $SubCategorty->name = 'Folk Music';
        $SubCategorty->slug = 'folk-music';
        $SubCategorty->icon = 'seeder_media/image/category-icon.png';
        $SubCategorty->image = 'seeder_media/image/category-image.jpeg';
        $SubCategorty->status = true;
        $SubCategorty->save();

        $SubCategorty = new SubCategory();
        $SubCategorty->category_id = 3;
        $SubCategorty->name = 'Rock Music';
        $SubCategorty->slug = 'rock-music';
        $SubCategorty->icon = 'seeder_media/image/category-icon.png';
        $SubCategorty->image = 'seeder_media/image/category-image.jpeg';
        $SubCategorty->status = true;
        $SubCategorty->save();
    }
}
