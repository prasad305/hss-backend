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
                'jury_or_judge' => 'required',
                'jury_or_judge_mark' => 'required',
                'appeal' => 'required',
                'mark_live_or_offline' => 'required',
                'wildcard' => 'required',
                'video_feed' => 'required',
            ],
            [
                'jury_or_judge.required' => 'Select Jury Or Judge',
                'appeal.required' => 'Select Appeal Yes or No',
                'jury_or_judge_mark.required' => 'Mark is Required',
                'mark_live_or_offline.required' => 'Select Mark Offline or Live',
                'wildcard.required' => 'Select Wild Card Options Yes or No',
                'video_feed.required' => 'Select Video Feed Options Yes or No', 
            ]
        );

        $round = AuditionRoundRule::find($request->round_id);
        $round->user_vote_mark = $request->user_vote_mark;
        $round->jury_or_judge = $request->jury_or_judge;
        $round->jury_or_judge_mark = $request->jury_or_judge_mark;
        $round->mark_live_or_offline = $request->mark_live_or_offline;
        $round->wildcard = $request->wildcard;
        $round->wildcard_round = $request->wildcard_round;
        $round->appeal = $request->appeal;
        $round->video_feed = $request->video_feed;
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
        $rules = AuditionRoundRule::where('audition_rules_id',$mark->audition_rules_id)->get();

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
