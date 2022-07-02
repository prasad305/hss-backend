<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Audition\AuditionRoundRule;
use App\Models\Audition\AuditionRules;
use Illuminate\Http\Request;

use function PHPUnit\Framework\returnSelf;
use App\Models\Category;
use App\Models\JuryGroup;
use Carbon\Carbon;
use JetBrains\PhpStorm\Pure;
use PHPUnit\TextUI\XmlConfiguration\Group;

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
            'categories' => Category::orderBy('id', 'DESC')->get(),
            'rules' => AuditionRules::latest()->get(),
        ];
        return view('SuperAdmin.AuditionRules.create', $data);
    }


    public function store(Request $request)
    {
        // return $request->all();  
        $request->validate([
            'category_id' => 'required',
            'round_num' => 'required',
            'event_period' => 'required',
            'registration_period' => 'required',
            'instruction_prepare_period' => 'required',
        ]);
        // return $request->all();

        $audition_rules = AuditionRules::where('category_id', $request->category_id)->first();
        $previous_round_num = (int)$audition_rules->round_num;
        $new_round_num = $request->round_num;
        $diff = $new_round_num - $previous_round_num;


        $audition_rules->fill($request->except(['groups_id','group_members']));

        $jury_group_array=array(
            'groups_id' => $request->groups_id,
            'group_members' => $request->group_members,
        );
       
        $audition_rules->jury_groups = json_encode($jury_group_array); 

        $audition_rules->save();


            if ($diff > 0) {
                for ($i = 0; $i < $diff; $i++) {
                    AuditionRoundRule::create([
                        'round_num' => $i+1,
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
        $rules = AuditionRules::where('category_id', $id)->first();
  
        return response()->json([
            'status' => 'success',
            'rules' => $rules, 
        ]);
    }


    public function edit($id)
    {
        $rule = AuditionRules::find($id);


        if ($rule->jury_groups !== null) {
            $jurry_group = json_decode($rule->jury_groups);
             $group_data = $jurry_group->{'group_members'};
        }

        $data = [
            'rule' => $rule,
            'rules' =>  AuditionRules::where('status', 1)->latest()->get(),
            'categories' => Category::orderBy('id', 'DESC')->get(),
            'groups' => JuryGroup::where([['status', 1],['category_id',$rule->category_id]])->orderBy('name', 'asc')->get(),
            'group_data' =>  isset($group_data) && count($group_data) > 0 ? $group_data : null ,  
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
