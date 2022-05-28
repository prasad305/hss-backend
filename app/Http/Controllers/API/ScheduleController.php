<?php

namespace App\Http\Controllers\API;

use Carbon\Carbon;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Schedule;
use App\Models\User;

class ScheduleController extends Controller
{
    //
    public function add_schedule(Request $request)
    {
        // return $request->all();

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
                    Schedule::insert([
                        'admin_id' => auth('sanctum')->user()->id,
                        'event_type' => $req['event_type'],
                        'star_id' => auth('sanctum')->user()->star->id,
                        'from' => $req['from'],
                        'to' => $req['to'],
                        'date' => $req['date'],
                        'month' => Carbon::parse($req['date'])->format('M'),
                        'updated_at' => date("Y-m-d h:i:s"),
                        'created_at' => date("Y-m-d h:i:s"),
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
            array_push($date, $value['date']);
        }


        return response()->json([
            'status' => 200,
            'schedule' => $date,
            'message' => 'Added Successfully',
        ]);
    }

    public function dateWiseSchedule($date)
    {
        $schedule = Schedule::where([['admin_id', auth('sanctum')->user()->id], ['date', $date]])->get();
        return response()->json([
            'status' => 200,
            'schedule' => $schedule,
        ]);
    }

    public function schedule_list()
    {
        $schedule = Schedule::select('date', 'status')->distinct()->where('admin_id', auth('sanctum')->user()->id)->orderBy('date', 'DESC')->get();

        // $date = [];
        // foreach ($schedule as $key => $value) {
        //     array_push($date,$value['date']);
        // }


        return response()->json([
            'status' => 200,
            'schedule' => $schedule,
            'message' => 'Added Successfully',
        ]);
    }

    public function current_year_schedule_list()
    {

        $schedule = Schedule::select(['event_type as title', 'date as startDate', 'from', 'to'])->whereBetween(
            'date',
            [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]
        )->where('admin_id', auth('sanctum')->user()->id)->get();

        return response()->json([
            'status' => 200,
            'schedule' => $schedule,
            'message' => 'Added Successfully',
        ]);
    }
}
