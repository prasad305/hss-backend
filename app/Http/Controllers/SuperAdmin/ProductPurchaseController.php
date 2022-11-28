<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductPurchase;

class ProductPurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $productpurchase = ProductPurchase::orderBy('id', 'DESC')->first();
        return view('SuperAdmin.productpurchase.index',compact('productpurchase'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('SuperAdmin.productpurchase.create');
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
            $ProPurchase = ProductPurchase::create(
                $request->all()
            );
            if ($ProPurchase) {
                return response()->json([
                    'success' => true,
                    'message' => 'ProPurchase Add Successfully'
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
        $productpurchase = ProductPurchase::findOrFail($id);
        return view('SuperAdmin.productpurchase.edit', compact('productpurchase'));
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
        $producturchase = ProductPurchase::findOrFail($id);
        $producturchase->title = $request->input('title');
        $producturchase->details = $request->input('details');
        $producturchase->status = $request->input('status');

        try {
            $producturchase->save();
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
        $deletedata = ProductPurchase::findOrfail($id);
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
