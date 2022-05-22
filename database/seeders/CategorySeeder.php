<?php

namespace Database\Seeders;

use App\Models\Category;
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
        

            $Categorty = new Category();
            $Categorty->name = 'Flim Stars';
            $Categorty->slug = 'flim-stars';
            $Categorty->icon = $faker->imageUrl($width = 200, $height = 200);
            $Categorty->image = $faker->imageUrl($width = 300, $height = 200);
            $Categorty->status = true;
            $Categorty->save();

            $Categorty = new Category();
            
            $Categorty->name = 'Sports';
            $Categorty->slug = 'sports';
            $Categorty->icon = $faker->imageUrl($width = 200, $height = 200);
            $Categorty->image = $faker->imageUrl($width = 300, $height = 200);
            $Categorty->status = true;
            $Categorty->save();

            $Categorty = new Category();
            $Categorty->name = 'Musician';
            $Categorty->slug = 'musician';
            $Categorty->icon = $faker->imageUrl($width = 200, $height = 200);
            $Categorty->image = $faker->imageUrl($width = 300, $height = 200);
            $Categorty->status = true;
            $Categorty->save();

            $Categorty = new Category();
            $Categorty->name = 'Dancers';
            $Categorty->slug = 'dancers';
            $Categorty->icon = $faker->imageUrl($width = 200, $height = 200);
            $Categorty->image = $faker->imageUrl($width = 300, $height = 200);
            $Categorty->status = true;
            $Categorty->save();

            $Categorty = new Category();
            $Categorty->name = 'Chefs';
            $Categorty->slug = 'chefs';
            $Categorty->icon = $faker->imageUrl($width = 200, $height = 200);
            $Categorty->image = $faker->imageUrl($width = 300, $height = 200);
            $Categorty->status = true;
            $Categorty->save();

            $Categorty = new Category();
            $Categorty->name = 'Drama';
            $Categorty->slug = 'drama';
            $Categorty->icon = $faker->imageUrl($width = 200, $height = 200);
            $Categorty->image = $faker->imageUrl($width = 300, $height = 200);
            $Categorty->status = true;
            $Categorty->save();

            $Categorty = new Category();
            $Categorty->name = 'Tech';
            $Categorty->slug = 'tech';
            $Categorty->icon = $faker->imageUrl($width = 200, $height = 200);
            $Categorty->image = $faker->imageUrl($width = 300, $height = 200);
            $Categorty->status = true;
            $Categorty->save();

            $Categorty = new Category();
            $Categorty->name = 'Motivational Speaker';
            $Categorty->slug = 'motivational-speaker';
            $Categorty->icon = $faker->imageUrl($width = 200, $height = 200);
            $Categorty->image = $faker->imageUrl($width = 300, $height = 200);
            $Categorty->status = true;
            $Categorty->save();

            $Categorty = new Category();
            $Categorty->name = 'Religion';
            $Categorty->slug = 'religion';
            $Categorty->icon = $faker->imageUrl($width = 200, $height = 200);
            $Categorty->image = $faker->imageUrl($width = 300, $height = 200);
            $Categorty->status = true;
            $Categorty->save();

            $Categorty = new Category();
            $Categorty->name = 'Comedians';
            $Categorty->slug = 'comedians';
            $Categorty->icon = $faker->imageUrl($width = 200, $height = 200);
            $Categorty->image = $faker->imageUrl($width = 300, $height = 200);
            $Categorty->status = true;
            $Categorty->save();
        
    }
}
