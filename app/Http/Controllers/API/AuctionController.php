<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Auction;
use App\Models\Bidding;
use App\Models\Notification;
use App\Models\SuperStar;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class AuctionController extends Controller
{

    public function addProduct(Request $request)

    {


        $validator = Validator::make($request->all(), [

            'title' => 'required',
            'keyword' => 'required',
            'bid_from' => 'required',
            'bid_to' => 'required',
            'product_image' => 'required|image',
            'banner' => 'required|image',
            'details' => 'required|min:10',
            'base_price' => 'required',
            'star_id' => 'required',

        ], [
            'title.required' => 'Title Field Is Required',
            'keyword.required' => 'Keyword Field Is Required',
            'bid_from.required' => 'Date Field Is Required',
            'bid_to.required' => 'Date Field Is Required',
            'details.required' => 'Description Field Is Required',
            'product_image.required' => "Image Field Is Required",
            'banner.required' => "Image Field Is Required",
            'base_price.required' => "Price Field Is Required",
            'star_id.required' => "Superstar Field Is Required",
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 402,
                'errors' => $validator->errors(),
            ]);
        }

        $data = $request->except(['_token', 'product_image', 'banner']);
        $data['created_by_id'] = Auth::user()->id;
        $data['admin_id'] = Auth::user()->id;

        if ($request->star_id) {
            $star = SuperStar::where('star_id', $request->star_id)->first();
        }
        $data['category_id'] = $star->category_id;
        $data['subcategory_id'] = $star->sub_category_id;

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
        $validator = Validator::make($request->all(), [

            'title' => 'required',
            'keyword' => 'required',
            'bid_from' => 'required',
            'bid_to' => 'required',
            'result_date' => 'required',
            'product_delivery_date' => 'required',
            'details' => 'required|min:10',
            'base_price' => 'required',
            'star_id' => 'required',
        ], [
            'title.required' => 'Title Field Is Required',
            'bid_from.required' => 'Date Field Is Required',
            'bid_to.required' => 'Date Field Is Required',
            'result_date.required' => 'Date Field Is Required',
            'product_delivery_date.required' => 'Date Field Is Required',
            'details.required' => 'Description Field Is Required',
            'base_price.required' => "Price Field Is Required",
            'star_id.required' => "Superstar Field Is Required",
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 402,
                'errors' => $validator->errors(),
            ]);
        }


        $product = Auction::findOrFail($id);

        $data = $request->all();

        if ($request->star_id) {
            $star = SuperStar::where('star_id', $request->star_id)->first();
        }
        $data['category_id'] = $star->category_id;
        $data['subcategory_id'] = $star->sub_category_id;



        if ($request->hasFile('product_image')) {

            $destination = $product->product_image;
            if (File::exists($destination)) {
                File::delete($destination);
            }

            $file        = $request->file('product_image');
            $path        = 'uploads/images/auction';
            $file_name   = time() . rand('0000', '9999') . '.' . $file->getClientOriginalName();
            $file->move($path, $file_name);
            $data['product_image'] = $path . '/' . $file_name;
        }

        if ($request->hasFile('banner')) {

            $destination = $product->banner;
            if (File::exists($destination)) {
                File::delete($destination);
            }

            $file        = $request->file('banner');
            $path        = 'uploads/images/auction';
            $file_name   = time() . rand('0000', '9999') . '.' . $file->getClientOriginalName();
            $file->move($path, $file_name);
            $data['banner'] = $path . '/' . $file_name;
        }

        // $product = Auction::findOrfail($id)->update([
        //     'name' => $request->name,
        //     'title' => $request->title,
        //     'base_price' => $request->base_price,
        //     //'details' => $request->status,
        //     'status' => $request->status,
        // ]);

        $product->update($data);


        return response()->json([
            'status' => 200,
            'products' => $product,
            'message' => 'success',
        ]);
    }

    public function allProduct()
    {

        $products = Auction::orderBy('id', 'DESC')->where('admin_id', auth()->user()->id)->all();
        return response()->json([
            'status' => '200',
            'product' => $products
        ]);
    }
    public function allLiveProduct()
    {
        $totolBidding = Bidding::count();
        $maxBidding = Bidding::max('amount');
        $products = Auction::with('bidding')->orderBy('id', 'DESC')->where('admin_id', auth()->user()->id)->where('status', 1)->get();

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

        $product = Auction::where('admin_id', auth()->user()->admin_id)->count();
        return response()->json($product);
    }
    public function pendingProduct()
    {

        $product = Auction::where([['status', 0], ['star_approval', '!=', 2]])->where('admin_id', auth()->user()->id)->count();
        $pending_product = Auction::orderBy('id', 'DESC')->where([['status', 0], ['star_approval', '!=', 2]])->where('admin_id', auth()->user()->id)->get();
        return response()->json([
            'status' => 200,
            'product' => $product,
            'pending_product' => $pending_product,
        ]);
    }

    public function soldProduct()
    {

        $product = Auction::where('product_status', 1)->where('admin_id', auth()->user()->id)->count();
        $sold_product = Auction::where('product_status', 1)->where('admin_id', auth()->user()->id)->get();
        return response()->json([
            'status' => 200,
            'product' => $product,
            'sold_product' => $sold_product,
        ]);
    }

    public function unSoldProduct()
    {

        $product = Auction::where('star_approval', 1)->where('product_status', 0)->where('admin_id', auth()->user()->id)->count();
        $unsold_product = Auction::orderBy('id', 'DESC')->where('star_approval', 1)->where('product_status', 0)->where('admin_id', auth()->user()->id)->get();
        return response()->json([
            'status' => 200,
            'product' => $product,
            'unsold_product' => $unsold_product,
        ]);
    }
    public function rejectedProduct()
    {

        $product = Auction::where('star_approval', 2)->where('product_status', 0)->where('admin_id', auth()->user()->id)->count();
        $rejectedProduct = Auction::orderBy('id', 'DESC')->where('star_approval', 2)->where('product_status', 0)->where('admin_id', auth()->user()->id)->get();
        return response()->json([
            'status' => 200,
            'product' => $product,
            'rejectedProduct' => $rejectedProduct,
        ]);
    }

    public function liveBidding($auction_id)
    {
        $bidding = Bidding::with('user')->orderBy('amount', 'DESC')->where('auction_id', $auction_id)->take(8)->get();
        return response()->json([
            'status' => 200,
            'bidding' => $bidding,
        ]);
    }
    public function topBidder($auction_id)
    {
        $topBidder = Bidding::with('user')->orderBy('amount', 'DESC')->where('auction_id', $auction_id)->where('notify_status', 1)->get();
        $bidding = Bidding::with('user')->orderBy('amount', 'DESC')->where('auction_id', $auction_id)->take(3)->get();
        return response()->json([
            'status' => 200,
            'bidding' => $bidding,
            'topBidder' => $topBidder,
        ]);
    }

    public function  allBidderList($id)
    {

        $bidderList = Bidding::with('user')->orderBy('amount', 'DESC')->where('auction_id', $id)->distinct('user_id')->get();
        // $users = Bidding::with('user')->where('auction_id',$id)->orderBy('amount','DESC')->get();
        // $bidderList = collect($users)->unique('user_id');

        $totalBidder = Bidding::with('user')->orderBy('amount', 'DESC')->where('auction_id', $id)->distinct('user_id')->count();

        return response()->json([
            'status' => 200,
            'bidderList' => $bidderList,
            'totalBidder' => $totalBidder,
        ]);
    }


    public function notify_bidder($id)
    {
        $bidding = Bidding::find($id);
        $bidding->notify_status = 1;
        $bidding->update();

        //Create New Notification
        $notification = new Notification();
        $notification->notification_id = 3;
        $notification->user_id = $bidding->user_id;
        $notification->save();

        return $notification;

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



        $validator = Validator::make($request->all(), [

            'title' => 'required',
            'keyword' => 'required',
            'bid_from' => 'required',
            'bid_to' => 'required',
            'product_image' => 'required|image',
            'banner' => 'required|image',
            'details' => 'required|min:10',
            'base_price' => 'required',

        ], [
            'title.required' => 'Title Field Is Required',
            'keyword.required' => 'Keyword Field Is Required',
            'bid_from.required' => 'Date Field Is Required',
            'bid_to.required' => 'Date Field Is Required',
            'details.required' => 'Description Field Is Required',
            'product_image.required' => "Image Field Is Required",
            'banner.required' => "Image Field Is Required",
            'base_price.required' => "Price Field Is Required",
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 402,
                'errors' => $validator->errors(),
            ]);
        }

        $data = $request->except(['_token', 'product_image', 'banner']);
        $data['star_approval'] = 1;
        $data['star_id'] = Auth::user()->id;
        $data['created_by_id'] = Auth::user()->id;
        $data['admin_id'] = Auth::user()->parent_user;
        $data['category_id'] = Auth::user()->category_id;
        $data['subcategory_id'] = Auth::user()->sub_category_id;



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

        $product = Auction::create($data);

        return response()->json($product);
    }
    public function star_editOrConfirm($id)
    {

        $product = Auction::find($id);
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
    public function decline($id)
    {


        Auction::where('id', $id)->update(['star_approval' => 2]);

        return response()->json([
            'status' => 200,
        ]);
    }



    public function star_updateProduct(Request $request, $id)
    {
        $product = Auction::findOrfail($id);

        $validator = Validator::make($request->all(), [

            'title' => 'required',
            'keyword' => 'required',
            'bid_from' => 'required',
            'bid_to' => 'required',
            'details' => 'required|min:10',
            'base_price' => 'required',
            'result_date' => 'required',
            'product_delivery_date' => 'required',

        ], [
            'title.required' => 'Title Field Is Required',
            'keyword.required' => 'Keyword Field Is Required',
            'bid_from.required' => 'Date Field Is Required',
            'bid_to.required' => 'Date Field Is Required',
            'details.required' => 'Description Field Is Required',
            'result_date.required' => 'This Field Is Required',
            'product_delivery_date.required' => 'This Field Is Required',
            'base_price.required' => "Price Field Is Required",
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 402,
                'errors' => $validator->errors(),
            ]);
        }

        if ($request->hasFile('product_image')) {

            $destination = $product->product_image;
            if (File::exists($destination)) {
                File::delete($destination);
            }

            $file        = $request->file('product_image');
            $path        = 'uploads/images/auction';
            $file_name   = time() . rand('0000', '9999') . '.' . $file->getClientOriginalName();
            $file->move($path, $file_name);
            $product['product_image'] = $path . '/' . $file_name;
        }

        if ($request->hasFile('banner')) {

            $destination = $product->banner;
            if (File::exists($destination)) {
                File::delete($destination);
            }

            $file        = $request->file('banner');
            $path        = 'uploads/images/auction';
            $file_name   = time() . rand('0000', '9999') . '.' . $file->getClientOriginalName();
            $file->move($path, $file_name);
            $product['banner'] = $path . '/' . $file_name;
        }
        if ($product) {
            $product->title = $request->title;
            $product->base_price = $request->base_price;
            $product->bid_from = $request->bid_from;
            $product->bid_to = $request->bid_to;
            $product->details = $request->details;
            $product->result_date = $request->result_date;
            $product->product_delivery_date = $request->product_delivery_date;
            $product->save();
        }

        // $product = Auction::findOrfail($id)->update([

        // ]);


        return response()->json([
            'status' => '200',
            'products' => $product,
            'message' => 'success',
        ]);
    }

    public function star_allProduct()
    {

        $products = Auction::orderBy('id', 'DESC')->where('star_id', auth()->user()->id)->all();
        return response()->json([
            'status' => '200',
            'product' => $products
        ]);
    }
    public function star_allLiveProduct()
    {
        $totolBidding = Bidding::count();
        $maxBidding = Bidding::max('amount');
        $products = Auction::with('bidding')->orderBy('id', 'DESC')->where('star_approval', 1)->where('product_status', 0)->where('star_id', auth()->user()->id)->get();

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

    public function auctionHomeMobile()
    {
        $pendingProducts = Auction::orderBy('id', 'DESC')->where('star_approval', 0)->where('star_id', auth()->user()->id)->get();
        $unsoldProducts = Auction::orderBy('id', 'DESC')->where('star_approval', 1)->where('product_status', 0)->where('star_id', auth()->user()->id)->get();
        $soldProducts = Auction::where('product_status', 1)->where('star_id', auth()->user()->id)->get();
        $liveProducts = Auction::with('bidding')->orderBy('id', 'DESC')->where('star_approval', 1)->where('product_status', 0)->where('star_id', auth()->user()->id)->get();

        return response()->json([
            'status' => '200',
            'liveProducts' => $liveProducts,
            'pendingProducts' => $pendingProducts,
            'soldProducts' => $soldProducts,
            'unsoldProducts' => $unsoldProducts
        ]);
    }

    public function star_totalProduct()
    {

        $product = Auction::where('star_id', auth()->user()->id)->count();
        return response()->json($product);
    }
    public function star_pendingProduct()
    {

        $product = Auction::orderBy('id', 'DESC')->where('star_approval', 0)->where('star_id', auth()->user()->id)->count();
        return response()->json([
            'status' => 200,
            'product' => $product,
        ]);
    }
    public function star_pendingProductList()
    {

        $products = Auction::orderBy('id', 'DESC')->where('star_approval', 0)->where('star_id', auth()->user()->id)->get();
        return response()->json([
            'status' => 200,
            'products' => $products,
        ]);
    }
    public function star_unSoldProductList()
    {

        $products = Auction::orderBy('id', 'DESC')->where('star_approval', 1)->where('product_status', 0)->where('star_id', auth()->user()->id)->get();
        return response()->json([
            'status' => 200,
            'products' => $products,
        ]);
    }
    public function star_soldProductList()
    {

        $products = Auction::where('product_status', 1)->where('star_id', auth()->user()->id)->get();
        return response()->json([
            'status' => 200,
            'products' => $products,
        ]);
    }

    public function star_soldProduct()
    {

        $product = Auction::where('product_status', 1)->where('star_id', auth()->user()->id)->count();
        return response()->json([
            'status' => 200,
            'product' => $product,
        ]);
    }

    public function star_unSoldProduct()
    {

        $product = Auction::where('star_approval', 1)->where('product_status', 0)->where('star_id', auth()->user()->id)->count();
        return response()->json([
            'status' => 200,
            'product' => $product,
        ]);
    }
    public function makeWinner($id)
    {

        $winner = Bidding::findOrFail($id);

        $winner->win_status = 1;
        $winner->update();

        if ($winner) {
            $auctionSold = Auction::where('id', $winner->auction_id)->first();
            $auctionSold->product_status = 1;
        }
        $auctionSold->update();


        return response()->json([
            'status' => 200,
            'winner' => $winner,
        ]);
    }
}
