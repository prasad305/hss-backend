<?php

namespace App\Http\Controllers\ManagerAdmin;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{

    public function index()
    {
        $adminIds = Schedule::groupBy('admin_id')->pluck('admin_id');
        $admins = User::whereIn('id', $adminIds)->where([['status', 1], ['active_status', 1], ['category_id', auth()->user()->category_id]])->get();

        return view('ManagerAdmin.schedule.index', compact('admins'));
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        //
    }


    public function show($id)
    {
        $schedules = Schedule::whereMonth('date', '=', Carbon::now()->month)->where('admin_id', $id)->orderBY('date','asc')->get();
         $schedulesOrderByDate = $schedules->groupBy(function ($val) {
            return Carbon::parse($val->date)->format('Y M, d');
        });
        $admin = User::find($id);
        // dd($schedulesOrderByDate);
        return view('ManagerAdmin.schedule.view', compact('schedulesOrderByDate','admin'));
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        //
    }
}
