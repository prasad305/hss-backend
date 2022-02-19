<?php

namespace Database\Seeders;

use App\Models\SubCategory;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

class SubCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $SubCategorty = new SubCategory();
        $SubCategorty->category_id = 1;
        $SubCategorty->name = 'Football';
        $SubCategorty->slug = 'football';
        $SubCategorty->icon = 'uploads/category/icon/qycnhsXozmXY9CKJqdrN-1639889893.png';
        $SubCategorty->image = 'uploads/category/icon/qycnhsXozmXY9CKJqdrN-1639889893.png';
        $SubCategorty->status = true;
        $SubCategorty->save();

        $SubCategorty = new SubCategory();
        $SubCategorty->category_id = 1;
        $SubCategorty->name = 'Cricket';
        $SubCategorty->slug = 'cricket';
        $SubCategorty->icon = 'uploads/category/icon/tIJUBSq67x1o03zWRi00-1639890035.png';
        $SubCategorty->image = 'uploads/category/icon/tIJUBSq67x1o03zWRi00-1639890035.png';
        $SubCategorty->status = true;
        $SubCategorty->save();

        $SubCategorty = new SubCategory();
        $SubCategorty->category_id = 1;
        $SubCategorty->name = 'Tennis';
        $SubCategorty->slug = 'Tennis';
        $SubCategorty->icon = 'uploads/category/icon/ripCtvWh2gH5cNaoR905-1639890829.png';
        $SubCategorty->image = 'uploads/category/icon/ripCtvWh2gH5cNaoR905-1639890829.png';
        $SubCategorty->status = true;
        $SubCategorty->save();

        $SubCategorty = new SubCategory();
        $SubCategorty->category_id = 1;
        $SubCategorty->name = 'Others';
        $SubCategorty->slug = 'others';
        $SubCategorty->icon = 'uploads/category/icon/qycnhsXozmXY9CKJqdrN-1639889893.png';
        $SubCategorty->image = 'uploads/category/icon/qycnhsXozmXY9CKJqdrN-1639889893.png';
        $SubCategorty->status = true;
        $SubCategorty->save();
    }
}
