<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Models\Virtualtour;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\File;

class VirtualtourController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $virtualtours = Virtualtour::orderBy('id', 'DESC')->get();
        return view('SuperAdmin.VirtualTour.index',compact('virtualtours'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('SuperAdmin.VirtualTour.create');
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
            'title' => 'required',
            'type' => 'required',
        ]);

        $virtualtour = new Virtualtour();
        $virtualtour->title = $request->input('title');
        $virtualtour->link = $request->input('link');
        $virtualtour->type = $request->input('type');

        if ($request->hasFile('video')) {

            $file        = $request->file('video');
            $path        = 'uploads/videos/virtualtour/';
            $file_name   = time() . rand('0000', '9999') . '.' . $file->getClientOriginalName();
            $file->move($path, $file_name);
            $virtualtour->video = $path . '/' . $file_name;
        }


        try {
            $virtualtour->save();
            if ($virtualtour) {
                return response()->json([
                    'success' => true,
                    'message' => 'Virtual tour Video Inserted'
                ]);
            }
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
     * @param  \App\Models\Virtualtour  $virtualtour
     * @return \Illuminate\Http\Response
     */
    public function show(Virtualtour $virtualtour)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Virtualtour  $virtualtour
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $virtualtour = Virtualtour::findOrfail($id);
        return view('SuperAdmin.VirtualTour.edit', compact('virtualtour'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Virtualtour  $virtualtour
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'type' => 'required',
        ]);

        $virtualtour = Virtualtour::findOrFail($id);
        $virtualtour->title = $request->input('title');
        $virtualtour->link = $request->input('link');
        $virtualtour->type = $request->input('type');

        $destination = $virtualtour->video;
            if (File::exists($destination)) {
                File::delete($destination);
            }

        if ($request->hasFile('video')) {

            $file        = $request->file('video');
            $path        = 'uploads/videos/virtualtour/';
            $file_name   = time() . rand('0000', '9999') . '.' . $file->getClientOriginalName();
            $file->move($path, $file_name);
            $virtualtour->video = $path . '/' . $file_name;
        }

        try {
            $result = $virtualtour->update();
            if ($result) {
                return response()->json([
                    'success' => true,
                    'message' => 'Virtual Tour Information Updated Successfully'
                ]);
            }
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
     * @param  \App\Models\Virtualtour  $virtualtour
     * @return \Illuminate\Http\Response
     */
    public function destroy(Virtualtour $virtualtour,$id)
    {
        $virtualtour = Virtualtour::findOrfail($id);
         $destination = $virtualtour->video;
            if (File::exists($destination)) {
                File::delete($destination);
            }

        try {
            $virtualtour->delete();
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
