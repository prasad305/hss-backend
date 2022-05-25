<?php

namespace App\Http\Controllers\ManagerAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class StarAssignedController extends Controller
{
  
    public function index()
    {
       $data = [
           'assigned_admins' => User::where([['status',1],['active_status',1],['category_id',auth()->user()->category_id],['user_type','admin']])->whereHas('star')->get(),

           'unassigned_admins' => User::where([['status',1],['active_status',1],['category_id',auth()->user()->category_id],['user_type','admin']])->whereDoesntHave('star')->get(),
       ];

       return view('ManagerAdmin.assigned.index',$data);
    }

    
    public function create()
    {
        //
    }

    
    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    
    public function edit($id)
    {
        $data = [
            'unassigned_stars' => User::where([['status',1],['active_status',1],['category_id',auth()->user()->category_id],['user_type','star'],['parent_user',null]])->get(),

            'admin' => User::find($id),
            
        ];
 
        return view('ManagerAdmin.assigned.edit',$data);
    }

   
    public function update(Request $request, $id)
    {
        // return $request->all();
        $request->validate([
            'star_id' => 'required',
        ]);

        try {
            $star = User::find($request->star_id)->update([
                'parent_user' => $id,
            ]);

            if ($star) {
                return response()->json([
                    'success' => true,
                    'message' => 'Admin Assigned Successfully'
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
        //
    }
}
