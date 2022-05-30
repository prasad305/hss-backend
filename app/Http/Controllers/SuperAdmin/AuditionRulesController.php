<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Audition\AuditionRoundRule;
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
            'rules' => AuditionRules::where('status', 1)->latest()->get(),
        ];
        return view('SuperAdmin.AuditionRules.index', $data);
    }


    public function create()
    {
        $data = [
            'categories' => Category::where('status', 1)->orderBy('id', 'DESC')->get(),
            'rules' => AuditionRules::where('status', 1)->latest()->get(),
        ];
        return view('SuperAdmin.AuditionRules.create', $data);
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

        $audition_rules = AuditionRules::where('category_id', $request->category_id)->first();
        $previous_round_num = (int)$audition_rules->round_num;
        $new_round_num = $request->round_num;
        $diff = $new_round_num - $previous_round_num;
        // return abs($diff);


        $audition_rules->fill($request->all());
        $audition_rules->save();


            if ($diff > 0) {
                for ($i = 0; $i < $diff; $i++) {
                    AuditionRoundRule::create([
                        'audition_rules_id' => $audition_rules->id,
                    ]);
                }
            }

            if ($diff < 0) {

              AuditionRoundRule::where('audition_rules_id',$audition_rules->id)->orderBy('id', 'desc')->take(abs($diff))->delete();

            }




        return response()->json([
            'status' => 'success',
            'message' => 'Rules Updated Successfully!',
        ]);
    }





    public function show($id)
    {
        // return $id;
        $rules = AuditionRules::where('category_id', $id)->first();
        return response()->json([
            'status' => 'success',
            'rules' => $rules,
        ]);
    }


    public function edit($id)
    {
        $data = [
            'rules' => AuditionRules::find($id),
            'categories' => Category::where('status', 1)->orderBy('id', 'DESC')->get(),
        ];
        return view('SuperAdmin.AuditionRules.edit', $data);
    }


    public function update(Request $request, $id)
    {

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
