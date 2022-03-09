<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\State;
use App\Models\Country;

class StateController extends Controller
{
    public function index()
    {
        $state = State::orderBy('id', 'DESC')->get();
        return view('SuperAdmin.state.index')->with('state', $state);
    }

    public function create()
    {
        $data = [
            'countries' => Country::orderBy('id', 'desc')->where('status', 1)->get(),
        ];
        return view('SuperAdmin.state.create', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:countries',
            'country_id' => 'required'
        ]);

        $state = new State();

        $state->name = $request->input('name');
        $state->country_id = $request->input('country_id');
        $state->status = 1;

     
        try {
            $state->save();
            return response()->json([
                'type' => 'success',
                'message' => 'state created successfully',
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
        $countries = Country::orderBy('id', 'DESC')->get();
        $state = State::findOrfail($id);
        return view('SuperAdmin.state.edit', compact('state', 'countries'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|unique:countries',
            'country_id' => 'required'
        ]);

        $state = State::findOrFail($id);
        $state->name = $request->input('name');
        $state->country_id = $request->input('country_id');

        try {
            $state->save();
            return response()->json([
                'success' => 'success',
                'message' => 'State Updated Successfully'
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
        $user = State::findOrFail($id);
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
        $user = State::findOrFail($id);
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
