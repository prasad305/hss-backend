<?php

namespace App\Http\Controllers\API;
use Carbon\Carbon;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Schedule;

class ScheduleController extends Controller
{
    //
    public function add_schedule(Request $request)
    {

        //Schedule::insert($request->info,['date'=>'2020/12/12']);

        //return $request->all();

        foreach ($request->all() as $key => $req) {

            Schedule::insert([
                'admin_id' => auth('sanctum')->user()->id,
                'event_type' => $req['event_type'],
                'from' => $req['from'],
                'to' => $req['to'],
                'date' => $req['date'],
                'month' => Carbon::parse($req['date'])->format('M'),
                'updated_at' => date("Y-m-d h:i:s"),
                'created_at' => date("Y-m-d h:i:s"),
            ]);
        }





        // if ($schedule) {
        //     return response()->json([
        //         'status'=>200,
        //         'result'=> $schedule,
        //         'message'=>'Greetings Session Added',
        //     ]);
        // }

        return response()->json([
            'status'=>200,
            'result'=> $request->all(),
            'message'=>'Added Successfully',
        ]);



    }

    public function selected_schedule(Request $request)
    {

        $schedule = Schedule::select('date')->distinct()->get();

        $date = [];
        foreach ($schedule as $key => $value) {
            array_push($date,$value['date']);
        }


        return response()->json([
            'status'=>200,
            'schedule'=> $date,
            'message'=>'Added Successfully',
        ]);

    }

    public function schedule_list()
    {
        $schedule = Schedule::select('date','status')->distinct()->where('admin_id',auth('sanctum')->user()->id)->orderBy('date', 'DESC')->get();

        // $date = [];
        // foreach ($schedule as $key => $value) {
        //     array_push($date,$value['date']);
        // }


        return response()->json([
            'status'=>200,
            'schedule'=> $schedule,
            'message'=>'Added Successfully',
        ]);
    }
}
