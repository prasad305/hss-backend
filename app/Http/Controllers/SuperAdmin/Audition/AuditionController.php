<?php

namespace App\Http\Controllers\SuperAdmin\Audition;

use App\Http\Controllers\Controller;
use App\Models\Audition\Audition;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AuditionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $auditions = Audition::orderBy('id', 'DESC')->get();
        return view('SuperAdmin.audition.index', compact('auditions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::orderBy('id', 'DESC')->get();
        return view('SuperAdmin.audition.create', compact('categories'));
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
        $categories = Category::orderBy('id', 'DESC')->get();
        $audition = Audition::find($id);
        return view('SuperAdmin.audition.edit', compact('audition', 'categories'));
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
