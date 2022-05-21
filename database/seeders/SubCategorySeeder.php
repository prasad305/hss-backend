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
        $SubCategorty->icon = 'uploads/category/icon/qycnhsXozmXY9CKJqdrN-1639889893.png';
        $SubCategorty->image = 'uploads/category/icon/qycnhsXozmXY9CKJqdrN-1639889893.png';
        $SubCategorty->status = true;
        $SubCategorty->save();

        $SubCategorty = new SubCategory();
        $SubCategorty->category_id = 1;
        $SubCategorty->name = 'Dhallywood';
        $SubCategorty->slug = 'dhallywood';
        $SubCategorty->icon = 'uploads/category/icon/qycnhsXozmXY9CKJqdrN-1639889893.png';
        $SubCategorty->image = 'uploads/category/icon/qycnhsXozmXY9CKJqdrN-1639889893.png';
        $SubCategorty->status = true;
        $SubCategorty->save();

        $SubCategorty = new SubCategory();
        $SubCategorty->category_id = 1;
        $SubCategorty->name = 'Tollywood';
        $SubCategorty->slug = 'tollywood';
        $SubCategorty->icon = 'uploads/category/icon/qycnhsXozmXY9CKJqdrN-1639889893.png';
        $SubCategorty->image = 'uploads/category/icon/qycnhsXozmXY9CKJqdrN-1639889893.png';
        $SubCategorty->status = true;
        $SubCategorty->save();

        $SubCategorty = new SubCategory();
        $SubCategorty->category_id = 2;
        $SubCategorty->name = 'Football';
        $SubCategorty->slug = 'football';
        $SubCategorty->icon = 'uploads/category/icon/qycnhsXozmXY9CKJqdrN-1639889893.png';
        $SubCategorty->image = 'uploads/category/icon/qycnhsXozmXY9CKJqdrN-1639889893.png';
        $SubCategorty->status = true;
        $SubCategorty->save();

        $SubCategorty = new SubCategory();
        $SubCategorty->category_id = 2;
        $SubCategorty->name = 'Cricket';
        $SubCategorty->slug = 'cricket';
        $SubCategorty->icon = 'uploads/category/icon/tIJUBSq67x1o03zWRi00-1639890035.png';
        $SubCategorty->image = 'uploads/category/icon/tIJUBSq67x1o03zWRi00-1639890035.png';
        $SubCategorty->status = true;
        $SubCategorty->save();

        $SubCategorty = new SubCategory();
        $SubCategorty->category_id = 2;
        $SubCategorty->name = 'Badminton';
        $SubCategorty->slug = 'badminton';
        $SubCategorty->icon = 'uploads/category/icon/ripCtvWh2gH5cNaoR905-1639890829.png';
        $SubCategorty->image = 'uploads/category/icon/ripCtvWh2gH5cNaoR905-1639890829.png';
        $SubCategorty->status = true;
        $SubCategorty->save();


        $SubCategorty = new SubCategory();
        $SubCategorty->category_id = 3;
        $SubCategorty->name = 'Folk Music';
        $SubCategorty->slug = 'folk-music';
        $SubCategorty->icon = 'uploads/category/icon/qycnhsXozmXY9CKJqdrN-1639889893.png';
        $SubCategorty->image = 'uploads/category/icon/qycnhsXozmXY9CKJqdrN-1639889893.png';
        $SubCategorty->status = true;
        $SubCategorty->save();

        $SubCategorty = new SubCategory();
        $SubCategorty->category_id = 3;
        $SubCategorty->name = 'Rock Music';
        $SubCategorty->slug = 'rock-music';
        $SubCategorty->icon = 'uploads/category/icon/qycnhsXozmXY9CKJqdrN-1639889893.png';
        $SubCategorty->image = 'uploads/category/icon/qycnhsXozmXY9CKJqdrN-1639889893.png';
        $SubCategorty->status = true;
        $SubCategorty->save();
    }
}
