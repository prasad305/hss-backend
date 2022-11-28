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
        DB::insert("INSERT INTO `currencies` (`country`, `currency`, `currency_code`, `symbol`, `country_code`,`currency_value`,`currency_status`, `status`) VALUES
            ('Bahrain', 'Dinar', 'BHD', 'فلس','BH','0.377', 1, 1),
            ('India', 'Rupees', 'INR', 'Rp','IN','79.630', 1, 1),
            ('Kuwait', 'Dinar', 'KWD', 'KD','KW','0.307', 1, 1),
            ('UAE', 'Dirham', 'AED', 'DH','AE','3.673', 1, 1),
            ('Malaysia', 'Ringgits', 'MYR', 'RM','MY','4.445', 1, 1),
            ('United States of America', 'Dollars', 'USD', '$','US','1.000', 1, 1),
            ('Bangladesh', 'Taka', 'BDT', '৳','BD','94.992', 1, 1)");
    }
}
