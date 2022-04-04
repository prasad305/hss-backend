<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\InterestType;

class InterestTypeController extends Controller
{
    public function index()
    {
        $interestType = InterestType::orderBy('id', 'DESC')->get();
        return view('SuperAdmin.interestType.index')->with('interestType', $interestType);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('SuperAdmin.interestType.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'interest_type' => 'required|unique:interest_types',
        ]);

        $interestType = new InterestType();

        $interestType->interest_type = $request->input('interest_type');
        $interestType->status = 1;

     
        try {
            $interestType->save();
            return response()->json([
                'type' => 'success',
                'message' => 'Interest Type created successfully',
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
        $interestType = InterestType::findOrfail($id);
        return view('SuperAdmin.interestType.edit', compact('interestType'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'interest_type' => 'required|unique:interest_types',
        ]);

        $interestType = InterestType::findOrFail($id);
        $interestType->interest_type = $request->input('interest_type');

        try {
            $interestType->save();
            return response()->json([
                'success' => 'success',
                'message' => 'Interest Type Updated Successfully'
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
        $interestType = InterestType::findOrFail($id);
        $interestType->status = 1;
        try {
            $interestType->save();
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
        $interestType = InterestType::findOrFail($id);
        $interestType->status = 0;
        try {
            $interestType->save();
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
