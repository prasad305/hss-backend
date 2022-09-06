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
        $currency->currency_value = $request->currency_value;
        $currency->country_code = $request->country_code;
        $currency->currency_value = $request->currency_value;


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
        $currency->currency_value = $request->currency_value;
        $currency->country_code = $request->country_code;
        $currency->currency_value = $request->currency_value;

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
    public function currencyChanges()
    {
        $currencyValue = Currency::where('currency_code', '!=', 'USD')->latest()->get();

        foreach($currencyValue as $key=> $currency){
            // return $currency->currency_value;
            

            $amount= 1;
            $from= "USD";
            $to= $currency->currency_code;

            $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.apilayer.com/fixer/convert?to={$to}&from={$from}&amount={$amount}",
            CURLOPT_HTTPHEADER => array(
                "Content-Type: text/plain",
                "apikey: K4yuAxX9TMxd7sSM0ZswVx7jUjJw3Zum"
            ),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET"
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            $currency->currency_value = json_decode($response)->result;
            $currency->save();

        }

        try {
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
