<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProfitShare;

class ProfitShareSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $profit = new ProfitShare();
        $profit->user_id = 16;
        $profit->user_type = 'admin';
        $profit->profit = 5;
        $profit->status = 1;
        $profit->save();

        for ($i=20; $i <= 25; $i++) { 
            $profit = new ProfitShare();
            $profit->user_id = $i;
            $profit->user_type = 'admin';
            $profit->profit = 5;
            $profit->status = 1;
            $profit->save();
        }
       
        $profit = new ProfitShare();
        $profit->user_id = 34;
        $profit->user_type = 'star';
        $profit->profit = 5;
        $profit->status = 1;
        $profit->save();
        
        for ($i=38; $i <= 43; $i++) { 
            $profit = new ProfitShare();
            $profit->user_id = $i;
            $profit->user_type = 'star';
            $profit->profit = 5;
            $profit->status = 1;
            $profit->save();
        }

    }
}
