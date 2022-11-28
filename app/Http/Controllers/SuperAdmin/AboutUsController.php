<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Models\AboutUs;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AboutUsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $data = AboutUs::orderBy('id', 'DESC')->first();
        return view('SuperAdmin.AboutUs.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'aboutUs' => AboutUs::orderBy('id', 'desc')->where('status', 1)->first(),
        ];
        return view('SuperAdmin.AboutUs.create', $data);
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
            'details' => 'required',
          
        ]);
            $aboutus = new AboutUs();
            $aboutus->title = $request->input('title');
            $aboutus->details = $request->input('details');
            $aboutus->status = 1;

        try {
            $aboutus->save();
                return response()->json([
                    'success' => true,
                    'message' => 'Aboutus Summary Add Successfully'
                ]);
            
        } catch (\Exception $exception) {
            return response()->json([
                'type' => 'error',
                'message' => 'Opps somthing went wrong. ' . $exception->getMessage(),
            ]);
        }
    }

    public function edit($id)
    {
        $aboutus = AboutUs::findOrfail($id);
      
        return view('SuperAdmin.AboutUs.edit', compact('aboutus'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'details' => 'required',
          
        ]);

            $aboutus = AboutUs::findOrFail($id);
            $aboutus->title = $request->input('title');
            $aboutus->details = $request->input('details');
            $aboutus->status = $request->input('status');

        try {
            $aboutus->save();
            return response()->json([
                'success' => 'success',
                'message' => 'Aboute Summary Updated Successfully'
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
        $educationlevel = AboutUs::findOrfail($id);
        try {
            $educationlevel->delete();
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
