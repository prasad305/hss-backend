<?php

namespace App\Http\Controllers\ManagerAdmin\Audition;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Audition\Audition;
use App\Models\Audition\AuditionAssignJudge;
use App\Models\Audition\AuditionAssignJury;
use App\Models\Audition\AuditionInfo;
use App\Models\Audition\AuditionParticipant;
use App\Models\Audition\AuditionRoundInfo;
use App\Models\Audition\AuditionRoundRule;
use App\Models\Audition\AuditionRules;
use App\Models\AuditionRoundInstruction;
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
            'jury' => 'required|array',
        ]);
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
                        $jury_errors = $jury_errors . "Opps.. You have to select " . $group_data[$key] . " jury for Group " . strtoupper(juryGroup($group_id)) . " !";
                    }
                }
                if ($jury_errors != '') {
                    session()->flash('error', $jury_errors);
                    return back();
                }
            }

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
                $auditionRule = AuditionRules::where('category_id', Auth::user()->category_id)->first();

                $audition_info = new AuditionInfo();
                $audition_info->audition_id = $audition->id;
                $audition_info->category_id = Auth::user()->category_id;
                $audition_info->round_num = $auditionRule->round_num;
                $audition_info->judge_num = $auditionRule->judge_num;
                $audition_info->jury_groups = $auditionRule->jury_groups;

                $audition_info->event_start_date = Carbon::parse($request->stat_date);
                $audition_info->event_end_date = Carbon::parse($request->stat_date)->addDays($auditionRule->event_period);

                $audition_info->instruction_prepare_start_date = Carbon::parse($request->stat_date);
                $audition_info->instruction_prepare_end_date = Carbon::parse($request->stat_date)->addDays($auditionRule->instruction_prepare_period);
                $audition_info->registration_start_date = Carbon::parse($audition_info->instruction_prepare_end_date)->addDays(1);
                $audition_info->registration_end_date = Carbon::parse($audition_info->registration_start_date)->addDays($auditionRule->registration_period);
                $audition_info->save();


                $auditionRoundRules = AuditionRoundRule::where('audition_rules_id', $auditionRule->id)->orderBy('round_num', 'ASC')->get();

                $roundStartDate = Carbon::parse($audition_info->registration_end_date)->addDays(1);
                foreach ($auditionRoundRules as $key => $auditionRoundRule) {
                    $auditionRoundInfo = new AuditionRoundInfo();
                    $auditionRoundInfo->audition_info_id = $audition_info->id;
                    $auditionRoundInfo->audition_id = $audition->id;
                    $auditionRoundInfo->round_num = $auditionRoundRule->round_num;
                    $auditionRoundInfo->has_jury_or_judge_mark =  $auditionRoundRule->has_jury_or_judge_mark;
                    $auditionRoundInfo->jury_or_judge_mark =  $auditionRoundRule->jury_or_judge_mark;
                    $auditionRoundInfo->has_user_vote_mark =  $auditionRoundRule->has_user_vote_mark;
                    $auditionRoundInfo->user_vote_mark =  $auditionRoundRule->user_vote_mark;
                    $auditionRoundInfo->mark_live_or_offline =  $auditionRoundRule->mark_live_or_offline;
                    $auditionRoundInfo->wildcard =  $auditionRoundRule->wildcard;
                    $auditionRoundInfo->wildcard_round =  $auditionRoundRule->wildcard_round;
                    $auditionRoundInfo->appeal =  $auditionRoundRule->appeal;
                    $auditionRoundInfo->video_feed =  $auditionRoundRule->video_feed;
                    $auditionRoundInfo->video_duration =  $auditionRoundRule->video_duration;
                    $auditionRoundInfo->video_slot_num =  $auditionRoundRule->video_slot_num;


                    $auditionRoundInfo->round_start_date =  $roundStartDate;
                    $auditionRoundInfo->round_end_date = Carbon::parse($roundStartDate)->addDays($auditionRoundRule->round_period);

                    $auditionRoundInfo->instruction_prepare_start_date = $auditionRoundInfo->round_start_date;
                    $auditionRoundInfo->instruction_prepare_end_date = Carbon::parse($auditionRoundInfo->instruction_prepare_start_date)->addDays($auditionRoundRule->instruction_prepare_period);

                    $auditionRoundInfo->video_upload_start_date = Carbon::parse($auditionRoundInfo->instruction_prepare_end_date)->addDays(1);
                    $auditionRoundInfo->video_upload_end_date = Carbon::parse($auditionRoundInfo->video_upload_start_date)->addDays($auditionRoundRule->video_upload_period);

                    $auditionRoundInfo->jury_or_judge_mark_start_date = Carbon::parse($auditionRoundInfo->video_upload_end_date)->addDays(1);
                    $auditionRoundInfo->jury_or_judge_mark_end_date = Carbon::parse($auditionRoundInfo->jury_or_judge_mark_start_date)->addDays($auditionRoundRule->jury_or_judge_mark_period);

                    $auditionRoundInfo->result_publish_start_date = Carbon::parse($auditionRoundInfo->jury_or_judge_mark_end_date)->addDays(1);
                    $auditionRoundInfo->result_publish_end_date = Carbon::parse($auditionRoundInfo->result_publish_start_date)->addDays($auditionRoundRule->result_publish_period);

                    $auditionRoundInfo->appeal_start_date = Carbon::parse($auditionRoundInfo->result_publish_end_date)->addDays(1);
                    $auditionRoundInfo->appeal_end_date = Carbon::parse($auditionRoundInfo->appeal_start_date)->addDays($auditionRoundRule->appeal_period);

                    $auditionRoundInfo->appeal_result_publish_start_date = Carbon::parse($auditionRoundInfo->appeal_end_date)->addDays(1);
                    $auditionRoundInfo->appeal_result_publish_end_date = Carbon::parse($auditionRoundInfo->appeal_result_publish_start_date)->addDays($auditionRoundRule->appeal_result_publish_period);

                    $auditionRoundInfo->save();

                    $roundStartDate = Carbon::parse($auditionRoundInfo->round_end_date)->addDays(1);
                }

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
                        $auditionAssignJury->group_id               =  $group_id;
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
        $subCategories = SubCategory::where([['category_id', auth()->user()->category_id], ['status', 1]])->orderBY('id', 'desc')->get();

        return view('ManagerAdmin.auditionAdmin.create', compact('auditionAdmins', 'subCategories'));
    }


    public function registerUser($audition_id){
        $audition = Audition::find($audition_id);

        $users = AuditionParticipant::where([['audition_id',$audition_id]])->get();

        return view('ManagerAdmin.audition.register_users',compact('audition','users'));

    }

    public function getRoundInstruction($audition_id,$round_info_id){
        $round_instruction =  AuditionRoundInstruction::where([['audition_id',$audition_id],['round_info_id',$round_info_id]])->first();
        return view('ManagerAdmin.audition.round_based_instruction',compact('round_instruction'));
    }

    public function roundInstructionPublished($instruction_id){
        $info = AuditionRoundInstruction::find($instruction_id);
        $info->send_to_user = 1;
        $info->save();

        session()->flash('success', 'Round Instruction Published Successfully!');
        return redirect()->back();
    }
}
