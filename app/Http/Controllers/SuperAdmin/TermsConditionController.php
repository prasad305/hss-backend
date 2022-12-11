<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TermAndCondition;

class TermsConditionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $termscondition = TermAndCondition::orderBy('id', 'DESC')->first();
        return view('SuperAdmin.TermsCondition.index', compact('termscondition'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('SuperAdmin.TermsCondition.create');
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


        ], [
            'title.required' => 'Title Field Is Required',
            'details.required' => 'Details Field Is Required',

        ]);

        try {
            $termscondition = TermAndCondition::create(
                $request->all()
            );
            if ($termscondition) {
                return response()->json([
                    'success' => true,
                    'message' => 'Terms Condition Add Successfully'
                ]);
            }
        } catch (\Exception $exception) {
            return response()->json([
                'type' => 'error',
                'message' => 'Opps somthing went wrong. ' . $exception->getMessage(),
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $termscondition = TermAndCondition::findOrFail($id);
        return view('SuperAdmin.TermsCondition.edit', compact('termscondition'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $tarmscondition = TermAndCondition::findOrFail($id);
        $tarmscondition->title = $request->input('title');
        $tarmscondition->details = $request->input('details');
        $tarmscondition->status = $request->input('status');

        try {
            $tarmscondition->save();
            return response()->json([
                'success' => 'success',
                'message' => 'Product Purchase Updated Successfully'
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
        $deletedata = TermAndCondition::findOrfail($id);
        try {
            $deletedata->delete();
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
