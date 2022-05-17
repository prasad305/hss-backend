<?php

namespace Database\Seeders\Audition;

use App\Models\Audition\AuditionAssignJury;
use Illuminate\Database\Seeder;
use App\Models\AuditionEvent;
use Carbon\Carbon;
use Faker\Generator as Faker;

class AuditionAssignJurySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        // for ($i = 0; $i < 10; $i++) {
        //     $auditionAssignJury = new AuditionAssignJury();
        //     $auditionAssignJury->audition_id =  $faker->numberBetween(1, 10);
        //     $auditionAssignJury->jury_id =  $faker->numberBetween(1, 10);
        //     $auditionAssignJury->approved_by_jury =  0;
        //     $auditionAssignJury->status =   0;
        //     $auditionAssignJury->save();
        // }
        AuditionAssignJury::create([
            'audition_id' => 10,
            'jury_id' => 31,
            'approved_by_jury' => 0,
            'status' => 0,
            'created_at' => '2022-05-16 00:08:12',
            'updated_at' => '2022-05-16 00:08:12'
        ]);
        AuditionAssignJury::create([
            'audition_id' => 10,
            'jury_id' => 30,
            'approved_by_jury' => 0,
            'status' => 0,
            'created_at' => '2022-05-16 00:08:12',
            'updated_at' => '2022-05-16 00:08:12'
        ]);
        AuditionAssignJury::create([
            'audition_id' => 10,
            'jury_id' => 29,
            'approved_by_jury' => 0,
            'status' => 0,
            'created_at' => '2022-05-16 00:08:12',
            'updated_at' => '2022-05-16 00:08:12'
        ]);
    }
}
