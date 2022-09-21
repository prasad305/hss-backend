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
use App\Models\Audition\AuditionRoundMarkTracking;
use App\Models\Audition\AuditionRoundRule;
use App\Models\Audition\AuditionRules;
use App\Models\Audition\AuditionUploadVideo;
use App\Models\AuditionRoundInstruction;
use App\Models\Post;
use App\Models\JuryGroup;
use App\Models\SubCategory;
use App\Models\User;
use App\Models\WildCard;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Str;

use function PHPUnit\Framework\isEmpty;

class AuditionController extends Controller
{
    public function getParentUserIdById($id)
    {
        $user = User::find($id);
        return $user->parent_user;
    }
    public function store(Request $request)
    {

        // return date('Y-m-d',strtotime($request->end_date));
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'start_date' => 'required',
        ]);
        $auditionRule = AuditionRules::find($request->audition_rule_id);
        if ($auditionRule) {
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

            if (Audition::where('slug', Str::slug($request->input('title')))->exists()) {
                $audition->slug = Str::slug($request->input('title') . '-n');
            } else {
                $audition->slug = Str::slug($request->input('title'));
            }

            $audition->description          =  $request->description;
            $audition->round_status         =  0;
            $audition->start_date           =  Carbon::parse($request->start_date);
            $audition->end_date            =  date('Y-m-d', strtotime($request->end_date));
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
            $audition_info->event_start_date = Carbon::parse($request->start_date);
            $audition_info->event_end_date = date('Y-m-d', strtotime($request->end_date));
            // $audition_info->instruction_prepare_start_date = Carbon::parse($request->start_date);
            // $audition_info->instruction_prepare_end_date = Carbon::parse($request->instruction_prepare_start_date)->addDays($auditionRule->instruction_prepare_period);
            $audition_info->registration_start_date = Carbon::parse($audition_info->event_start_date);
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
                $auditionRoundInfo->round_type =  $auditionRoundRule->round_type;
                $auditionRoundInfo->wildcard_round =  $auditionRoundRule->wildcard_round;
                $auditionRoundInfo->appeal =  $auditionRoundRule->appeal;
                $auditionRoundInfo->video_feed =  $auditionRoundRule->video_feed;
                $auditionRoundInfo->video_duration =  $auditionRoundRule->video_duration;
                $auditionRoundInfo->video_slot_num =  $auditionRoundRule->video_slot_num;

                // $auditionRoundInfo->video_duration =  $auditionRoundRule->video_duration;
                $auditionRoundInfo->appeal_video_slot_num =  $auditionRoundRule->appeal_video_slot_num;

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

                $auditionRoundInfo->appeal_video_upload_start_date = Carbon::parse($auditionRoundInfo->appeal_end_date)->addDays(1);
                $auditionRoundInfo->appeal_video_upload_end_date = Carbon::parse($auditionRoundInfo->appeal_video_upload_start_date)->addDays($auditionRoundRule->appeal_video_upload_period);


                $auditionRoundInfo->appeal_jury_or_judge_mark_start_date = Carbon::parse($auditionRoundInfo->appeal_video_upload_end_date)->addDays(1);
                $auditionRoundInfo->appeal_jury_or_judge_mark_end_date = Carbon::parse($auditionRoundInfo->appeal_jury_or_judge_mark_start_date)->addDays($auditionRoundRule->appeal_jury_or_judge_mark_period);

                $auditionRoundInfo->appeal_result_publish_start_date = Carbon::parse($auditionRoundInfo->appeal_end_date)->addDays(1);
                $auditionRoundInfo->appeal_result_publish_end_date = Carbon::parse($auditionRoundInfo->appeal_result_publish_start_date)->addDays($auditionRoundRule->appeal_result_publish_period);


                $auditionRoundInfo->save();

                $roundStartDate = Carbon::parse($auditionRoundInfo->round_end_date)->addDays(1);

                // set first round as active round , by set active_round_info_id in audition table
                if ($key == 0) {
                    $audition->active_round_info_id = $auditionRoundInfo->id;
                    $audition->save();
                }
            }
            session()->flash('success', 'Audition added successfully !');
            return redirect()->route('managerAdmin.audition.events');
        } else {
            session()->flash('error', 'Opps.. No audition rules found !');
            return back();
        }
    }

    public function assignManpowerStore(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'audition_admin' => 'required|exists:users,id',
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
                if (count($request->jury) != count($request->group_ids)) {
                    session()->flash('error', 'You have to select jury for ' . count($request->group_ids) . ' group');
                    return back();
                }
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

                $audition                       = Audition::find($request->audition_id);
                $audition->audition_admin_id    =  $request->audition_admin;
                $audition->save();

                foreach ($request->judge as $key => $value) {
                    $auditionAssignJudge                    = new AuditionAssignJudge();
                    $auditionAssignJudge->judge_id          =  $value;
                    $auditionAssignJudge->judge_admin_id    =  $this->getParentUserIdById($value);
                    $auditionAssignJudge->audition_id       =    $audition->id;
                    $auditionAssignJudge->approved_by_judge = 0;
                    $auditionAssignJudge->save();
                }

                foreach ($request->group_ids as $key => $group_id) { // how many groups are allowed total_items
                    foreach ($request->jury[$key] as $jury) { // per groups jury assigne
                        $auditionAssignJury                        = new AuditionAssignJury();
                        $auditionAssignJury->audition_id           =  $audition->id;
                        $auditionAssignJury->jury_id               =  $jury;
                        $auditionAssignJury->group_id              =  $group_id;
                        $auditionAssignJury->approved_by_jury      =  0;
                        $auditionAssignJury->status                =   0;
                        $auditionAssignJury->save();
                    }
                }
                session()->flash('success', 'Man power assigned successfully !');
            }
        } else {
            session()->flash('error', 'Opps.. No audition rules found !');
        }
        return redirect()->route('managerAdmin.audition.events');
    }

    public function create()
    {
        $auditionAdmins = User::whereNotIn('id', Audition::pluck('audition_admin_id'))->where('user_type', 'audition-admin')->orderBy('id', 'DESC')->get();
        $subCategories = SubCategory::where([['category_id', auth()->user()->category_id], ['status', 1]])->orderBY('id', 'desc')->get();
        $auditionRule = AuditionRules::where('category_id', Auth::user()->category_id)->orderBy('id', 'DESC')->first();

        $auditionRoundRule = AuditionRoundRule::where([['audition_rules_id',   $auditionRule->id], ['status', 1]])->count();
        $auditionsStatus = Audition::where('category_id', auth()->user()->category_id)->first();
        $live = Audition::where([['manager_admin_id', auth()->user()->id], ['status', 3]])->count();
        $pending = Audition::where([['manager_admin_id', auth()->user()->id], ['status', 0]])->count();
        $request_approval_pending = Audition::where([['manager_admin_id', auth()->user()->id], ['status', 2]])->count();


        return view('ManagerAdmin.audition.create', compact('auditionAdmins', 'subCategories', 'auditionRule', 'auditionRoundRule', 'auditionsStatus', 'live', 'pending', 'request_approval_pending'));
    }

    public function assignManpower($audition_id)
    {
        $audition = Audition::find($audition_id);

        $auditionAdmins = User::whereDoesntHave('assignedAudition')->where([['user_type', 'audition-admin'], ['category_id', Auth::user()->category_id]])->orderBy('id', 'DESC')->get();
        $auditionRule = AuditionRules::where('category_id', Auth::user()->category_id)->orderBy('id', 'DESC')->first();
        if ($auditionRule->jury_groups !== null) {
            $jurry_group = json_decode($auditionRule->jury_groups);
            $group_data = $jurry_group->{'group_members'};
        }

        $auditionAssignJudges = AuditionAssignJudge::pluck('judge_id');
        // for not assigned judge
        $judges = User::whereNotIn('id', $auditionAssignJudges)->where('user_type', 'star')->where('category_id', Auth::user()->category_id)->orderBy('id', 'DESC')->get();

        $groups = JuryGroup::where([['status', 1], ['category_id', Auth::user()->category_id]])->orderBy('name', 'asc')->get();

        $auditionAssignJurys = AuditionAssignJury::pluck('jury_id');
        // for not assigned juries
        $juries = User::whereNotIn('id', $auditionAssignJurys)
            ->where('user_type', 'jury')
            ->where('category_id', Auth::user()->category_id)
            ->orderBy('id', 'DESC')
            ->get();
        $live = Audition::where([['manager_admin_id', auth()->user()->id], ['status', 3]])->count();
        $pending = Audition::where([['manager_admin_id', auth()->user()->id], ['status', 0]])->count();
        $request_approval_pending = Audition::where([['manager_admin_id', auth()->user()->id], ['status', 2]])->count();

        $data = [
            'auditionAdmins' => $auditionAdmins,
            'audition' => $audition,
            'juries' => $juries,
            'judges' => $judges,
            'auditionRule' => $auditionRule,
            'groups' => $groups,
            'group_data' => isset($group_data) && count($group_data) > 0 ? $group_data : null,
            'live' => $live,
            'pending' => $pending,
            'request_approval_pending' => $request_approval_pending,
        ];

        return view('ManagerAdmin.Audition.assign-manpower', $data);
    }


    public function pending()
    {
        $audition = Audition::where('status', 2)->orderBy('updated_at', 'desc')->get();
        return view('ManagerAdmin.Audition.index', compact('audition'));
    }


    public function details($id)
    {
        $audition = Audition::find($id);
        $judges = AuditionAssignJudge::where('audition_id', $audition->id)->get();
        return view('ManagerAdmin.Audition.details')->with('audition', $audition)->with('judges', $judges);
    }

    public function manager_audition_set_publish(Request $request, $audition_id)
    {
        $audition = Audition::find($audition_id);

        if ($audition->status != 3) {
            $request->validate([
                'post_start_date' => 'required',
                'post_end_date' => 'required',
            ]);
            $audition->status = 3;
            $audition->update();

            $judges = [];

            foreach ($audition->assignedJudges as $key => $judge) {
                array_push($judges, $judge->id);
            }

            //    return $audition->star;

            // Create New post //
            $post = new Post();
            $post->type = 'audition';
            $post->event_id = $audition->id;
            $post->star_id = json_encode($judges);
            $post->category_id = $audition->category_id;
            // $post->sub_category_id = $audition->sub_category_id;
            $post->post_start_date = Carbon::parse($request->post_start_date);
            $post->post_end_date = Carbon::parse($request->post_end_date);
            $post->user_like_id = '[]';
            $post->react_provider = '[]';
            $post->save();
            return redirect()->back()->with('success', 'Published');
        } else {
            //$audition->manager_approval = 0;
            $audition->status = 2;
            $audition->update();

            //Remove post //
            $post = Post::where([['event_id', $audition->id], ['type', 'audition']])->first();
            $post->delete();
            return redirect()->back()->with('error', 'Unpublished');
        }
    }


    public function published()
    {
        $audition = Audition::where('status', 3)->latest()->get();
        return view('ManagerAdmin.Audition.index', compact('audition'));
    }


    public function registerUser($audition_id)
    {

        $audition = Audition::find($audition_id);

        $users = AuditionParticipant::where([['audition_id', $audition_id]])->get();

        return view('ManagerAdmin.audition.register_users', compact('audition', 'users'));
    }

    public function getResultByRound($audition_id, $round_info_id, $type)
    {
        // return '---audition_id-'.$audition_id.'---round_info_id-'.$round_info_id.'-----type-'.$type;
        $audition = Audition::find($audition_id);
        $round_result =  AuditionRoundInfo::with(['videos' => function ($query) use ($round_info_id, $type) {
            return $query->where([['round_info_id', $round_info_id], ['approval_status', 1], ['type', $type]])->get();
        }])->where([['id', $round_info_id], ['audition_id', $audition_id]])
            ->first();

        $wining_users = AuditionRoundMarkTracking::where([
            ['audition_id', $audition_id],
            ['round_info_id', $round_info_id],
            ['type', $type],
            ['wining_status', 1]
        ])->get();

        $failed_users = AuditionRoundMarkTracking::where([
            ['audition_id', $audition_id],
            ['round_info_id', $round_info_id],
            ['type', $type],
            ['wining_status', 0]
        ])->get();

        $data = [
            'audition' => $audition,
            'round_result' => $round_result,
            'wining_users' => $wining_users,
            'failed_users' => $failed_users,
            'type' => $type,
        ];

        return view('ManagerAdmin.audition.view_round_result', $data);
    }

    public function roundResultPublish(Request $request)
    {
        $audition_id = $request->audition_id;
        $round_info_id = $request->round_info_id;
        $type = $request->type;

        $auditionRoundInfo = AuditionRoundInfo::with('wildcardRoundRuleId')->where([['audition_id', $request->audition_id], ['id', $request->round_info_id]])->first();


        if ($auditionRoundInfo->wildcard == 1) {
            $wildcardInfo = AuditionRoundInfo::where([['audition_id', $request->audition_id], ['round_num', $auditionRoundInfo->wildcardRoundRuleId->round_num]])->first();
            $wildcard = new WildCard();
            $wildcard->audition_id = $request->audition_id;
            $wildcard->start_round_info_id = $auditionRoundInfo->id;
            $wildcard->start_round_num = $auditionRoundInfo->round_num;
            $wildcard->end_round_info_id = $wildcardInfo->id - 1;
            $wildcard->end_round_num = $wildcardInfo->round_num - 1;
            $wildcard->status = 1;
            $wildcard->save();
        } else {
            AuditionRoundInfo::where('id', $auditionRoundInfo->id)->update(['status' => 2]);
        }

        AuditionRoundMarkTracking::where([
            ['audition_id', $audition_id],
            ['round_info_id', $round_info_id],
            ['type', $type],
            ['wining_status', 1]
        ])->update([
            'result_message' => $request->selected_comments,
        ]);
        AuditionRoundMarkTracking::where([
            ['audition_id', $audition_id],
            ['round_info_id', $round_info_id],
            ['type', 'wildcard'],
            ['wining_status', 1]
        ])->update([
            'result_message' => "You are selected via Wildcard",
        ]);
        if (WildCard::where([
            ['audition_id', $audition_id],
            ['end_round_info_id', $round_info_id],
        ])->exists()) {
            WildCard::where([
                ['audition_id', $audition_id],
                ['end_round_info_id', $round_info_id],
            ])->update([
                'status' => 3,
            ]);
        }
        AuditionRoundMarkTracking::where([['audition_id', $audition_id], ['round_info_id', $round_info_id],])->update([
            'result_message' => "You are selected via Wildcard",
        ]);

        if ($type == 'general') {
            AuditionRoundInfo::where('id', $round_info_id)->update([
                'manager_status' => 2,
            ]);
        } else {
            AuditionRoundInfo::where('id', $round_info_id)->update([
                'appeal_manager_status' => 2,
            ]);
        }

        session()->flash('success', 'Result Publish Done!');
        return redirect()->back();
    }

    public function getRoundInstruction($audition_id, $round_info_id)
    {
        $round_instruction =  AuditionRoundInstruction::where([['audition_id', $audition_id], ['round_info_id', $round_info_id]])->first();
        return view('ManagerAdmin.audition.round_based_instruction', compact('round_instruction'));
    }

    public function roundInstructionPublished($instruction_id)
    {
        $info = AuditionRoundInstruction::find($instruction_id);
        $info->send_to_user = 1;
        $info->save();

        session()->flash('success', 'Round Instruction Published Successfully!');
        return redirect()->back();
    }

    public function videoFeed()
    {
        $auditions = Audition::where('category_id', auth()->user()->category_id)->get();
        return view('ManagerAdmin.Audition.videoFeed', compact('auditions'));
    }
    public function videoFeedList($round_info_id)
    {
        //      Work in progress 

        $generalMarkTraking = AuditionRoundMarkTracking::where('round_info_id', $round_info_id)->where([['wining_status', 0], ['type', 'general']])->pluck('user_id')->toArray();
        $appealMarkTraking = AuditionRoundMarkTracking::where('round_info_id', $round_info_id)->where([['wining_status', 0], ['type', 'appeal']])->pluck('user_id')->toArray();
        // $generalWiningTracking = AuditionRoundMarkTracking::where('round_info_id', $round_info_id)->where([['wining_status', 1], ['type', 'general']])->pluck('user_id')->toArray();
        $appealWinningTracking = AuditionRoundMarkTracking::where('round_info_id', $round_info_id)->where([['wining_status', 1], ['type', 'appeal']])->pluck('user_id')->toArray();

        $notAppealedGeneralVideos = AuditionRoundInfo::with(['videos' => function ($q) use ($generalMarkTraking, $appealMarkTraking, $round_info_id, $appealWinningTracking) {
            return $q->where([['approval_status', 1], ['round_info_id', $round_info_id], ['type', 'general']])->whereNotIn('user_id', $appealMarkTraking)->whereNotIn('user_id', $appealWinningTracking)->whereIn('user_id', $generalMarkTraking)->get();
        }])->where([['id', $round_info_id], ['wildcard', 1], ['videofeed_status', 0], ['round_type', 0]])->first();


        $appealedGeneralVideos = AuditionRoundInfo::with(['videos' => function ($q) use ($appealMarkTraking, $round_info_id) {
            return $q->where([['approval_status', 1], ['round_info_id', $round_info_id], ['type', 'appeal']])->whereIn('user_id', $appealMarkTraking)->get();
        }])->where([['id', $round_info_id], ['wildcard', 1], ['videofeed_status', 0], ['round_type', 0]])->first();

        return view('ManagerAdmin.Audition.videoFeedList', compact('notAppealedGeneralVideos', 'appealedGeneralVideos'));
    }
    public function videoPublishedToVideofeed($round_info_id)
    {
        $published = AuditionRoundInfo::where('id', $round_info_id)->update([
            'videofeed_status' => 1
        ]);
        if ($published) {
            session()->flash('success', 'Video Published To Video Feed!');
            return redirect()->back();
        }
    }
}
