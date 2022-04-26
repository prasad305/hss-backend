<?php

namespace App\Http\Controllers\ManagerAdmin\Audition;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Audition\Audition;
use App\Models\Audition\AuditionAssignJudge;
use App\Models\Audition\AuditionAssignJury;
use App\Models\Audition\AuditionRules;

class AuditionController extends Controller
{
    public function store(Request $request){

        $auditionRule = AuditionRules::find($request->audition_rule_id);
        if($auditionRule){

            // dd($auditionRule);
            // return $auditionRule->jury_num."------------".$auditionRule->judge_num;
            $request->validate([
                'admin_id' => 'required',
                'admin_name' => 'required',
                'job_type' => 'required',
                'title' => 'required',
                'description' => 'required',
                // 'jury' => 'required|array|min:' .$auditionRule->jury_num. '|max:'.$auditionRule->jury_num.',

                // 'judge' => 'required|array|min:' .$auditionRule->judge_num. '|max:'.$auditionRule->judge_num.',

                // 'judge' => "required|array|min:" .$auditionRule->judge_num. '|max:'.$auditionRule->judge_num.'",
                // 'jury' => "required|array|min:".$auditionRule->jury_num."|max:".$auditionRule->jury_num.",
                // 'judge' => "required|array|min:".$auditionRule->judge_num."|max:".$auditionRule->judge_num.",
                'start_date' => 'required',
            ]);

            $audition                       = new Audition();
            $audition->category_id          = Auth::user()->category_id;
            $audition->audition_rules_id    = $request->audition_rule_id;
            $audition->creater_id           = Auth::user()->id;
            $audition->audition_admin_id    =  $request->audition_admin_id;
            $audition->manager_admin_id     =  Auth::user()->id;
            $audition->title                =  $request->title;
            $audition->slug                 =  $request->title;
            $audition->description          =  $request->description;

            $audition->round_status         =  0;
            $audition->start_time           =  Carbon::parse($request->start_date);
            $audition->end_time           =  Carbon::parse($request->start_date)->addDays($auditionRule->day)->addMonths($auditionRule->month);
            $audition->status               =  0;
            $audition->save();

            foreach ($request->judge as $key => $value) {
                $auditionAssignJudge = new AuditionAssignJudge();
                $auditionAssignJudge->judge_id          =  $value;
                $auditionAssignJudge->audition_id       =    $audition->id;
                $auditionAssignJudge->approved_by_judge = 0;
                $auditionAssignJudge->save();
            }
            foreach ($request->judge as $key => $value) {
                $auditionAssignJury = new AuditionAssignJury();
                $auditionAssignJury->audition_id           =  $audition->id;
                $auditionAssignJury->jury_id               =  $value;
                $auditionAssignJury->approved_by_jury      =  0;
                $auditionAssignJury->status                =   0;
                $auditionAssignJury->save();
            }
        }else{

        }

    }
}
