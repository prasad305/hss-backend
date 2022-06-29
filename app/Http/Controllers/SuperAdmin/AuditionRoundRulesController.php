<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Audition\AuditionRoundRule;
use App\Models\Audition\AuditionRules;
use App\Models\Category;
use Illuminate\Http\Request;

class AuditionRoundRulesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'categories' => Category::where('status', 1)->latest()->get(),
            'rules_categories' => AuditionRules::with('category')->where('status', 1)->latest()->get(),
        ];
        return view('SuperAdmin.AuditionRoundRules.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request->all();

        $request->validate(
            [
                'has_jury_or_judge_mark' => 'required',
                'jury_or_judge_mark' => 'required',
                'appeal' => 'required',
                'mark_live_or_offline' => 'required_if:user_vote_mark,1',
                'wildcard' => 'required',
                'video_feed' => 'required',
                'video_duration' => 'required',
                'round_period' => 'required',
                'instruction_prepare_period' => 'required',
                'video_upload_period' => 'required',
                'jury_or_judge_mark_period' => 'required',
                'result_publish_period' => 'required',
                'appeal_period' => 'required',
                'appeal_result_publish_period' => 'required',
            ],
            [
                'has_jury_or_judge_mark.required' => 'Select Jury Or Judge',
                'appeal.required' => 'Select Appeal Yes or No',
                'jury_or_judge_mark.required' => 'Mark is Required',
                'mark_live_or_offline.required_if' => 'Select Mark Offline or Live',
                'wildcard.required' => 'Select Wild Card Options Yes or No',
                'video_feed.required' => 'Select Video Feed Options Yes or No',
            ]
        );

        $round = AuditionRoundRule::find($request->round_id);
       
        $round->has_user_vote_mark = $request->has_user_vote_mark;

        if ($request->has_user_vote_mark == 1) {
            $round->mark_live_or_offline = $request->mark_live_or_offline;
            $round->user_vote_mark = $request->user_vote_mark;
        }else{
            $round->mark_live_or_offline = null;
            $round->user_vote_mark = null;
        }

        $round->has_jury_or_judge_mark = $request->has_jury_or_judge_mark;
        $round->jury_or_judge_mark = $request->jury_or_judge_mark;

        $round->wildcard = $request->wildcard;
        if ($request->wildcard == 1) {
            $round->wildcard_round = $request->wildcard_round;
        }else{
            $round->wildcard_round = null;
        }
        $round->appeal = $request->appeal;
        $round->video_feed = $request->video_feed;

        $round->video_duration = $request->video_duration;
        $round->round_period = $request->round_period;
        $round->instruction_prepare_period = $request->instruction_prepare_period;
        $round->video_upload_period = $request->video_upload_period;
        $round->jury_or_judge_mark_period = $request->jury_or_judge_mark_period;
        $round->result_publish_period = $request->result_publish_period;
        $round->appeal_period = $request->appeal_period;
        $round->appeal_result_publish_period = $request->appeal_result_publish_period;
        $round->save();
        return response()->json([
            'status' => 'success',
            'message' => 'Round Rules Save Successfully'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $round_rules = AuditionRoundRule::where('audition_rules_id', $id)->get();

        return response()->json([
            'status' => 'success',
            'round_rules' => $round_rules
        ]);
    }
    public function getMark($id)
    {
        $mark = AuditionRoundRule::find($id);
        $rules = AuditionRoundRule::where('audition_rules_id', $mark->audition_rules_id)->get();

        return response()->json([
            'status' => 'success',
            'mark' => $mark,
            'rules' => $rules,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
