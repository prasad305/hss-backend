<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AboutUs;
use App\Models\PrivacyPolicy;
use App\Models\FAQ;
use App\Models\ProductPurchase;
use App\Models\TarmsCondition;
use App\Models\RefundPolicy;

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
        $data = PrivacyPolicy::orderBy('id', 'desc')->where('status', 1)->get();

        return response()->json([
            'status' => 200,
            'data' => $data,
            'message' => 'Policy Added Successfully',
        ]);
    }
    public function faq()
    {
        $data = FAQ::where('status', 1)->orderBy('id', 'DESC')->get();

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
        $data = TarmsCondition::orderBy('id', 'DESC')->first();

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
}
