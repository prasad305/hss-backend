<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RefundPolicy;

class RefundPolicySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        RefundPolicy::factory()->create();
    }
}
