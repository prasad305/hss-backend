<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\AuctionTerms;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuctionController extends Controller
{
    public function index(){

        return view('SuperAdmin.Auction.index');
    }
    public function termsCreate(){
        
        return view('SuperAdmin.Auction.create');
    }
    public function termsStore(Request $request){

        // return $request->all();
        
        $validator = Validator::make($request->all(), [

            'acquired_instruction' => 'required',


        ],[
            'acquired_instruction.required' => 'Title Field Is Required',

        ]);

        // if ($validator->fails()) {
        //     return response()->json([
        //         'status' => 402,
        //         'errors' => $validator->errors(),
        //     ]);
        // }

       try {
        $instruction = AuctionTerms::create(
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
}
