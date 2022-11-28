<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Currency;

class CurrencyController extends Controller
{
    public function allCurrency(){
        $currency = Currency::latest()->get();

        return response()->json([
            'status' => 200,
            'currency' => $currency,
        ]);
    }

    public function getLocation(){
        if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
            $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
            $_SERVER['HTTP_CLIENT_IP'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
        }
        $client  = @$_SERVER['HTTP_CLIENT_IP'];
        $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
        $remote  = $_SERVER['REMOTE_ADDR'];
    
        if(filter_var($client, FILTER_VALIDATE_IP)){
            $clientIp = $client;
        }
        elseif(filter_var($forward, FILTER_VALIDATE_IP)){
            $clientIp = $forward;
        }
        else{
            $clientIp = $remote;
        }
    
        // $clientIp = '103.101.36.0'; //nepal
        // $clientIp = '162.210.194.38'; // usa
        $clientIp = '104.44.7.192'; // arab amerates
        // $clientIp = '103.102.27.0'; // Bangladesh
        $locationData = \Location::get($clientIp );
        // dd($locationData->countryCode);

        $currencyDetails = Currency::where('country_code', $locationData->countryCode)->first();

        return response()->json([
            'status' => 200,
            'locationData' => $locationData,
            'currencyDetails' => $currencyDetails,
            'countryCode' => $locationData->countryCode,
        ]);
    }
}
