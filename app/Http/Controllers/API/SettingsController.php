<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AboutUs;
use App\Models\PrivacyPolicy;
use App\Models\FAQ;
use App\Models\ProductPurchase;
use App\Models\TermAndCondition;
use App\Models\RefundPolicy;
use App\Models\DeliveryCharge;
use App\Models\SouvenirDeliveryCharge;

class SettingsController extends Controller
{
    public function aboutus()
    {
        $data = AboutUs::orderBy('id', 'DESC')->first();

        return response()->json([
            'status' => 200,
            'data' => $data,
            'message' => 'About us Added Successfully',
        ]);
    }
    public function policy()
    {
        $data = PrivacyPolicy::orderBy('id', 'asc')->where('status', 1)->get();

        return response()->json([
            'status' => 200,
            'data' => $data,
            'message' => 'Policy Added Successfully',
        ]);
    }
    public function faq()
    {
        $data = FAQ::where('status', 1)->orderBy('id', 'asc')->get();

        return response()->json([
            'status' => 200,
            'data' => $data,
            'message' => 'Faq Added Successfully',
        ]);
    }
    public function productPurchase()
    {
        $data = ProductPurchase::orderBy('id', 'DESC')->first();

        return response()->json([
            'status' => 200,
            'data' => $data,
            'message' => 'Product Purchase Added Successfully',
        ]);
    }
    public function termsCondition()
    {
        $data = TermAndCondition::orderBy('id', 'DESC')->first();

        return response()->json([
            'status' => 200,
            'data' => $data,
            'message' => 'Tarms Condition Added Successfully',
        ]);
    }
    public function refund()
    {
        $data = RefundPolicy::orderBy('id', 'DESC')->first();

        return response()->json([
            'status' => 200,
            'data' => $data,
            'message' => 'Refund Added Successfully',
        ]);
    }

    public function marketplacedeliverycharge()
    {
        $data = DeliveryCharge::where('status',1)->orderBy('id', 'DESC')->get();

        return response()->json([
            'status' => 200,
            'data' => $data,
        ]);
    }

    public function souvenirdeliverycharge()
    {
        $data = SouvenirDeliveryCharge::where('status',1)->orderBy('id', 'DESC')->get();

        return response()->json([
            'status' => 200,
            'data' => $data,
        ]);
    }
}
