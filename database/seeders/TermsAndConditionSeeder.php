<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TermAndCondition;

class TermsAndConditionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TermAndCondition::factory()->create();
    }
}
