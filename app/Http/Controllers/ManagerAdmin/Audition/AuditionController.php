<?php

namespace App\Http\Controllers\ManagerAdmin\Audition;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Audition\Audition;
use App\Models\Audition\AuditionAssignJudge;
use App\Models\Audition\AuditionAssignJury;
use App\Models\Audition\AuditionInfo;
use App\Models\Audition\AuditionRules;
use App\Models\SubCategory;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Str;

use function PHPUnit\Framework\isEmpty;

class AuditionController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'audition_admin_id' => 'required',
            'title' => 'required',
            'description' => 'required',
            'start_date' => 'required',
        ]);

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


                //setup audition info from general audition rule
                $general_audition_info = AuditionRules::where('category_id',Auth::user()->category_id)->first();

                $audition_info = new AuditionInfo();
                $audition_info->audition_id = $audition->id;
                $audition_info->category_id = Auth::user()->category_id;
                $audition_info->round_num = $general_audition_info->round_num;
                $audition_info->judge_num = $general_audition_info->judge_num;
                $audition_info->jury_groups = $general_audition_info->jury_groups;
                $audition_info->start_date =Carbon::parse( $request->stat_date);
                $audition_info->end_date = Carbon::parse($request->end_date);
                $audition_info->save();


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


    public function create()
    {
        $auditionAdmins = User::whereNotIn('id', Audition::pluck('audition_admin_id'))->where('user_type', 'audition-admin')->orderBy('id', 'DESC')->get();
        $subCategories = SubCategory::where([['category_id',auth()->user()->category_id],['status',1]])->orderBY('id','desc')->get();

        return view('ManagerAdmin.auditionAdmin.create', compact('auditionAdmins','subCategories'));
    }
}
