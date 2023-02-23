<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Models\SouvenirDeliveryCharge;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SouvenirDeliveryChargeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $deliverycharges = SouvenirDeliveryCharge::orderBy('id', 'DESC')->get();
        return view('SuperAdmin.souvenirdeliverycharge.index',compact('deliverycharges'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('SuperAdmin.souvenirdeliverycharge.create');
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
            'country' => 'required|unique:souvenir_delivery_charges',
            'courier_charge' => 'required',
            'courier_company' => 'required|unique:souvenir_delivery_charges',
        ]);

        $deliverycharge = new SouvenirDeliveryCharge();

        $deliverycharge->country = $request->country;
        $deliverycharge->courier_charge = $request->courier_charge;
        $deliverycharge->courier_company = $request->courier_company;
        $deliverycharge->status = 1;

     
        try {
            $deliverycharge->save();
            return response()->json([
                'type' => 'success',
                'message' => 'Delivery Charge created successfully',
            ]);
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
     * @param  \App\Models\SouvenirDeliveryCharge  $souvenirDeliveryCharge
     * @return \Illuminate\Http\Response
     */
    public function show(SouvenirDeliveryCharge $souvenirDeliveryCharge)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SouvenirDeliveryCharge  $souvenirDeliveryCharge
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $deliverycharge = SouvenirDeliveryCharge::findOrfail($id);
        return view('SuperAdmin.souvenirdeliverycharge.edit', compact('deliverycharge'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SouvenirDeliveryCharge  $souvenirDeliveryCharge
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'country' => 'required|unique:souvenir_delivery_charges,country,'.$id,
            'courier_charge' => 'required',
            'courier_company' => 'required|unique:souvenir_delivery_charges,courier_company,'.$id,
        ]);

        $deliverycharge = SouvenirDeliveryCharge::findOrfail($id);
        $deliverycharge->country = $request->country;
        $deliverycharge->courier_charge = $request->courier_charge;
        $deliverycharge->courier_company = $request->courier_company;

        try {
            $deliverycharge->save();
            return response()->json([
                'success' => 'success',
                'message' => 'Delivery Charge Updated Successfully'
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
     * @param  \App\Models\SouvenirDeliveryCharge  $souvenirDeliveryCharge
     * @return \Illuminate\Http\Response
     */
    public function destroy(SouvenirDeliveryCharge $souvenirDeliveryCharge)
    {
        //
    }

    public function activeNow($id)
    {
        $deliverycharge = SouvenirDeliveryCharge::findOrFail($id);
        $deliverycharge->status = 1;
        try {
            $deliverycharge->save();
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
        $deliverycharge = SouvenirDeliveryCharge::findOrFail($id);
        $deliverycharge->status = 0;
        try {
            $deliverycharge->save();
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
