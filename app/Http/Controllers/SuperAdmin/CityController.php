<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\City;
use App\Models\Country;
use App\Models\State;

class CityController extends Controller
{
    public function index()
    {
        $city = City::orderBy('id', 'DESC')->get();
        return view('SuperAdmin.city.index')->with('city', $city);
    }

    public function create()
    {
        $data = [
            'countries' => Country::orderBy('id', 'desc')->where('status', 1)->get(),
            'states' => State::orderBy('id', 'desc')->where('status', 1)->get(),
        ];
        return view('SuperAdmin.city.create', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:countries',
            'country_id' => 'required',
            'state_id' => 'required',
        ]);

        $city = new City();

        $city->name = $request->input('name');
        $city->country_id = $request->input('country_id');
        $city->state_id = $request->input('state_id');
        $city->status = 1;

     
        try {
            $city->save();
            return response()->json([
                'type' => 'success',
                'message' => 'City created successfully',
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'type' => 'error',
                'message' => 'Opps somthing went wrong. ' . $exception->getMessage(),
            ]);
        }
    }

    public function getState($id){
        return $states = State::where('country_id', $id)->get();
    }

    public function edit($id)
    {
        $cities = City::findOrfail($id);
        $countries = Country::orderBy('id', 'DESC')->get();
        $states = State::orderBy('id', 'DESC')->where('country_id', $cities->country_id)->get();
        // $states = State::orderBy('id', 'DESC')->get();
        return view('SuperAdmin.city.edit', compact('countries', 'cities', 'states'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|unique:countries',
            'country_id' => 'required',
            'state_id' => 'required',
        ]);

        $city = City::findOrFail($id);
        $city->name = $request->input('name');
        $city->country_id = $request->input('country_id');
        $city->state_id = $request->input('state_id');

        try {
            $city->save();
            return response()->json([
                'success' => 'success',
                'message' => 'City Updated Successfully'
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
        $user = City::findOrFail($id);
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
        $user = city::findOrFail($id);
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
