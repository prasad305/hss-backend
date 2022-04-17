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
    
    public function index()
    {
        $data = [
            'rules' => AuditionRules::where('status',1)->get(),
        ];
        return view('SuperAdmin.AuditionRules.index',$data);
    }

   
    public function create()
    {
        $data = [
            'categories' => Category::where('status',1)->orderBy('id', 'DESC')->get(),
        ];
        return view('SuperAdmin.AuditionRules.create',$data);
    }

    
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
            'message' => 'Rules Created Successfully!',
        ]);
    }

  
    public function show($id)
    {
        //
    }

 
    public function edit($id)
    {
        $data = [
            'rules' => AuditionRules::find($id),
            'categories' => Category::where('status',1)->orderBy('id', 'DESC')->get(),
        ];
        return view('SuperAdmin.AuditionRules.edit',$data);
    }

   
    public function update(Request $request, $id)
    {
        // return $request->all();
        $request->validate([
            'category_id' => 'required',
            'round_num' => 'required',
            'judge_num' => 'required',
            'jury_num' => 'required',
            'month' => 'required',
            'day' => 'required',
        ]);

      $audition_rules = AuditionRules::find($id);
      $audition_rules->fill($request->all());
      $audition_rules->save();
        return response()->json([
            'status' => 'success',
            'message' => 'Rules Updated Successfully!',
        ]);
    }

   
    public function destroy($id)
    {
        //
    }
}
