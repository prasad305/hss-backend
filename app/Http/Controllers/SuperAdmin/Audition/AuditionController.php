<?php

namespace App\Http\Controllers\SuperAdmin\Audition;

use App\Http\Controllers\Controller;
use App\Models\Audition\Audition;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AuditionController extends Controller
{

    public function index()
    {
        $auditions = Audition::orderBy('id', 'DESC')->get();

        return view('SuperAdmin.audition.index', compact('auditions'));
    }


    public function create()
    {
        $categories = Category::orderBy('id', 'DESC')->get();
        return view('SuperAdmin.audition.create', compact('categories'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'category' => 'required',

        ]);

        $audition = new Audition();

        $audition->title = $request->input('name');
        $audition->category_id = $request->input('category');
        $audition->slug = Str::slug($request->input('name'));

        try {
            $audition->save();
            return response()->json([
                'type' => 'success',
                'message' => 'Audition created successfully',
            ]);
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
        $categories = Category::orderBy('id', 'DESC')->get();
        $audition = Audition::find($id);
        return view('SuperAdmin.audition.edit', compact('audition', 'categories'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'category' => 'required',
        ]);

        $audition = Audition::find($id);

        $audition->title = $request->input('name');
        $audition->category_id = $request->input('category');
        $audition->slug = Str::slug($request->input('name'));

        try {
            $audition->save();
            return response()->json([
                'type' => 'success',
                'message' => 'Audition update successfully',
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'type' => 'error',
                'message' => 'Opps somthing went wrong. ' . $exception->getMessage(),
            ]);
        }
    }



    public function setMark($id)
    {
        $audition = Audition::find($id);
        return view('SuperAdmin.audition.setMark', compact('audition'));
    }

    public function setMarkUpdate(Request $request, $id)
    {
        $request->validate([
            'setJuryMark' => 'required',
            'setJudgeMark' => 'required',
        ]);

        $audition = Audition::find($id);

        $audition->setJuryMark = $request->input('setJuryMark');
        $audition->setJudgeMark = $request->input('setJudgeMark');

        try {
            $audition->save();
            return response()->json([
                'type' => 'success',
                'message' => 'Audition Mark Set Successfully',
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'type' => 'error',
                'message' => 'Opps somthing went wrong. ' . $exception->getMessage(),
            ]);
        }
    }


    public function destroy($id)
    {
        $audition = Audition::findOrfail($id);
        try {
            $audition->delete();
            return response()->json([
                'type' => 'success',
                'message' => 'Successfully Deleted !!',
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'type' => 'error',
                'message' => 'error' . $exception->getMessage(),
            ]);
        }
    }
}
