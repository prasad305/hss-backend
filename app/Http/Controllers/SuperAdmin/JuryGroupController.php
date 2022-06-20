<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\JuryGroup;
use Illuminate\Http\Request;

class JuryGroupController extends Controller
{

    public function index()
    {
        $data = [
            'groups' => JuryGroup::where('status', 1)->orderBy('id', 'desc')->get(),
        ];

        return view('SuperAdmin.juryGroups.index', $data);
    }


    public function create()
    {
        $data = [
            'categories' => Category::orderBy('id', 'desc')->get(),
        ];
        return view('SuperAdmin.juryGroups.create', $data);
    }


    public function store(Request $request)
    {
        $request->validate(
            [
                'category_id' => 'required',
                'name' => 'required',
            ],
            [
                'category_id.required' => 'Select a Category',
            ]
        );

        $juryGroup = new JuryGroup();
        $juryGroup->name = $request->name;
        $juryGroup->category_id = $request->category_id;

        try {
            $juryGroup->save();
            if ($juryGroup) {
                return response()->json([
                    'type' => 'success',
                    'message' => 'Jury Group Added Successfully'
                ]);
            }
        } catch (\Exception $exception) {
            return response()->json([
                'type' => 'error',
                'message' => 'Opps somthing went wrong. ' . $exception->getMessage(),
            ]);
        }
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {

        $data = [
            'categories' => Category::orderBy('id', 'desc')->get(),
            'group' => JuryGroup::find($id),
        ];
        return view('SuperAdmin.juryGroups.edit', $data);
    }


    public function update(Request $request, $id)
    {
        $request->validate(
            [
                'category_id' => 'required',
                'name' => 'required',
            ],
            [
                'category_id.required' => 'Select a Category',
            ]
        );

        $juryGroup = JuryGroup::find($id);
        $juryGroup->name = $request->name;
        $juryGroup->category_id = $request->category_id;

        try {
            $juryGroup->update();
            if ($juryGroup) {
                return response()->json([
                    'type' => 'success',
                    'message' => 'Jury Group Updated Successfully'
                ]);
            }
        } catch (\Exception $exception) {
            return response()->json([
                'type' => 'error',
                'message' => 'Opps somthing went wrong. ' . $exception->getMessage(),
            ]);
        }
    }


    public function destroy($id)
    {
        $group = JuryGroup::find($id);
        try {
            $group->delete();
            return response()->json([
                'type' => 'success',
                'message' => 'Successfully Deleted'
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'type' => 'error',
                'message' => $exception->getMessage()
            ]);
        }
    }
}
