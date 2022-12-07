<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\InterestType;

class InterestTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        InterestType::factory(5)->create();
    }
}
