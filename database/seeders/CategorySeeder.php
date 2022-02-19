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
            $Categorty->name = 'Sports';
            $Categorty->slug = 'Sports';
            $Categorty->icon = $faker->imageUrl($width = 200, $height = 200);
            $Categorty->image = $faker->imageUrl($width = 300, $height = 200);
            $Categorty->status = true;
            $Categorty->save();

            $Categorty = new Category();
            $Categorty->name = 'Music';
            $Categorty->slug = 'Music';
            $Categorty->icon = $faker->imageUrl($width = 200, $height = 200);
            $Categorty->image = $faker->imageUrl($width = 300, $height = 200);
            $Categorty->status = true;
            $Categorty->save();

            $Categorty = new Category();
            $Categorty->name = 'Drama';
            $Categorty->slug = 'Drama';
            $Categorty->icon = $faker->imageUrl($width = 200, $height = 200);
            $Categorty->image = $faker->imageUrl($width = 300, $height = 200);
            $Categorty->status = true;
            $Categorty->save();

            $Categorty = new Category();
            $Categorty->name = 'Movie';
            $Categorty->slug = 'Movie';
            $Categorty->icon = $faker->imageUrl($width = 200, $height = 200);
            $Categorty->image = $faker->imageUrl($width = 300, $height = 200);
            $Categorty->status = true;
            $Categorty->save();

            $Categorty = new Category();
            $Categorty->name = 'Comedy';
            $Categorty->slug = 'Comedy';
            $Categorty->icon = $faker->imageUrl($width = 200, $height = 200);
            $Categorty->image = $faker->imageUrl($width = 300, $height = 200);
            $Categorty->status = true;
            $Categorty->save();

            $Categorty = new Category();
            $Categorty->name = 'Tech';
            $Categorty->slug = 'Tech';
            $Categorty->icon = $faker->imageUrl($width = 200, $height = 200);
            $Categorty->image = $faker->imageUrl($width = 300, $height = 200);
            $Categorty->status = true;
            $Categorty->save();

            $Categorty = new Category();
            $Categorty->name = 'Polytics';
            $Categorty->slug = 'Polytics';
            $Categorty->icon = $faker->imageUrl($width = 200, $height = 200);
            $Categorty->image = $faker->imageUrl($width = 300, $height = 200);
            $Categorty->status = true;
            $Categorty->save();

            $Categorty = new Category();
            $Categorty->name = 'Dance';
            $Categorty->slug = 'Dance';
            $Categorty->icon = $faker->imageUrl($width = 200, $height = 200);
            $Categorty->image = $faker->imageUrl($width = 300, $height = 200);
            $Categorty->status = true;
            $Categorty->save();
        
    }
}
