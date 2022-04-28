<?php

namespace App\Http\Controllers\ManagerAdmin\Audition;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Audition\Audition;
use App\Models\Audition\AuditionAssignJudge;
use App\Models\Audition\AuditionAssignJury;
use App\Models\Audition\AuditionRules;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Str;


class AuditionController extends Controller
{
    public function store(Request $request){

        $auditionRule = AuditionRules::find($request->audition_rule_id);
        if($auditionRule){
            $request->validate([
                'audition_admin_id' => 'required',
                'title' => 'required',
                'description' => 'required',
                'start_date' => 'required',
            ]);
            if($auditionRule->jury_num != count($request->jury)){
                session()->flash('error', 'Opps.. You have to select '.$auditionRule->jury_num.' jury !');
                return back();
            }elseif($auditionRule->judge_num != count($request->judge)){
                session()->flash('error', 'Opps.. You have to select '.$auditionRule->judge_num.' judge !');
                return back();
            }else{
                $audition                       = new Audition();
                $audition->category_id          = Auth::user()->category_id;
                $audition->audition_rules_id    = $request->audition_rule_id;
                $audition->creater_id           = Auth::user()->id;
                $audition->audition_admin_id    =  $request->audition_admin_id;
                $audition->manager_admin_id     =  Auth::user()->id;
                $audition->title                =  $request->title;
                $audition->slug                 =  Str::slug($request->title);
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
                foreach ($request->jury as $key => $value) {
                    $auditionAssignJury = new AuditionAssignJury();
                    $auditionAssignJury->audition_id           =  $audition->id;
                    $auditionAssignJury->jury_id               =  $value;
                    $auditionAssignJury->approved_by_jury      =  0;
                    $auditionAssignJury->status                =   0;
                    $auditionAssignJury->save();
                }
                session()->flash('success', 'Audition added successfully !');
            }
        }else{
            session()->flash('error', 'Opps.. No audition rules found !');
        }
        return back();
    }
}
