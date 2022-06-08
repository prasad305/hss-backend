<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\AuctionTerms;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuctionController extends Controller
{
    public function index(){

        $instruction = AuctionTerms::orderBy('id','DESC')->get();
        return view('SuperAdmin.Auction.index',compact('instruction'));
    }
    public function termsCreate(){
        
        return view('SuperAdmin.Auction.create');
    }
    public function termsEdit($id){
        $instruction = AuctionTerms::findOrFail($id);
        return view('SuperAdmin.Auction.edit',compact('instruction'));
    }
    public function termsStore(Request $request){

        $request->validate([

                'acquired_instruction' => 'required',
    
    
            ],[
                'acquired_instruction.required' => 'Instruction Field Is Required',
    
            ]);

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
    
    public function termsUpdate(Request $request,$id){
        {

            $request->validate([
    
                    'acquired_instruction' => 'required',
        
        
                ],[
                    'acquired_instruction.required' => 'Instruction Field Is Required',
        
                ]);
    
           try {
            $instruction = AuctionTerms::findOrFail($id)->Update(
                [
                    'acquired_instruction'=> $request->acquired_instruction
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
    }
    public function termsDestroy($id)
    {
        $term = AuctionTerms::findOrfail($id);
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
