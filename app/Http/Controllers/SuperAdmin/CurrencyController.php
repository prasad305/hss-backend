<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Currency;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class CurrencyController extends Controller
{
    public function index(Request $request)
    {
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
    
        $clientIp = '103.91.229.182';
        // $clientIp = '46.235.208.0';
        $locationData = \Location::get($clientIp );
        dd($locationData);

        
        $data = $request->getIp();
        // $position = Location::get();
        dd($data);
        $currencies = Currency::latest()->get();
        return view('SuperAdmin.currency.index', compact('currencies'));
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $data = [
        //     'currency' =>  Category::all(),
        //     'sub_categories' => SubCategory::orderBy('id','desc')->get(),
        // ];
        return view('SuperAdmin.currency.create');
    }

   
    public function store(Request $request)
    {
        $request->validate([
            'country' => 'required',
            'currency_code' => 'required',
            'symbol' => 'required',
            'currency' => 'required',
        ]);

        $currency = new Currency();
        $currency->country = $request->country;
        $currency->currency_code = $request->currency_code;
        $currency->symbol = $request->symbol;
        $currency->currency = $request->currency;


        try {
            $currency->save();
            return response()->json([
                'type' => 'success',
                'message' => 'Currency created successfully',
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'type' => 'error',
                'message' => 'Opps somthing went wrong. ' . $exception->getMessage(),
            ]);
        }

    }

 
    public function show(User $admin)
    {
        //
    }

  
    public function edit($id)
    {
        $currencies = Currency::find($id);
        $data['currency'] = $currencies;
        return view('SuperAdmin.currency.edit',$data);

    }
    

    public function update(Request $request, $id)
    {
        $request->validate([
            'country' => 'required',
            'currency_code' => 'required',
            'symbol' => 'required',
            'currency' => 'required',
        ]);

        // return $request->sub_category_id;

        $currency = Currency::findOrFail($id);
        $currency->country = $request->country;
        $currency->currency_code = $request->currency_code;
        $currency->symbol = $request->symbol;
        $currency->currency = $request->currency;

        // $currency->fill($request->except('_token'));

        
        try {
            $currency->save();
            if($currency){
                return response()->json([
                    'success' => true,
                    'message' => 'Currency Updated Successfully'
                ]);
            }
        } catch (\Exception $exception) {
            return response()->json([
                'type' => 'error',
                'message' => 'Opps somthing went wrong. ' . $exception->getMessage(),
            ]);
        }
    }


    public function destroy($id)
    {
        $currency = Currency::findOrFail($id);

        try {
            $currency->delete();
            return response()->json([
                'type' => 'success',
                'message' => 'Successfully Deleted'
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'type' => 'error',
                'message' => $exception->getMessage()
            ]);
        }
    }

    public function activeNow($id)
    {
        $user = Currency::findOrFail($id);
        $user->status = 1;
        try {
            $user->save();
            return response()->json([
                'type' => 'success',
                'message' => 'Successfully Updated'
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'type' => 'error',
                'message' => $exception->getMessage()
            ]);
        }
    }

    public function inactiveNow($id)
    {
        $user = Currency::findOrFail($id);
        $user->status = 0;
        try {
            $user->save();
            return response()->json([
                'type' => 'success',
                'message' => 'Successfully Updated'
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'type' => 'error',
                'message' => $exception->getMessage()
            ]);
        }
    }
}
