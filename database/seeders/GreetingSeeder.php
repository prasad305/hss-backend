<?php

namespace Database\Seeders;

use App\Models\Greeting;
use Illuminate\Database\Seeder;

class GreetingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Greeting::factory(1)->create([
            'created_by_id' => 20,
            'admin_id' => 20,
            'star_id' => 38,
            'category_id' => 2,
            'sub_category_id' => 5,
        ]);
        Greeting::factory(1)->create([
            'created_by_id' => 22,
            'admin_id' => 22,
            'star_id' => 40,
            'category_id' => 2,
            'sub_category_id' => 5,
        ]);
    }
}
