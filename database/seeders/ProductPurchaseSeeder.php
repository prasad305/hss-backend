<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProductPurchase;

class ProductPurchaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProductPurchase::factory()->create();
    }
}
