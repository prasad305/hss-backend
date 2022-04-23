<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Auction;
use App\Models\Bidding;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;

class AuctionController extends Controller
{

    public function addProduct(Request $request)

    {

        // $data = $request->only('name','email','mobile_number');
        // $test['token'] = time();
        // $test['name'] = json_encode($data);
        // Auction::insert($test);
        // return response()->json('Great! Successfully store data in json format in datbase');

        //return response()->json($request->all());



        $request->validate([

            'name' => 'required',
            'title' => 'required',
            'base_price' => 'required',
            'details' => 'required',
            'status' => 'required',
        ]);

        $data = $request->except(['_token', 'product_image', 'banner']);
        $data['created_by_id'] = Auth::user()->id;

        if ($request->hasFile('product_image')) {

            // $name = time().'.' . explode('/', explode(':', substr($request->product_image, 0, strpos($request->product_image, ';')))[1])[1];
            // Image::make($request->product_image)->save(public_path('uploads/images/auction').$name);
            // return response()->json("OK");

            /*         $images = [];
        foreach($request->file('product_image') as $image)
        {
            $destinationPath = 'uploads/images/auction';
            $filename = $image->getClientOriginalName();
            $image->move($destinationPath, $filename);
            array_push($images, $filename);

        }
        $data['product_image'] = json_encode($images);
 */
            $file        = $request->file('product_image');
            $path        = 'uploads/images/auction';
            $file_name   = time() . rand('0000', '9999') . '.' . $file->getClientOriginalName();
            $file->move($path, $file_name);
            $data['product_image'] = $path . '/' . $file_name;
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
    public function editOrConfirm()
    {

        $product = Auction::latest()->first();
        return response()->json([
            'status' => 200,
            'product' => $product
        ]);
    }
    public function editProduct($id)
    {
        $product = Auction::findOrFail($id);
        return response()->json([
            'status' => 200,
            'product' => $product

        ]);
    }

    public function updateProduct(Request $request, $id)
    {
        // $request->validate([
        //     'name' => 'required',
        //     'title' => 'required',
        //     'base_price' => 'required',
        //     'status' => 'required',
        // ]);


        if ($request->hasFile('product_image')) {
            $file        = $request->file('product_image');
            $path        = 'uploads/images/auction';
            $file_name   = time() . rand('0000', '9999') . '.' . $file->getClientOriginalName();
            $file->move($path, $file_name);
            $data['product_image'] = $path . '/' . $file_name;
        }

        if ($request->hasFile('banner')) {
            $file        = $request->file('banner');
            $path        = 'uploads/images/auction';
            $file_name   = time() . rand('0000', '9999') . '.' . $file->getClientOriginalName();
            $file->move($path, $file_name);
            $data['banner'] = $path . '/' . $file_name;
        }

        $product = Auction::findOrfail($id)->update([
            'name' => $request->name,
            'title' => $request->title,
            'base_price' => $request->base_price,
            //'details' => $request->status,
            'status' => $request->status,
        ]);


        return response()->json([
            'status' => '200',
            'products' => $product,
            'message' => 'success',
        ]);
    }

    public function allProduct()
    {

        $products = Auction::all();
        return response()->json([
            'status' => '200',
            'product' => $products
        ]);
    }
    public function allLiveProduct()
    {
        $totolBidding = Bidding::count();
        $maxBidding = Bidding::max('amount');
        $products = Auction::with('bidding')->orderBy('id', 'DESC')->where('status', 1)->get();

        return response()->json([
            'status' => '200',
            'products' => $products,
            'totolBidding' => $totolBidding,
            'maxBidding' => $maxBidding
        ]);
    }


    public function showProductDetails($id)
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
        $pending_product = Auction::orderBy('id', 'DESC')->where('status', 0)->get();
        return response()->json([
            'status' => 200,
            'product' => $product,
            'pending_product' => $pending_product,
        ]);
    }

    public function soldProduct()
    {

        $product = Auction::where('product_status', 1)->count();
        $sold_product = Auction::where('product_status', 1)->get();
        return response()->json([
            'status' => 200,
            'product' => $product,
            'sold_product' => $sold_product,
        ]);
    }

    public function unSoldProduct()
    {

        $product = Auction::where('star_approval', 1)->where('product_status', 0)->count();
        $unsold_product = Auction::orderBy('id', 'DESC')->where('star_approval', 1)->where('product_status', 0)->get();
        return response()->json([
            'status' => 200,
            'product' => $product,
            'unsold_product' => $unsold_product,
        ]);
    }

    public function liveBidding($auction_id)
    {
        $bidding = Bidding::with('user')->orderBy('amount', 'DESC')->where('auction_id', $auction_id)->take(6)->get();
        return response()->json([
            'status' => 200,
            'bidding' => $bidding,
        ]);
    }
    public function topBidder($auction_id)
    {
        $bidding = Bidding::with('user')->orderBy('amount', 'DESC')->where('auction_id', $auction_id)->take(3)->get();
        return response()->json([
            'status' => 200,
            'bidding' => $bidding,
        ]);
    }

    public function notify_bidder($id)
    {
        $bidding = Bidding::find($id);
        $bidding->notify_status = 1;
        $bidding->update();

        return response()->json([
            'status' => 200,
        ]);
    }



    //<========================= Star Section ==============================>



    public function star_addProduct(Request $request)

    {

        // $data = $request->only('name','email','mobile_number');
        // $test['token'] = time();
        // $test['name'] = json_encode($data);
        // Auction::insert($test);
        // return response()->json('Great! Successfully store data in json format in datbase');

        //return response()->json($request->all());



        $request->validate([

            'name' => 'required',
            'title' => 'required',
            'base_price' => 'required',
            'details' => 'required',
            'status' => 'required',

        ]);

        $data = $request->except(['_token', 'product_image', 'banner']);
        $data['star_approval'] = 1;
        $data['star_id'] = Auth::user()->id;
        $data['created_by_id'] = Auth::user()->id;


        if ($request->hasFile('product_image')) {

            // $name = time().'.' . explode('/', explode(':', substr($request->product_image, 0, strpos($request->product_image, ';')))[1])[1];
            // Image::make($request->product_image)->save(public_path('uploads/images/auction').$name);
            // return response()->json("OK");

            /*         $images = [];
        foreach($request->file('product_image') as $image)
        {
            $destinationPath = 'uploads/images/auction';
            $filename = $image->getClientOriginalName();
            $image->move($destinationPath, $filename);
            array_push($images, $filename);

        }
        $data['product_image'] = json_encode($images);
 */
            $file        = $request->file('product_image');
            $path        = 'uploads/images/auction';
            $file_name   = time() . rand('0000', '9999') . '.' . $file->getClientOriginalName();
            $file->move($path, $file_name);
            $data['product_image'] = $path . '/' . $file_name;
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
    public function star_editOrConfirm()
    {

        $product = Auction::latest()->first();
        return response()->json([
            'status' => 200,
            'product' => $product
        ]);
    }
    public function star_editProduct($id)
    {
        $product = Auction::findOrFail($id);
        return response()->json([
            'status' => 200,
            'product' => $product

        ]);
    }
    public function star_approvedOrDecline($id)
    {

        $product = Auction::findOrFail($id);
        return response()->json([
            'status' => 200,
            'product' => $product

        ]);
    }

    public function star_approved($id)
    {


        Auction::where('id', $id)->update(['star_approval' => 1]);

        return response()->json([
            'status' => 200,
        ]);
    }


    public function star_updateProduct(Request $request, $id)
    {

        if ($request->hasFile('product_image')) {
            $file        = $request->file('product_image');
            $path        = 'uploads/images/auction';
            $file_name   = time() . rand('0000', '9999') . '.' . $file->getClientOriginalName();
            $file->move($path, $file_name);
            $data['product_image'] = $path . '/' . $file_name;
        }

        if ($request->hasFile('banner')) {
            $file        = $request->file('banner');
            $path        = 'uploads/images/auction';
            $file_name   = time() . rand('0000', '9999') . '.' . $file->getClientOriginalName();
            $file->move($path, $file_name);
            $data['banner'] = $path . '/' . $file_name;
        }

        $product = Auction::findOrfail($id)->update([
            'name' => $request->name,
            'title' => $request->title,
            'base_price' => $request->base_price,
            //'details' => $request->status,
            'status' => $request->status,
        ]);


        return response()->json([
            'status' => '200',
            'products' => $product,
            'message' => 'success',
        ]);
    }

    public function star_allProduct()
    {

        $products = Auction::all();
        return response()->json([
            'status' => '200',
            'product' => $products
        ]);
    }
    public function star_allLiveProduct()
    {
        $totolBidding = Bidding::count();
        $maxBidding = Bidding::max('amount');
        $products = Auction::with('bidding')->orderBy('id', 'DESC')->where('star_approval', 1)->where('product_status', 0)->get();

        return response()->json([
            'status' => '200',
            'products' => $products,
            'totolBidding' => $totolBidding,
            'maxBidding' => $maxBidding
        ]);
    }


    public function star_showProduct($id)
    {

        $product = Auction::find($id);

        return response()->json([
            'status' => '200',
            'product' => $product
        ]);
    }

    public function star_totalProduct()
    {

        $product = Auction::count();
        return response()->json($product);
    }
    public function star_pendingProduct()
    {

        $product = Auction::where('star_approval', 0)->count();
        return response()->json([
            'status' => 200,
            'product' => $product,
        ]);
    }
    public function star_pendingProductList()
    {

        $products = Auction::where('star_approval', 0)->get();
        return response()->json([
            'status' => 200,
            'products' => $products,
        ]);
    }
    public function star_unSoldProductList()
    {

        $products = Auction::orderBy('id', 'DESC')->where('star_approval', 1)->where('product_status', 0)->get();
        return response()->json([
            'status' => 200,
            'products' => $products,
        ]);
    }
    public function star_soldProductList()
    {

        $products = Auction::where('product_status', 1)->get();
        return response()->json([
            'status' => 200,
            'products' => $products,
        ]);
    }

    public function star_soldProduct()
    {

        $product = Auction::where('product_status', 1)->count();
        return response()->json([
            'status' => 200,
            'product' => $product,
        ]);
    }

    public function star_unSoldProduct()
    {

        $product = Auction::where('star_approval', 1)->where('product_status', 0)->count();
        return response()->json([
            'status' => 200,
            'product' => $product,
        ]);
    }
}
