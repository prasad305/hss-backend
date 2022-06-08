<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\GreetingType;

class GreetingController extends Controller
{
    public function index()
    {
        $greetingtype = GreetingType::orderBy('id', 'DESC')->get();
        return view('SuperAdmin.greetingType.index')->with('greetingtype', $greetingtype);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('SuperAdmin.greetingType.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'greeting_type' => 'required|unique:greeting_types',
        ]);

        $greetingtype = new GreetingType();

        $greetingtype->greeting_type = $request->input('greeting_type');
        $greetingtype->status = 1;


        try {
            $greetingtype->save();
            return response()->json([
                'type' => 'success',
                'message' => 'Greeting Type created successfully',
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
        $greetingtype = GreetingType::findOrfail($id);
        return view('SuperAdmin.greetingType.edit', compact('greetingtype'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'greeting_type' => 'required|unique:greeting_types,greeting_type,'.$id,
        ]);

        $greetingtype = GreetingType::findOrFail($id);
        $greetingtype->greeting_type = $request->input('greeting_type');

        try {
            $greetingtype->save();
            return response()->json([
                'success' => 'success',
                'message' => 'Greeting Type Updated Successfully'
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
        $user = GreetingType::findOrFail($id);
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
        $user = GreetingType::findOrFail($id);
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
