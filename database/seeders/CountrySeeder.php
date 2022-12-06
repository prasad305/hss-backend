<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Country;
use App\Models\State;
use App\Models\City;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Country::factory(5)->create()->each(function($country){
            State::factory(10)->create([
                'country_id' => $country->id,
            ])->each(function($state){
                City::factory(15)->create([
                    'country_id' =>$state->country_id,
                    'state_id' => $state->id,
                ]);
            });
        });
    }
}
