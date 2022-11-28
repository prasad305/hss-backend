<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::insert("INSERT INTO `currencies` (`id`, `country`, `currency`, `code`, `symbol`, `currency_status`, `status`, `created_at`, `updated_at`) VALUES
            (1, 'Bahrain', 'Dinar', 'BHD', 'فلس', 0, 1, NULL, NULL),
            (2, 'India', 'Rupees', 'INR', 'Rp', 0, 1, NULL, NULL),
            (3, 'Kuwait', 'Dinar', 'KWD', 'KD', 1, 1, NULL, NULL),
            (4, 'UAE', 'Dirham', 'AED', 'DH', 0, 1, NULL, NULL),
            (5, 'Malaysia', 'Ringgits', 'MYR', 'RM', 0, 1, NULL, NULL),
            (6, 'United States of America', 'Dollars', 'USD', '$', 1, 1, NULL, '2020-05-12 15:55:30'),
            (7, 'Bangladesh', 'Taka', 'BDT', '৳', 0, 1, '2020-02-03 00:38:33', '2020-05-12 15:55:30')");
    }
}
