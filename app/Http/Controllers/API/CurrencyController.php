<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Currency;

class CurrencyController extends Controller
{


    public function allCurrency($ip)
    {

        // return $clientIp;
        $currency = Currency::latest()->get();

        if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
            $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
            $_SERVER['HTTP_CLIENT_IP'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
        }
        $client  = @$_SERVER['HTTP_CLIENT_IP'];
        $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
        $remote  = $_SERVER['REMOTE_ADDR'];

        if (filter_var($client, FILTER_VALIDATE_IP)) {
            $clientIp = $client;
        } elseif (filter_var($forward, FILTER_VALIDATE_IP)) {
            $clientIp = $forward;
        } else {
            $clientIp = $remote;
        }

        $clientIp = '101.33.63.255'; //india
        // $clientIp = '103.104.69.255'; //my
        //$clientIp = '103.101.36.0'; //nepal
        //$clientIp = '162.210.194.38'; // usa
        //$clientIp = '104.44.7.192'; // arab amerates
        // $clientIp = '103.91.229.182'; // Bangladesh
        $locationData = \Location::get($clientIp);
        // dd($locationData->countryCode);

        $currencyDetails = Currency::where('country_code', $locationData->countryCode)->first();


        return response()->json([
            'status' => 200,
            'currency' => $currency,
            'locationData' => $locationData,
            'currencyDetails' => $currencyDetails,
            'countryCode' => $locationData->countryCode,

        ]);
    }


    function getMyLocation($ip)
    {
        $locationData = \Location::get($ip);

        $currencyDetails = Currency::where('country_code', $locationData->countryCode)->first();
        return response()->json([
            'status' => 200,
            'locationData' => $locationData,
            'currencyDetails' => $currencyDetails,
            'strpe_pk' => env('STRIPE_PUBLIC_KEY'),
            'eventMode' => true
        ]);
    }



    function getIPAddress()
    {
        //whether ip is from the share internet
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        }
        //whether ip is from the proxy
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        //whether ip is from the remote address
        else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }


    public function getLocation()
    {

        if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
            $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
            $_SERVER['HTTP_CLIENT_IP'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
        }
        $client  = @$_SERVER['HTTP_CLIENT_IP'];
        $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
        $remote  = $_SERVER['REMOTE_ADDR'];

        if (filter_var($client, FILTER_VALIDATE_IP)) {
            $clientIp = $client;
        } elseif (filter_var($forward, FILTER_VALIDATE_IP)) {
            $clientIp = $forward;
        } else {
            $clientIp = $remote;
        }

        //$clientIp = '103.101.36.0'; //nepal
        //$clientIp = '162.210.194.38'; // usa
        $clientIp = '104.44.7.192'; // arab amerates
        //$clientIp = '103.102.27.0'; // Bangladesh
        $locationData = \Location::get($clientIp);
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
