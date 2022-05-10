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

        $round = AuditionRoundRule::find($request->round_id);
        $round->user_vote_mark = $request->user_vote_mark;
        $round->jury_mark = $request->jury_mark;
        $round->judge_mark = $request->judge_mark;
        $round->save();
        return response()->json([
            'status' => 'success',
            'message' => 'Round Rules Save Successfully'.$round
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

        return response()->json([
            'status' => 'success',
            'mark' => $mark
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
