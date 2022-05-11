<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Package;

class PackageController extends Controller
{
    public function index()
    {
        $package = Package::orderBy('id', 'DESC')->get();
        return view('SuperAdmin.package.index')->with('package', $package);
    }

    public function create()
    {
        return view('SuperAdmin.package.create');
    }

    public function store(Request $request)
    {
       

        // $package = new Package();

        // $package->name = $request->input('name');
        // $package->status = 1;

        $package = new Package();
        $package->title = $request->title;
        $package->club_points = $request->club_points;
        $package->auditions = $request->auditions;
        $package->learning_session = $request->learning_session;
        $package->live_chats = $request->live_chats;
        $package->meetup = $request->meetup;
        $package->greetings = $request->greetings;
        $package->price = $request->price;
        $package->status = 1;

     
        try {
            $package->save();
            return response()->json([
                'type' => 'success',
                'message' => 'package created successfully',
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
        $package = Package::findOrfail($id);
        return view('SuperAdmin.package.edit', compact('package'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|unique:countries',
        ]);

        $package = Package::findOrFail($id);
        $package->name = $request->input('name');

        try {
            $package->save();
            return response()->json([
                'success' => 'success',
                'message' => 'package Updated Successfully'
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'type' => 'error',
                'message' => 'Opps somthing went wrong. ' . $exception->getMessage(),
            ]);
        }
    }




    public function activeNow($id)
    {
        $user = Package::findOrFail($id);
        $user->status = 1;
        try {
            $user->save();
            return response()->json([
                'type' => 'success',
                'message' => 'Successfully Updated'
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'type' => 'error',
                'message' => $exception->getMessage()
            ]);
        }
    }

    public function inactiveNow($id)
    {
        $user = Package::findOrFail($id);
        $user->status = 0;
        try {
            $user->save();
            return response()->json([
                'type' => 'success',
                'message' => 'Successfully Updated'
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'type' => 'error',
                'message' => $exception->getMessage()
            ]);
        }
    }
}