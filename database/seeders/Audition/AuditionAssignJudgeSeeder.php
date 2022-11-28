<?php

namespace Database\Seeders\Audition;

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Faker\Generator as Faker;
use App\Models\Audition\AuditionAssignJudge;

class AuditionAssignJudgeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        // for ($i = 1; $i < 10; $i++) {
        //     $auditionAssignJudge = new AuditionAssignJudge();
        //     $auditionAssignJudge->judge_id =  $faker->numberBetween(1, 10);
        //     $auditionAssignJudge->audition_id =  $faker->numberBetween(1, 10);
        //     $auditionAssignJudge->approved_by_judge = $faker->numberBetween(0, 1);
        //     $auditionAssignJudge->save();
        // }

        AuditionAssignJudge::create([
            'judge_id' => 44,
            'judge_admin_id' => NULL,
            'audition_id' => 10,
            'approved_by_judge' => 1,
            'status' => 0,
            'created_at' => '2022-05-16 00:08:12',
            'updated_at' => '2022-05-16 00:08:12'
        ]);

        AuditionAssignJudge::create([
            'judge_id' => 43,
            'judge_admin_id' => NULL,
            'audition_id' => 10,
            'approved_by_judge' => 1,
            'status' => 0,
            'created_at' => '2022-05-16 00:08:12',
            'updated_at' => '2022-05-16 00:08:12'
        ]);

        AuditionAssignJudge::create([
            'judge_id' => 42,
            'judge_admin_id' => NULL,
            'audition_id' => 10,
            'approved_by_judge' => 1,
            'status' => 0,
            'created_at' => '2022-05-16 00:08:12',
            'updated_at' => '2022-05-16 00:19:03'
        ]);
    }
}
