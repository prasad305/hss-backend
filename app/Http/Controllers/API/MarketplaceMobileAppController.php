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
            $marketplaceOrder->save();
            return response()->json([
                'status' => 200,
                'message' => 'Order Stored Successfully',
                'marketplaceOrder' => $marketplaceOrder,
            ]);
        } else {
            return response()->json([
                'status' => 200,
                'message' => 'Not Enough Product',
            ]);
        }
    }
    public function marketplaceUpdate(Request $request, $marketplace_order_id)
    {
        $marketplaceOrder = MarketplaceOrder::find($marketplace_order_id);
        $marketplace = Marketplace::find($marketplaceOrder->marketplace_id);

        if ($marketplace->total_items >= $marketplace->total_selling + $marketplaceOrder->items) {
            $marketplaceOrder->country_id = $request->country;
            $marketplaceOrder->state_id = $request->state;
            $marketplaceOrder->city_id = $request->city;
            $marketplaceOrder->area = $request->area;
            $marketplaceOrder->phone = $request->phone;
            $marketplaceOrder->save();

            return response()->json([
                'status' => 200,
                'message' => 'Order updated Successfully',
            ]);
        } else {
            return response()->json([
                'status' => 200,
                'message' => 'Not Enough Product',
            ]);
        }
    }

    public function checkPaymentUncompletedOrder($marketplace_id ,Marketplace $marketplace){
        $marketplace = $marketplace->find($marketplace_id);

        $marketplaceOrder = MarketplaceOrder::where([['status', null],['marketplace_id',$marketplace_id],['user_id', $Auth::user()->id]])->first();
        $isHavePaymentUncompletedOrder = false;
        if($marketplaceOrder){
            $isHavePaymentUncompletedOrder = true;
        }else{
            $isHavePaymentUncompletedOrder = false;
        }

        return response()->json([
            'status' => 200,
            'message' => 'Ok',
            'marketplaceOrder' => $marketplaceOrder,
            'isHavePaymentUncompletedOrder' => $isHavePaymentUncompletedOrder,
        ]);
    }
}
