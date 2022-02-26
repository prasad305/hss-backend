<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Country;

class CountryController extends Controller
{
    public function index()
    {
        $country = Country::orderBy('id', 'DESC')->get();
        return view('SuperAdmin.country.index')->with('country', $country);
    }

    public function create()
    {
        return view('SuperAdmin.country.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:countries',
        ]);

        $country = new Country();

        $country->name = $request->input('name');
        $country->status = 1;

     
        try {
            $country->save();
            return response()->json([
                'type' => 'success',
                'message' => 'Country created successfully',
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
        $country = Country::findOrfail($id);
        return view('SuperAdmin.country.edit', compact('country'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|unique:countries',
        ]);

        $country = Country::findOrFail($id);
        $country->name = $request->input('name');

        try {
            $country->save();
            return response()->json([
                'success' => 'success',
                'message' => 'Country Updated Successfully'
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
        $user = Country::findOrFail($id);
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
        $user = Country::findOrFail($id);
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
