<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Audition\AuditionRules;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $category = new Category();
        $category->name = 'Flim Stars';
        $category->slug = 'flim-stars';
        $category->icon = 'seeder_media/image/category-icon.png';
        $category->image = 'seeder_media/image/category-image.jpeg';
        $category->status = true;
        $category->save();

        $auditionRule = new AuditionRules();
        $auditionRule->category_id = $category->id;
        $auditionRule->save();

        $category = new Category();
        $category->name = 'Sports';
        $category->slug = 'sports';
        $category->icon = 'seeder_media/image/category-icon.png';
        $category->image = 'seeder_media/image/category-image.jpeg';
        $category->status = true;
        $category->save();

        $auditionRule = new AuditionRules();
        $auditionRule->category_id = $category->id;
        $auditionRule->save();

        $category = new Category();
        $category->name = 'Musician';
        $category->slug = 'musician';
        $category->icon = 'seeder_media/image/category-icon.png';
        $category->image = 'seeder_media/image/category-image.jpeg';
        $category->status = true;
        $category->save();

        $auditionRule = new AuditionRules();
        $auditionRule->category_id = $category->id;
        $auditionRule->save();

        $category = new Category();
        $category->name = 'Dancers';
        $category->slug = 'dancers';
        $category->icon = 'seeder_media/image/category-icon.png';
        $category->image = 'seeder_media/image/category-image.jpeg';
        $category->status = true;
        $category->save();

        $auditionRule = new AuditionRules();
        $auditionRule->category_id = $category->id;
        $auditionRule->save();

        $category = new Category();
        $category->name = 'Chefs';
        $category->slug = 'chefs';
        $category->icon = 'seeder_media/image/category-icon.png';
        $category->image = 'seeder_media/image/category-image.jpeg';
        $category->status = true;
        $category->save();

        $auditionRule = new AuditionRules();
        $auditionRule->category_id = $category->id;
        $auditionRule->save();

        $category = new Category();
        $category->name = 'Drama';
        $category->slug = 'drama';
        $category->icon = 'seeder_media/image/category-icon.png';
        $category->image = 'seeder_media/image/category-image.jpeg';
        $category->status = true;
        $category->save();

        $auditionRule = new AuditionRules();
        $auditionRule->category_id = $category->id;
        $auditionRule->save();

        $category = new Category();
        $category->name = 'Tech';
        $category->slug = 'tech';
        $category->icon = 'seeder_media/image/category-icon.png';
        $category->image = 'seeder_media/image/category-image.jpeg';
        $category->status = true;
        $category->save();

        $auditionRule = new AuditionRules();
        $auditionRule->category_id = $category->id;
        $auditionRule->save();

        $category = new Category();
        $category->name = 'Motivational Speaker';
        $category->slug = 'motivational-speaker';
        $category->icon = 'seeder_media/image/category-icon.png';
        $category->image = 'seeder_media/image/category-image.jpeg';
        $category->status = true;
        $category->save();

        $auditionRule = new AuditionRules();
        $auditionRule->category_id = $category->id;
        $auditionRule->save();

        $category = new Category();
        $category->name = 'Religion';
        $category->slug = 'religion';
        $category->icon = 'seeder_media/image/category-icon.png';
        $category->image = 'seeder_media/image/category-image.jpeg';
        $category->status = true;
        $category->save();

        $auditionRule = new AuditionRules();
        $auditionRule->category_id = $category->id;
        $auditionRule->save();

        $category = new Category();
        $category->name = 'Comedians';
        $category->slug = 'comedians';
        $category->icon = 'seeder_media/image/category-icon.png';
        $category->image = 'seeder_media/image/category-image.jpeg';
        $category->status = true;
        $category->save();

        $auditionRule = new AuditionRules();
        $auditionRule->category_id = $category->id;
        $auditionRule->save();
    }
}
