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
        
        $undeleteable_ids = [];
        foreach ($request->all() as $key => $req) {
            if (isset($req['id'] ) && $req['id'] !=null) {
                array_push($undeleteable_ids, $req['id']);
            }
        }
        // delete previous schedule
        Schedule::whereNotIn('id', $undeleteable_ids)->where('date', $request->{'0'}['date'])->delete();

        foreach ($request->all() as $key => $req) {

            if (isset($req['id'])) {
                Schedule::where('id', $req['id'])->update([
                    'event_type' => $req['event_type'],
                    'from' => $req['from'],
                    'to' => $req['to'],
                    'date' => $req['date'],
                ]);
            } else {
               
                if ($req['from'] == null || $req['from'] == '' && $req['to'] == null || $req['to'] == '' && $req['event_type'] == null || $req['event_type'] == '') {
                    return response()->json([
                        'status' => 422,
                        'message' => 'Please fill all the field and try again',
                    ]);
                } else {
                    $admin = User::where('parent_user',auth()->user()->parent_user)->first();
                    Schedule::insert([
                        'admin_id' => auth('sanctum')->user()->parent_user,
                        'event_type' => $req['event_type'],
                        'star_id' => auth('sanctum')->user()->id,
                        'from' => $req['from'],
                        'to' => $req['to'],
                        'date' => $req['date'],
                        'month' => Carbon::parse($req['date'])->format('M'),
                    ]); 
                }
            }
        }

        return response()->json([
            'status' => 200,
            // 'result'=> $request->all(),
            'message' => 'Schedule Added Successfully',
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

    public function current_month_schedule_list()
    {

        $schedule = Schedule::select(['event_type as title','date as startDate','from','to' , 'id'])->whereBetween('date',
        [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->where('star_id',auth('sanctum')->user()->id)->get();

        return response()->json([
            'status'=>200,
            'schedule'=> $schedule,
            'message'=>'Added Successfully',
        ]);
    }

    public function notification()
    {

        $schedules = Schedule::where([['star_id',auth('sanctum')->user()->id],['status',0]])
                            ->whereColumn('remainder_date', '<=', 'date')
                            ->get(); 


        return response()->json([
            'status' => 200,
            'schedules' => $schedules,
        ]);
    }
    public function deleteSchedule($id){
        $schedule = Schedule::where('id', $id)->delete();
        if($schedule){
            return response()->json([
                'status'=>200,
                'message'=>'Deleted',
            ]);
        }
    }
    public function addSchedule(Request $request){

        $schedule = new Schedule();
        $schedule->admin_id = auth('sanctum')->user()->parent_user;
        $schedule->star_id = auth('sanctum')->user()->id;
        $schedule->event_type = $request->input('eventType');
        $schedule->from = Carbon::parse($request->input('startTime'));
        $schedule->to = Carbon::parse($request->input('endTime'));
        $schedule->date = Carbon::parse($request->input('event_date'));
        $schedule->month = Carbon::parse($request['eventDate'])->format('M');
        $schedule->save();

        if($schedule){
            return response()->json([
                'status' => 200,
                'message' => 'Schedule Added Successfully',
            ]);
        }
        
    }
}
