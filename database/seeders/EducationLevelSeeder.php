<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Educationlevel;

class EducationLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $educationlevel = new Educationlevel;
        $educationlevel->name = 'SSC';
        $educationlevel->status = 1;
        $educationlevel->save();
        $educationlevel = new Educationlevel;
        $educationlevel->name = 'HSC';
        $educationlevel->status = 1;
        $educationlevel->save();
        $educationlevel = new Educationlevel;
        $educationlevel->name = 'BSc';
        $educationlevel->status = 1;
        $educationlevel->save();
        $educationlevel = new Educationlevel;
        $educationlevel->name = 'MSc';
        $educationlevel->status = 1;
        $educationlevel->save();
    }
}
