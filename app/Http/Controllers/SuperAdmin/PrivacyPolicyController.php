<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Models\PrivacyPolicy;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PrivacyPolicyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $data = PrivacyPolicy::orderBy('id', 'desc')->where('status', 1)->get();
        return view('SuperAdmin.PrivacyPolicy.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'aboutUs' => PrivacyPolicy::orderBy('id', 'desc')->where('status', 1)->first(),
        ];
        return view('SuperAdmin.PrivacyPolicy.create', $data);
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
            $aboutus = new PrivacyPolicy();
            $aboutus->title = $request->input('title');
            $aboutus->details = $request->input('details');
            $aboutus->status = 1;

        try {
            $aboutus->save();
                return response()->json([
                    'success' => true,
                    'message' => 'Privacy Policy Add Successfully'
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
        $data = PrivacyPolicy::findOrfail($id);
      
        return view('SuperAdmin.PrivacyPolicy.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'details' => 'required',
          
        ]);

            $aboutus = PrivacyPolicy::findOrFail($id);
            $aboutus->title = $request->input('title');
            $aboutus->details = $request->input('details');
            $aboutus->status = $request->input('status');

        try {
            $aboutus->save();
            return response()->json([
                'success' => 'success',
                'message' => 'Privacy Policy Updated Successfully'
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
        $educationlevel = PrivacyPolicy::findOrfail($id);
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
