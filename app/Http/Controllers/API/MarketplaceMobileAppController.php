<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Marketplace;
use App\Models\MarketplaceOrder;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MarketplaceMobileAppController extends Controller
{
    public function marketplaceStore(Request $request)
    {
        $marketplace = Marketplace::find($request->marketplace_id);

        if ($marketplace->total_items >= $marketplace->total_selling + $request->items) {
            $marketplaceOrder = new MarketplaceOrder();
            $marketplaceOrder->order_no = rand(10000, 99999) . time();
            $marketplaceOrder->items = $request->items;
            $marketplaceOrder->unit_price = $marketplace->unit_price;
            $marketplaceOrder->delivery_charge = $marketplace->delivery_charge;
            $marketplaceOrder->marketplace_id = $marketplace->id;
            $marketplaceOrder->user_id = Auth::user()->id;
            $marketplaceOrder->superstar_id = $marketplace->superstar_id;
            $marketplaceOrder->superstar_admin_id = $marketplace->superstar_admin_id;
            $marketplaceOrder->total_price = $request->total_price;

            // $marketplaceOrder->cvc = $request->cvc;
            // $marketplaceOrder->card_no = $request->card_no;
            // $marketplaceOrder->expire_date = $request->expire_date;

            // $marketplaceOrder->status = 1;
            // $marketplace->total_selling += $request->items;
            // $marketplace->save();

            $marketplaceOrder->save();



            return response()->json([
                'status' => 200,
                'message' => 'Order Stored Successfully',
            ]);
        } else {
            return response()->json([
                'status' => 200,
                'message' => 'Not Enough Product',
            ]);
        }
    }
}
