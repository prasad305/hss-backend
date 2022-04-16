<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Audition\AuditionRules;
use Illuminate\Http\Request;

use function PHPUnit\Framework\returnSelf;
use App\Models\Category;
use Carbon\Carbon;

class AuditionRulesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('SuperAdmin.AuditionRules.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // return $dateS = Carbon::now()->addMonth(5)->addDays(10);
        $data = [
            'categories' => Category::where('status',1)->orderBy('id', 'DESC')->get(),
        ];
        return view('SuperAdmin.AuditionRules.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required',
            'round_num' => 'required',
            'judge_num' => 'required',
            'jury_num' => 'required',
            'month' => 'required',
            'day' => 'required',
        ]);

      $audition_rules = new  AuditionRules();
      $audition_rules->fill($request->all());
      $audition_rules->save();
        return response()->json([
            'status' => 'success',
            'message' => 'Rules Created Successfullly!',
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('SuperAdmin.AuditionRules.edit');
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
