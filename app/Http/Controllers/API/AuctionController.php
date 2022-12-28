<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Auction;
use App\Models\Bidding;
use App\Models\Notification;
use App\Models\SuperStar;
use App\Models\User;
use App\Models\NotificationText;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;
use App\Mail\PostNotification;
use Illuminate\Support\Facades\Mail;

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
            'result_date' => 'required',
            'product_delivery_date' => 'required',

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
            'result_date.required' => "Result Filed is Required",
            'product_delivery_date.required' => "Delivery Field is Required",
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
            $star = User::find($request->star_id);
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

        if ($product) {
            $starInfo = getStarInfo($request->star_id);
            $senderInfo = getAdminInfo($data['admin_id']);
            Mail::to($starInfo->email)->send(new PostNotification($product, $senderInfo));
        }
        return response()->json([
            'status' => 200,
            'productId' => $product->id,
        ]);
        // return response()->json($product);
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
            $star = User::find($request->star_id);
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
        $bidding = Bidding::with('user')->orderBy('amount', 'DESC')->where([['auction_id', $auction_id], ['applied_status', '!=', 2]])->take(1)->get();
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


    public function notify_bidder(Request $request)
    {
        $bidding = Bidding::find($request->bidding_id);
        $bidding->notify_status = 1;
        $bidding->payment_last_date = Carbon::parse($request->payment_last_date);
        $bidding->update();

        //Create New Notification

        $text = new NotificationText();
        $text->text = 'Please Make Payment';
        $text->type = "auction";
        $text->save();


        $notification = new Notification();
        $notification->notification_id = $text->id;
        $notification->user_id = $bidding->user_id;
        $notification->event_id = $bidding->auction_id;
        $notification->save();



        // return $notification;

        return response()->json([
            'status' => 200,
        ]);
    }



    //<========================= Star Section ==============================>


    public function star_addProduct_mobile(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'title' => 'required',
            'keyword' => 'required',
            'bid_from' => 'required',
            'bid_to' => 'required',
            // 'product_image' => 'required|image',
            // 'banner' => 'required|image',
            'details' => 'required|min:10',
            'base_price' => 'required',

        ], [
            'title.required' => 'Title Field Is Required',
            'keyword.required' => 'Keyword Field Is Required',
            'bid_from.required' => 'Date Field Is Required',
            'bid_to.required' => 'Date Field Is Required',
            'details.required' => 'Description Field Is Required',
            // 'product_image.required' => "Image Field Is Required",
            // 'banner.required' => "Image Field Is Required",
            'base_price.required' => "Price Field Is Required",
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 402,
                'errors' => $validator->errors(),
            ]);
        }

        $auction = new Auction();

        $auction->title = $request->title;
        $auction->keyword = $request->keyword;
        $auction->bid_from = Carbon::parse($request->bid_from);
        $auction->bid_to = Carbon::parse($request->bid_to);
        $auction->result_date = Carbon::parse($request->result_date);
        $auction->product_delivery_date = Carbon::parse($request->product_delivery_date);
        $auction->details = $request->details;
        $auction->base_price = $request->base_price;
        $auction->star_approval = 1;
        $auction->star_id = Auth::user()->id;
        $auction->created_by_id = Auth::user()->id;
        $auction->admin_id = Auth::user()->parent_user;
        $auction->category_id = Auth::user()->category_id;
        $auction->subcategory_id = Auth::user()->sub_category_id;

        //Upload Banner
        if ($request->bannerImage['type']) {
            try {
                $originalExtension = str_ireplace("image/", "", $request->bannerImage['type']);

                $folder_path       = 'uploads/images/auction/';

                $image_new_name    = Str::random(20) . '-' . now()->timestamp . '.' . $originalExtension;
                $decodedBase64 = $request->bannerImage['data'];

                Image::make($decodedBase64)->save($folder_path . $image_new_name);
                $location = $folder_path . $image_new_name;
                $auction->banner = $location;
            } catch (\Exception $exception) {
                return response()->json([
                    "error" => $exception->getMessage(),
                    "status" => "from image banner",
                ]);
            }
        }
        //Upload Product_image
        if ($request->productImage['type']) {
            try {
                $originalExtension = str_ireplace("image/", "", $request->productImage['type']);

                $folder_path       = 'uploads/images/auction/';

                $image_new_name    = Str::random(20) . '-' . now()->timestamp . '.' . $originalExtension;
                $decodedBase64 = $request->productImage['data'];

                Image::make($decodedBase64)->save($folder_path . $image_new_name);
                $location = $folder_path . $image_new_name;
                $auction->product_image = $location;
            } catch (\Exception $exception) {
                return response()->json([
                    "error" => $exception->getMessage(),
                    "status" => "from image productImage",
                ]);
            }
        }


        $addFromMobile = $auction->save();
        if ($addFromMobile) {
            $managerInfo = getManagerInfoFromCategory(auth('sanctum')->user()->category_id);
            $adminInfo = getAdminInfo(auth('sanctum')->user()->parent_user);
            $senderInfo = getStarInfo(auth('sanctum')->user()->id);

            Mail::to($adminInfo->email)->send(new PostNotification($auction, $senderInfo));
            Mail::to($managerInfo->email)->send(new PostNotification($auction, $senderInfo));
        }



        return response()->json([
            'status' => 200,
            'message' => 'Marketplace Added Successfully',
        ]);
    }



    public function star_addProduct(Request $request)

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
            'result_date' => 'required',
            'product_delivery_date' => 'required',

        ], [
            'title.required' => 'Title Field Is Required',
            'keyword.required' => 'Keyword Field Is Required',
            'bid_from.required' => 'Date Field Is Required',
            'bid_to.required' => 'Date Field Is Required',
            'details.required' => 'Description Field Is Required',
            'product_image.required' => "Image Field Is Required",
            'banner.required' => "Image Field Is Required",
            'base_price.required' => "Price Field Is Required",
            'result_date.required' => "Result Filed is Required",
            'product_delivery_date.required' => "Delivery Field is Required",
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

        if ($product) {
            $managerInfo = getManagerInfoFromCategory(auth('sanctum')->user()->category_id);
            $adminInfo = getAdminInfo(auth('sanctum')->user()->parent_user);
            $senderInfo = getStarInfo(auth('sanctum')->user()->id);

            Mail::to($adminInfo->email)->send(new PostNotification($product, $senderInfo));
            Mail::to($managerInfo->email)->send(new PostNotification($product, $senderInfo));
        }
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


        // Auction::where('id', $id)->update(['star_approval' => 1]);

        $auction = Auction::find($id);
        $auction->star_approval = 1;
        $approveStar = $auction->update();

        if ($approveStar) {
            $managerInfo = getManagerInfoFromCategory(auth('sanctum')->user()->category_id);
            $senderInfo = getStarInfo(auth('sanctum')->user()->id);
            Mail::to($managerInfo->email)->send(new PostNotification($auction, $senderInfo));
        }


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
    public function rejectBidder($id)
    {

        $rejected = Bidding::where('user_id', $id)->update([
            'applied_status' => 2,
        ]);

        return response()->json([
            'status' => 200,
            'rejected' => $rejected,
        ]);
    }
    public function bidderInfo($id)
    {

        $bidderInfo = Bidding::find($id);

        return response()->json([
            'status' => 200,
            'bidderInfo' => $bidderInfo,
        ]);
    }
}
