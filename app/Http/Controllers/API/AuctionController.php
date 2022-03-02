<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Auction;
use App\Models\Bidding;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuctionController extends Controller
{
    public function addProduct(Request $request)
    {
       return response()->json($request->all());
       
        $request->validate([

            'name' => 'required',
            'title' => 'required',
            'base_price' => 'required',
            'details' => 'required',
            'status' => 'required',
        ]);
   
        $data = $request->except(['_token', 'product_image', 'banner']);

        if ($request->hasFile('product_image')) {

                $images = [];
        foreach($request->file('product_image') as $image)
        {
            $destinationPath = 'uploads/images/auction';
            $filename = $image->getClientOriginalName();
            $image->move($destinationPath, $filename);
            $product_images = array_push($images, $filename);
            $data['product_image'] = $product_images;     

        }

            /* $file        = $request->file('product_image');
            $path        = 'uploads/images/auction';
            $file_name   = time() . rand('0000', '9999') . '.' . $file->getClientOriginalName();
            $file->move($path, $file_name);
            $data['product_image'] = $path . '/' . $file_name; */
        }

        if ($request->hasFile('banner')) {
            $file        = $request->file('banner');
            $path        = 'uploads/images/auction';
            $file_name   = time() . rand('0000', '9999') . '.' . $file->getClientOriginalName();
            $file->move($path, $file_name);
            $data['banner'] = $path . '/' . $file_name;
        }
  
        $product = Auction::create($data);

        return response()->json($product);
    }

    public function allProduct()
    {

        $products = Auction::all();
        return response()->json([
            'status' => '200',
            'product' => $products
        ]);
    }

    public function showProduct($id)
    {

        $product = Auction::find($id);

        return response()->json([
            'status' => '200',
            'product' => $product
        ]);
    }

    public function totalProduct()
    {

        $product = Auction::count();
        return response()->json($product);
    }
    public function pendingProduct()
    {

        $product = Auction::where('status', 0)->count();
        return response()->json([
            'status' => 200,
            'product' => $product,
        ]);
    }

    public function soldProduct()
    {

        $product = Auction::where('product_status', 1)->count();
        return response()->json([
            'status' => 200,
            'product' => $product,
        ]);
    }

    public function unSoldProduct()
    {

        $product = Auction::where('product_status', 0)->count();
        return response()->json([
            'status' => 200,
            'product' => $product,
        ]);
    }

    public function bidNow(Request $request, $id)
    {
        $user = User::find($id);
        if (Hash::check($request->password, $user->password)) {
            $bidding = Bidding::create([

                'user_id' => $user->id,
                'name' => $user->first_name,
                'amount' => $request->amount,
            ]);
            return response()->json([

                'status' => 200,
                'data' => $bidding,
            ]);

        }
        else{
            return response()->json([
                'status' =>201,
                'message' => 'Passowrd Not Match'
            ]);
        } 
    }
}
