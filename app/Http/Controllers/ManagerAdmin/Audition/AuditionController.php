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

use function PHPUnit\Framework\isEmpty;

class AuditionController extends Controller
{
    public function store(Request $request)
    {

        // dd($request->all());
        $auditionRule = AuditionRules::find($request->audition_rule_id);




        if ($auditionRule) {

            if ($auditionRule->jury_groups !== null) {
                $jurry_group = json_decode($auditionRule->jury_groups);
                $group_data = $jurry_group->{'group_members'};
            }

            if (isset($group_data)) {
                $jury_errors = '';
                foreach ($request->group_ids as $key => $group_id) {
                    if (count($request->jury[$key]) != $group_data[$key]) {
                        $jury_errors =$jury_errors."Opps.. You have to select " . $group_data[$key] . " jury for Group ".strtoupper(juryGroup($group_id))." !";
                    }
                }

                if ($jury_errors != '') {
                    session()->flash('error', $jury_errors);
                    return back();
                }
            }


            // dd($auditionRule->roundRules->count());
            $request->validate([
                'audition_admin_id' => 'required',
                'title' => 'required',
                'description' => 'required',
                'start_date' => 'required',
            ]);



            if ($auditionRule->judge_num != count($request->judge)) {
                session()->flash('error', 'Opps.. You have to select ' . $auditionRule->judge_num . ' judge !');
                return back();
            } else {
                if ($auditionRule->roundRules->count() == 0) {
                    session()->flash('error', 'Opps.. There is no round rules. Please add some round rules first');
                    return back();
                }
                $audition                       = new Audition();
                $audition->category_id          =  Auth::user()->category_id;
                $audition->audition_rules_id    = $request->audition_rule_id;
                $audition->audition_round_rules_id  = $auditionRule->roundRules->first()->id;
                $audition->creater_id           =  Auth::user()->id;
                $audition->audition_admin_id    =  $request->audition_admin_id;
                $audition->manager_admin_id     =  Auth::user()->id;
                $audition->title                =  $request->title;
                $audition->slug                 =  Str::slug($request->title);
                $audition->description          =  $request->description;
                $audition->round_status         =  0;
                $audition->start_time           =  Carbon::parse($request->start_date);
                $audition->end_time             =  Carbon::parse($request->start_date)->addDays($auditionRule->day)->addMonths($auditionRule->month);
                $audition->status               =  0;
                $audition->save();

                foreach ($request->judge as $key => $value) {
                    $auditionAssignJudge = new AuditionAssignJudge();
                    $auditionAssignJudge->judge_id          =  $value;
                    $auditionAssignJudge->audition_id       =    $audition->id;
                    $auditionAssignJudge->approved_by_judge = 0;
                    $auditionAssignJudge->save();
                }

                foreach ($request->group_ids as $key => $group_id) { // how many groups are allowed total_items
                    foreach ($request->jury[$key] as $jury) { // per groups jury assigne
                        $auditionAssignJury = new AuditionAssignJury();
                        $auditionAssignJury->audition_id           =  $audition->id;
                        $auditionAssignJury->jury_id               =  $jury;
                        $auditionAssignJury->approved_by_jury      =  0;
                        $auditionAssignJury->status                =   0;
                        $auditionAssignJury->save();
                    }
                }
                session()->flash('success', 'Audition added successfully !');
            }
        } else {
            session()->flash('error', 'Opps.. No audition rules found !');
        }
        return back();
    }
}
