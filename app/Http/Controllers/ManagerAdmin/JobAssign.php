<?php

namespace App\Http\Controllers\ManagerAdmin;

use App\Http\Controllers\Controller;
use App\Models\Audition\AssignAdmin;
use App\Models\Audition\Audition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class JobAssign extends Controller
{
    public function auditionStore(Request $request, $admin_id)
    {


        $request->validate([
            'title' => 'required',
            'details' => 'required',

        ]);

        $audition = new Audition();

        $audition->title = $request->input('title');
        $audition->creater_id = Auth::user()->id;
        $audition->admin_id = $admin_id;
        $audition->slug = Str::slug($request->input('title'));
        $audition->description = $request->input('details');

        try {
            $audition->save();

            $assign_admin = new AssignAdmin();

            $assign_admin->job_id = $audition->id;
            $assign_admin->job_type = $request->job_type;
            $assign_admin->assign_person = $admin_id;
            $assign_admin->save();



            return redirect()->route('managerAdmin.admin.index')->with('success', 'Audition  Assigned');
        } catch (\Exception $exception) {

            return redirect()->back()->with('error', $exception->getMessage());
        }
    }
}
