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
           'assigned_admins' => User::where([['status',1],['active_status',1],['category_id',auth()->user()->category_id],['user_type','admin']])->whereHas('star')->orderBy('updated_at','desc')->get(),

           'unassigned_admins' => User::where([['status',1],['active_status',1],['category_id',auth()->user()->category_id],['user_type','admin']])->whereDoesntHave('star')->orderBy('updated_at','desc')->get(),
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
        $admin =  User::find($id);
        $data = [
            'unassigned_stars' => User::where([['status',1],['active_status',1],['sub_category_id',$admin->sub_category_id],['user_type','star'],['parent_user',null]])->get(),

            'admin' =>$admin,

        ];

        return view('ManagerAdmin.assigned.edit',$data);
    }


    public function update(Request $request, $id)
    {

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
