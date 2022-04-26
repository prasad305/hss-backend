<?php

namespace App\Http\Controllers\ManagerAdmin\Audition;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Audition\Audition;

class AuditionController extends Controller
{
    public function store(Request $request){
        // dd($request->all());

        $request->validate([
            'admin_id' => 'required',
            'admin_name' => 'required',
            'job_type' => 'required',
            'title' => 'required',
            'description' => 'required',
            'jury' => 'required',
            'judge' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
        ]);


        $audition = new Audition();
        $category_id = Auth::user()->category_id;
        $audition_rules_id = new Audition();
        $audition_round_rules_id = new Audition();
        $creater_id = new Audition();
        $audition_admin_id = new Audition();
        $admin_id = new Audition();
        $title = new Audition();
        $slug = new Audition();
        $description = new Audition();
        $banner = new Audition();
        $video = new Audition();
        $round_status = new Audition();
        $template_id = new Audition();
        $start_time = new Audition();
        $end_time = new Audition();
        $status = new Audition();



    }
}
