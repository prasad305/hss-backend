<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RefundPolicy;

class RefundController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $refundpolicy = RefundPolicy::orderBy('id', 'DESC')->first();
        return view('SuperAdmin.RefundPolicy.index',compact('refundpolicy'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('SuperAdmin.RefundPolicy.create');
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
            $refundpolicy = RefundPolicy::create(
                $request->all()
            );
            if ($refundpolicy) {
                return response()->json([
                    'success' => true,
                    'message' => 'Refund Policy Add Successfully'
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
        $refundpolicy = RefundPolicy::findOrFail($id);
        return view('SuperAdmin.RefundPolicy.edit', compact('refundpolicy'));
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
        $refundpolicy = RefundPolicy::findOrFail($id);
        $refundpolicy->title = $request->input('title');
        $refundpolicy->details = $request->input('details');
        $refundpolicy->status = $request->input('status');

        try {
            $refundpolicy->save();
            return response()->json([
                'success' => 'success',
                'message' => 'Refund Policy Updated Successfully'
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
        $deletedata = RefundPolicy::findOrfail($id);
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
