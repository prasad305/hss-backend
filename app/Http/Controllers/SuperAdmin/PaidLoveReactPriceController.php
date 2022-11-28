<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\PaidLoveReactPrice;
use Illuminate\Http\Request;

class PaidLoveReactPriceController extends Controller
{
    public function index()
    {
        $loveReactData = PaidLoveReactPrice::get();
        return view('SuperAdmin.PaidLoveReact.index', compact('loveReactData'));
    }
    public function loveReactPriceCreate()
    {
        return view('SuperAdmin.PaidLoveReact.create');
    }
    public function loveReactPriceStore(Request $request)
    {
        $request->validate([

            'gradeName' => 'required',
            'loveReact' => 'required',
            'fee' => 'required',


        ]);

        try {
            $instruction = PaidLoveReactPrice::create(
                $request->all()
            );
            if ($instruction) {
                return response()->json([
                    'success' => true,
                    'message' => 'Instruction Add Successfully'
                ]);
            }
        } catch (\Exception $exception) {
            return response()->json([
                'type' => 'error',
                'message' => 'Opps somthing went wrong. ' . $exception->getMessage(),
            ]);
        }
    }
    public function loveReactPriceEdit($id)
    {
        $loveReactData = PaidLoveReactPrice::find($id);
        return view('SuperAdmin.PaidLoveReact.edit', compact('loveReactData'));
    }
    public function loveReactPriceUpdate(Request $request, $id)
    {
        $request->validate([

            'gradeName' => 'required',
            'loveReact' => 'required',
            'fee' => 'required',

        ]);

        try {
            $instruction = PaidLoveReactPrice::findOrFail($id)->Update(
                [

                    'gradeName' => $request->gradeName,
                    'loveReact' => $request->loveReact,
                    'fee' => $request->fee,
                ]

            );
            if ($instruction) {
                return response()->json([
                    'success' => true,
                    'message' => 'Instruction Updated Successfully'
                ]);
            }
        } catch (\Exception $exception) {
            return response()->json([
                'type' => 'error',
                'message' => 'Opps somthing went wrong. ' . $exception->getMessage(),
            ]);
        }
    }
    public function loveReactPriceDestroy($id)
    {
        $term = PaidLoveReactPrice::find($id);
        try {
            $term->delete();
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
