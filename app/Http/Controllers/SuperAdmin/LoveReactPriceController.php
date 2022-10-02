<?php

namespace App\Http\Controllers\SuperAdmin;

use Illuminate\Http\Request;
use App\Models\LoveReactPrice;
use App\Http\Controllers\Controller;

class LoveReactPriceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $love = LoveReactPrice::orderBy('id', 'DESC')->get();
        return view('SuperAdmin.package.love')->with('love', $love);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('SuperAdmin.package.love_create');
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
            'love_points' => 'required',
        ]);

        $love = new LoveReactPrice();
        $love->title = $request->title;
        $love->love_points = $request->love_points;
        $love->price = $request->price;
        $love->color_code = $request->color_code;

     
        try {
            $love->save();
            return response()->json([
                'type' => 'success',
                'message' => 'Love React created successfully',
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
        $package = LoveReactPrice::findOrfail($id);
        return view('SuperAdmin.package.love_edit', compact('package'));
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
            'love_points' => 'required',
        ]);

        $package = LoveReactPrice::findOrFail($id);
        $package->title = $request->title;
        $package->love_points = $request->love_points;
        $package->price = $request->price;
        $package->color_code = $request->color_code;

        try {
            $package->save();
            return response()->json([
                'success' => 'success',
                'message' => 'Love React Updated Successfully'
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
        //
    }
}
