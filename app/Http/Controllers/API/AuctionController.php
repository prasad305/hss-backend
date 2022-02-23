<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Auction;
use Illuminate\Http\Request;

class AuctionController extends Controller
{
    public function addProduct(Request $request){
        /* $products = Auction::create(
            $request->all()
        ); */
        return response()->json([
            'status' => '200',
            
        ]);
    }
}
