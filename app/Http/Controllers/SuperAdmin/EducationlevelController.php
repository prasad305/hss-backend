<?php

namespace App\Http\Controllers\SuperAdmin;

use Illuminate\Http\Request;
use App\Models\Educationlevel;
use App\Http\Controllers\Controller;

class EducationlevelController extends Controller
{
    public function index()
    {
        $educationlevel = Educationlevel::orderBy('id', 'DESC')->get();
        return view('SuperAdmin.educationlevel.index', compact('educationlevel'));
    }

    public function create()
    {
        $data = [
            'educationlevel' => Educationlevel::orderBy('id', 'desc')->where('status', 1)->get(),
        ];
        return view('SuperAdmin.educationlevel.create', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:educationlevels',
          
        ]);

        $educationlevel = new Educationlevel();

        $educationlevel->name = $request->input('name');
       
        $educationlevel->status = 1;

     
        try {
            $educationlevel->save();
            return response()->json([
                'type' => 'success',
                'message' => 'Educationlevel created successfully',
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
        $educationlevel = Educationlevel::findOrfail($id);
        //dd($educationlevel);
       
        return view('SuperAdmin.educationlevel.edit', compact('educationlevel'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
          
        ]);

        $educationlevel = Educationlevel::findOrFail($id);
        $educationlevel->name = $request->input('name');
        $educationlevel->status = $request->input('status');

        try {
            $educationlevel->save();
            return response()->json([
                'success' => 'success',
                'message' => 'Educationlevel Updated Successfully'
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
        $educationlevel = Educationlevel::findOrfail($id);
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
