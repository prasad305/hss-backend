<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TermAndCondition;

class TermAndConditionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    protected $model = TermAndCondition::class;
    public function run()
    {
        TermAndCondition::factory()->create();
    }
}
