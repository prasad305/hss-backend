<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Schedule;
use App\Models\User;

class StarScheduleController extends Controller
{
    //
    public function add_schedule(Request $request)
    {

      
        // $deleteable_ids = [];
        //  return gettype($request->{'0'}['date']);
        foreach ($request->all() as $key => $req) {
            $star = User::where('parent_user',auth()->user()->id)->first();
            if (isset($req['id'])) {
                // return 'id has found';

                // Schedule::whereNotIn('id',$req['id'])->where('date',$request->{'0'}['date'])->delete();

            //    $pre_ids =  Schedule::where('date',$request->{'0'}['date'])->pluck('id');

               

                Schedule::where('id',$req['id'])->update([
                    'event_type' => $req['event_type'],
                    'from' => $req['from'],
                    'to' => $req['to'],
                    'date' => $req['date'],
                ]);
            }else{
                Schedule::insert([
                    'admin_id' => auth('sanctum')->user()->parent_user,
                    'event_type' => $req['event_type'],
                    'star_id' => auth()->user()->id,
                    'from' => $req['from'],
                    'to' => $req['to'],
                    'date' => $req['date'],
                    'month' => Carbon::parse($req['date'])->format('M'),
                    'updated_at' => date("Y-m-d h:i:s"),
                    'created_at' => date("Y-m-d h:i:s"),
                ]);
            }
        
        }

        return response()->json([
            'status'=>200,
            // 'result'=> $request->all(),
            'message'=>'Schedule Added Successfully',
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

    public function dateWiseSchedule($date)
    {
        $schedule = Schedule::where([['star_id',auth('sanctum')->user()->id],['date',$date]])->get();
        return response()->json([
            'status'=>200,
            'schedule'=> $schedule,
        ]);

    }

    public function schedule_list()
    {
        $schedule = Schedule::select('date','status')->distinct()->where('star_id',auth('sanctum')->user()->id)->orderBy('date', 'DESC')->get();
        
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

    public function current_week_schedule_list()
    {

        $schedule = Schedule::select(['event_type as title','date as startDate','from','to'])->whereBetween('date',
        [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->where('star_id',auth('sanctum')->user()->id)->get();

        return response()->json([
            'status'=>200,
            'schedule'=> $schedule,
            'message'=>'Added Successfully',
        ]);
    }
}
