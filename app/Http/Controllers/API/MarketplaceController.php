<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Marketplace;
use App\Models\User;
use App\Models\Country;
use App\Models\State;
use App\Models\MarketplaceOrder;
use App\Models\City;
use App\Models\ChoiceList;
use App\Models\Activity;
use App\Models\DeliveryCharge;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManagerStatic as Image;

class MarketplaceController extends Controller
{
    public function MarketplaceProductMobile()
    {

        $pending = Marketplace::orderBy('id', 'DESC')->where('status', 0)
            ->where('superstar_id', Auth::user()->id)
            ->get();
        $approved = Marketplace::orderBy('id', 'DESC')->where('status', 1)
            ->where('superstar_id', Auth::user()->id)
            ->get();
        return response()->json([
            'status' => 200,
            'pending' => $pending,
            'approved' => $approved,
        ]);
    }
    // Marketplace Homepage

    public function marketplaceAll()
    {
        // $data = Marketplace::where('status', 1)
        //                     ->where('post_status', 1)
        //                     ->get();

        // $id = auth('sanctum')->user()->id;
        // $selectedCategory = ChoiceList::where('user_id', $id)->first();

        // // return $selectedCategory;

        // $selectedCat = json_decode($selectedCategory->category);
        // $selectedSubCat = json_decode($selectedCategory->subcategory);
        // $selectedSubSubCat = json_decode($selectedCategory->star_id);

        // $cat_post = Marketplace::select("*")
        //     ->whereIn('category_id', $selectedCat)
        //     ->whereColumn('total_items', '>', 'total_selling')
        //     ->where('post_status', 1)
        //     ->where('status', 1)
        //     ->latest()->get();

        // $sub_cat_post = Marketplace::select("*")
        //     ->whereIn('subcategory_id', $selectedSubCat)
        //     ->whereColumn('total_items', '>', 'total_selling')
        //     ->where('post_status', 1)
        //     ->where('status', 1)
        //     ->latest()->get();

        // $sub_sub_cat_post = Marketplace::select("*")
        //     ->whereIn('superstar_id', $selectedSubSubCat)
        //     ->whereColumn('total_items', '>', 'total_selling')
        //     ->where('post_status', 1)
        //     ->where('status', 1)
        //     ->latest()->get();

        // if($cat_post) {
        //     $cat_post = $cat_post;
        // } else {
        //     $cat_post = [];
        // }

        // if($sub_cat_post) {
        //     $sub_cat_post = $sub_cat_post;
        // } else {
        //     $sub_cat_post = [];
        // }

        // if($sub_sub_cat_post) {
        //     $sub_sub_cat_post = $sub_sub_cat_post;
        // } else {
        //     $sub_sub_cat_post = [];
        // }



        // $data = $cat_post->concat($sub_cat_post)->concat($sub_sub_cat_post);

        // if($data){
        //     $data = $data;
        // }else{
        //     $data = [];
        // }

        // return response()->json([
        //         'status' => 200,
        //         'data' => $data,
        //     ]);




        $id = auth('sanctum')->user()->id;
        $selectedCategory = ChoiceList::where('user_id', $id)->first();

        $selectedCat = json_decode($selectedCategory->category);
        $selectedSubCat = json_decode($selectedCategory->subcategory);
        $selectedSubSubCat = json_decode($selectedCategory->star_id);

        $cat_post = Marketplace::with(['superstar'])->select("*")
            ->whereIn('category_id', $selectedCat)
            ->whereColumn('total_items', '>', 'total_selling')
            ->where('post_status', 1)
            ->where('status', 1)
            ->latest()->get();

        if (isset($sub_cat_post)) {
            $sub_cat_post = Marketplace::with(['superstar'])->select("*")
                ->whereIn('subcategory_id', $selectedSubCat)
                ->whereColumn('total_items', '>', 'total_selling')
                ->where('post_status', 1)
                ->where('status', 1)
                ->latest()->get();
        } else {
            $sub_cat_post = [];
        }

        if (isset($sub_sub_cat_post)) {
            $sub_sub_cat_post = Marketplace::with(['superstar'])->select("*")
                ->whereIn('superstar_id', $selectedSubSubCat)
                ->whereColumn('total_items', '>', 'total_selling')
                ->where('post_status', 1)
                ->where('status', 1)
                ->latest()->get();
        } else {
            $sub_sub_cat_post = [];
        }

        $data = $cat_post->concat($sub_cat_post)->concat($sub_sub_cat_post);

        return response()->json([
            'status' => 200,
            'data' => $data
        ]);
    }


    public function marketplaceStarAll($starId)
    {
        $starMarketplace = Marketplace::with(['superstar'])->orderBy('id', 'DESC')->where([['superstar_id', $starId], ['status', 1]])
            ->get();

        return response()->json([
            'status' => 200,
            'starMarketplace' => $starMarketplace,
        ]);
    }

    public function viewCountry()
    {
        $data = Country::where('status', 1)
            ->get();

        return response()->json([
            'status' => 200,
            'data' => $data,
        ]);
    }
    public function viewState($id)
    {
        $country = Country::where('id', $id)->first();
        $state = State::where('country_id', $country->id)->get();

        return response()->json([
            'status' => 200,
            'state' => $state,
        ]);
    }
    public function viewCity($id)
    {
        $state = State::where('id', $id)->first();
        $city = City::where('state_id', $state->id)->get();

        return response()->json([
            'status' => 200,
            'city' => $city,
        ]);
    }
    public function getSlugDetails($slug)
    {
        $slugdetails = Marketplace::where('slug', $slug)->first();

        return response()->json([
            'status' => 200,
            'slugdetails' => $slugdetails,
        ]);
    }

    public function viewMarketplaceOrder(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'country_id' => 'required',
            'state_id' => 'required',
            'city_id' => 'required',
            'delivery_charge_id' => 'required',
            'area' => 'required',
            'phone' => 'required',
        ], [
            'country_id.required' => 'Country Name Is Required',
            'state_id.required' => "State Name Is Required",
            'city_id.required' => "City Name Is Required",
            'delivery_charge_id.required' => "Delivery charge is required",
            'area.required' => 'Area Field Is Required',
            'phone.required' => "Phone Field Is Required",
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 402,
                'errors' => $validator->errors(),
            ]);
        } else {
            $marketplace = Marketplace::where('slug', $request->marketplace_slug)->first();

            if ($marketplace->total_items >= $marketplace->total_selling + $request->items) {
                $date = (int) Carbon::now()->format('dmYHis');
                $rand = rand(100, 999) . $date;

                $data = new MarketplaceOrder();
                $totalTax = (($request->items * $request->unit_price) * $request->tax) / 100;
                $data->country_id = $request->country_id;
                $data->state_id = $request->state_id;
                $data->city_id = $request->city_id;
                $data->delivery_charge_id = $request->delivery_charge_id;
                $data->area = $request->area;
                $data->phone = $request->phone;


                $data->order_no = $rand;
                $data->items = $request->items;
                $data->unit_price = $request->unit_price;
                $data->tax = $totalTax;
                $data->user_id = Auth::user()->id;
                $data->marketplace_id = $marketplace->id;
                $data->superstar_id = $marketplace->superstar_id;
                $data->superstar_admin_id = $marketplace->superstar_admin_id;
                $delivery_charge = DeliveryCharge::find($request->delivery_charge_id); 
                $data->total_price = ($request->items * $request->unit_price) + $delivery_charge->courier_charge + $totalTax;
                $data->status = 1;

                $data->save();

                return response()->json([
                    'status' => 200,
                    'message' => 'Order submit Successfully',
                    'productOrderId' => $data->id
                ]);
            } else {
                return response()->json([
                    'status' => 218,
                    'message' => 'Not enough product',
                ]);
            }
        }
    }

    public function viewMarketplaceActivities()
    {
        $data = Activity::with(['marketPlace', 'marketPlaceOrder'])->where('user_id', Auth::user()->id)->where('type', 'marketplace')->latest()->get();
        // $data = MarketplaceOrder::where('user_id', Auth::user()->id)
        //     ->latest()
        //     ->get();

        return response()->json([
            'status' => 200,
            'data' => $data,
        ]);
    }

    //SuperStar Admin for marketplace

    public function marketplaceStore(Request $request)
    {

        $validator = Validator::make($request->all(), [

            'title' => 'required|unique:marketplaces',
            'category_id' => 'required',
            'description' => 'required',
            'keywords' => 'required',
            'terms_conditions' => 'required',
            'image' => 'required|image',
            'unit_price' => 'required',
            'total_items' => 'required',
            'superstar_id' => 'required',
            'subcategory_id' => 'required',
            'tax' => 'required',

        ], [
            'title.required' => 'Title Field Is Required',
            'title.unique' => 'This Title Already Exist',
            'category_id.required' => "Category Field Is Required",
            'subcategory_id.required' => "Subcategory Field Is Required",
            'description.required' => 'Description Field Is Required',
            'image.required' => "Image Field Is Required",
            'keywords.required' => "Keywords Field Is Required",
            'unit_price.required' => "Unit Price Field Is Required",
            'total_items.required' => "Total Item Field Is Required",
            'superstar_id.required' => "Superstar Field Is Required",
            'tax.required' => "Tax Field Is Required",
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 402,
                'errors' => $validator->errors(),
            ]);
        }
        $id = Auth::user()->id;
        $parent_id = User::find($id);


        $marketplace = new Marketplace();

        $marketplace->title = $request->title;
        $marketplace->category_id = $request->category_id;
        $marketplace->subcategory_id = $request->subcategory_id;
        $marketplace->slug = Str::slug($request->title);
        $marketplace->description = $request->description;
        $marketplace->tax = $request->tax;
        $marketplace->terms_conditions = $request->terms_conditions;
        $marketplace->unit_price = $request->unit_price;
        $marketplace->total_items = $request->total_items;
        $marketplace->keywords = $request->keywords;
        $marketplace->post_status = 0;
        $marketplace->status = 0;
        $marketplace->total_selling = 0;
        $marketplace->created_by_id = $id;
        $marketplace->superstar_id = $request->superstar_id;
        $marketplace->superstar_admin_id = $id;

        if ($request->hasfile('image')) {

            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = 'uploads/images/marketplace/' . time() . '.' . $extension;

            Image::make($file)->resize(400, 400)->save($filename, 100);
            $marketplace->image = $filename;
        }

        $adminAddResult = $marketplace->save();
        if ($adminAddResult) {
            $starInfo = getStarInfo($marketplace->superstar_id);
            $senderInfo = getAdminInfo($marketplace->superstar_admin_id);

            SendMail($starInfo->email, $marketplace, $senderInfo);
        }

        return response()->json([
            'status' => 200,
            'message' => 'Marketplace Added Successfully',
            'marketplaceId' => $marketplace->id,
        ]);
    }

    public function allProductList()
    {
        $approved = Marketplace::orderBy('id', 'DESC')->where('status', 1)
            ->where('superstar_admin_id', Auth::user()->id)
            ->get();
        $approvedCount = Marketplace::where('status', 1)
            ->where('superstar_admin_id', Auth::user()->id)
            ->count();

        return response()->json([
            'status' => 200,
            'approved' => $approved,
            'approvedCount' => $approvedCount,
        ]);
    }

    public function orderAdminProductList()
    {
        $totalOrder = MarketplaceOrder::with(['marketplace','user','star'])->where('superstar_admin_id', Auth::user()->id)
            ->count();
        $orderList = MarketplaceOrder::with(['marketplace','user','star'])->orderBy('id', 'DESC')->where('superstar_admin_id', Auth::user()->id)
            ->get();

        return response()->json([
            'status' => 200,
            'orderList' => $orderList,
            'totalOrder' => $totalOrder,
        ]);
    }

    public function orderAdminProductListView($id)
    {

        $orderListView = MarketplaceOrder::with(['marketplace','user','star','state', 'country', 'city','deliverycharge'])->find($id);

        return response()->json([
            'status' => 200,
            'orderListView' => $orderListView,
        ]);
    }

    public function orderAdminProductListStatus($status, $id)
    {

        $orderListStatus = MarketplaceOrder::find($id);
        $orderListStatus->status = $status;
        $orderListStatus->save();

        if ($orderListStatus->status == 2) {
            $marketplace = Marketplace::find($orderListStatus->marketplace_id);
            Marketplace::where('id', $marketplace->id)->update([
                'total_selling' => $marketplace->total_selling + $orderListStatus->items,
            ]);
        }


        return response()->json([
            'status' => 200,
            'message' => 'Order Status Updated',
        ]);
    }

    public function liveProductList()
    {
        $live = Marketplace::orderBy('id', 'DESC')->whereColumn('total_items', '>', 'total_selling')
            ->where('status', 1)
            ->where('superstar_admin_id', Auth::user()->id)
            ->where('post_status', 1)
            ->get();


        // $live = Marketplace::where('status', 1)->get();

        return response()->json([
            'status' => 200,
            'live' => $live,
        ]);
    }

    public function pendingProductList()
    {
        $pending = Marketplace::orderBy('id', 'DESC')->where('status', 0)
            ->where('superstar_admin_id', Auth::user()->id)
            ->get();
        $pendingCount = Marketplace::where('status', 0)
            ->where('superstar_admin_id', Auth::user()->id)
            ->count();

        return response()->json([
            'status' => 200,
            'pending' => $pending,
            'pendingCount' => $pendingCount,
        ]);
    }

    public function editAdminProductList($id)
    {
        $editData = Marketplace::find($id);

        return response()->json([
            'status' => 200,
            'editData' => $editData,
        ]);
    }
    public function storeAdminProductList(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [

            'title' => 'required|unique:marketplaces,title,' . $id,
            'description' => 'required',
            'keywords' => 'required',
            'unit_price' => 'required',
            'terms_conditions' => 'required',
            'total_items' => 'required',
            'tax' => 'required',

        ], [
            'title.required' => 'Title Field Is Required',
            'title.unique' => 'This Title Already Exist',
            'keywords.required' => 'Keywords Field Is Required',
            'description.required' => 'Description Field Is Required',
            'unit_price.required' => "Unit Price Field Is Required",
            'total_items.required' => "Total Item Field Is Required",
            'tax.required' => "Tax Field Is Required",
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 402,
                'errors' => $validator->errors(),
            ]);
        }
        $marketplace = Marketplace::find($id);

        $marketplace->title = $request->title;
        $marketplace->slug = Str::slug($request->title);
        $marketplace->description = $request->description;
        $marketplace->unit_price = $request->unit_price;
        $marketplace->tax = $request->tax;
        $marketplace->terms_conditions = $request->terms_conditions;
        $marketplace->total_items = $request->total_items;
        $marketplace->total_selling = $request->sellingItems;
        $marketplace->keywords = $request->keywords;

        if ($request->hasfile('image')) {
            $destination = $marketplace->image;
            if (File::exists($destination)) {
                File::delete($destination);
            }

            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = 'uploads/images/marketplace/' . time() . '.' . $extension;

            Image::make($file)->resize(400, 400)->save($filename, 100);
            $marketplace->image = $filename;
        }

        $marketplace->save();

        return response()->json([
            'status' => 200,
            'message' => 'Marketplace Updated Successfully',
        ]);
    }



    // SuperStar For Marketplace

    //mobile
    public function starMarketplaceStoreMobile(Request $request)
    {
        // return $request->all();
        $validator = Validator::make($request->all(), [

            'title' => 'required|unique:marketplaces',
            'description' => 'required',
            'keywords' => 'required',
            'terms_conditions' => 'required',
            'unit_price' => 'required',
            'total_items' => 'required',
            'tax' => 'required',
            'delivery_charge' => 'required',

        ], [
            'title.required' => 'Title Field Is Required',
            'title.unique' => 'This Title Already Exist',
            'description.required' => 'Description Field Is Required',
            'keywords.required' => 'Keywords Field Is Required',
            'image.required' => "Image Field Is Required",
            'unit_price.required' => "Unit Price Field Is Required",
            'total_items.required' => "Total Item Field Is Required",
            'tax.required' => "Tax Field Is Required",
            'delivery_charge.required' => "Delivery Charge Field Is Required",
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 402,
                'errors' => $validator->errors(),
            ]);
        }
        $id = Auth::user()->id;
        $parent_id = User::find($id);

        $marketplace = new Marketplace();

        $marketplace->title = $request->title;
        $marketplace->slug = Str::slug($request->title);
        $marketplace->description = $request->description;
        $marketplace->terms_conditions = $request->terms_conditions;
        $marketplace->delivery_charge = $request->delivery_charge;
        $marketplace->tax = $request->tax;
        $marketplace->unit_price = $request->unit_price;
        $marketplace->total_items = $request->total_items;
        $marketplace->keywords = $request->keywords;
        $marketplace->status = 0;
        $marketplace->post_status = 1;
        $marketplace->total_selling = 0;
        $marketplace->superstar_admin_id = $parent_id->parent_user;
        $marketplace->superstar_id = $id;
        $marketplace->created_by_id = $id;
        $marketplace->category_id = Auth::user()->category_id;
        $marketplace->subcategory_id = Auth::user()->sub_category_id;


        if ($request->image['type']) {
            try {
                $originalExtension = str_ireplace("image/", "", $request->image['type']);

                $folder_path       = 'uploads/images/marketplace/';

                $image_new_name    = Str::random(20) . '-' . now()->timestamp . '.' . $originalExtension;
                $decodedBase64 = $request->image['data'];

                Image::make($decodedBase64)->save($folder_path . $image_new_name);
                $location = $folder_path . $image_new_name;
                $marketplace->image = $location;
            } catch (\Exception $exception) {
                return response()->json([
                    "error" => $exception->getMessage(),
                    "status" => "from image",
                ]);
            }
        }


        $addFromMobile = $marketplace->save();
        if ($addFromMobile) {
            $managerInfo = getManagerInfoFromCategory(auth('sanctum')->user()->category_id);
            $adminInfo = getAdminInfo(auth('sanctum')->user()->parent_user);
            $senderInfo = getStarInfo(auth('sanctum')->user()->id);

            SendMail($adminInfo->email, $marketplace, $senderInfo);
            SendMail($managerInfo->email, $marketplace, $senderInfo);
        }

        return response()->json([
            'status' => 200,
            'message' => 'Product Added Successfully',
        ]);
    }

    public function starMarketplaceUpdateMobile(Request $request, $productId)
    {

        $validator = Validator::make($request->all(), [

            // 'title' => 'required|unique:marketplaces',
            'description' => 'required',
            'keywords' => 'required',
            'terms_conditions' => 'required',
            'unit_price' => 'required',
            'total_items' => 'required',
            'tax' => 'required',
            'delivery_charge' => 'required',

        ], [
            // 'title.required' => 'Title Field Is Required',
            'title.unique' => 'This Title Already Exist',
            'description.required' => 'Description Field Is Required',
            'keywords.required' => 'Keywords Field Is Required',
            'image.required' => "Image Field Is Required",
            'unit_price.required' => "Unit Price Field Is Required",
            'total_items.required' => "Total Item Field Is Required",
            'tax.required' => "Tax Field Is Required",
            'delivery_charge.required' => "Delivery Charge Field Is Required",
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 402,
                'errors' => $validator->errors(),
            ]);
        }
        $id = Auth::user()->id;
        $parent_id = User::find($id);

        $marketplace = Marketplace::find($productId);

        $marketplace->title = $request->title;
        $marketplace->slug = Str::slug($request->title);
        $marketplace->description = $request->description;
        $marketplace->terms_conditions = $request->terms_conditions;
        $marketplace->delivery_charge = $request->delivery_charge;
        $marketplace->tax = $request->tax;
        $marketplace->unit_price = $request->unit_price;
        $marketplace->total_items = $request->total_items;
        $marketplace->keywords = $request->keywords;
        $marketplace->status = 0;
        $marketplace->post_status = 1;
        $marketplace->total_selling = 0;
        $marketplace->superstar_admin_id = $parent_id->parent_user;
        $marketplace->superstar_id = $id;
        $marketplace->created_by_id = $id;
        $marketplace->category_id = Auth::user()->category_id;
        $marketplace->subcategory_id = Auth::user()->sub_category_id;


        if ($request->image['type']) {
            try {
                $originalExtension = str_ireplace("image/", "", $request->image['type']);

                $folder_path       = 'uploads/images/marketplace/';

                $image_new_name    = Str::random(20) . '-' . now()->timestamp . '.' . $originalExtension;
                $decodedBase64 = $request->image['data'];

                Image::make($decodedBase64)->save($folder_path . $image_new_name);
                $location = $folder_path . $image_new_name;
                $marketplace->image = $location;
            } catch (\Exception $exception) {
                return response()->json([
                    "error" => $exception->getMessage(),
                    "status" => "from image",
                ]);
            }
        }


        $addFromMobile = $marketplace->update();
        if ($addFromMobile) {
            $managerInfo = getManagerInfoFromCategory(auth('sanctum')->user()->category_id);
            $adminInfo = getAdminInfo(auth('sanctum')->user()->parent_user);
            $senderInfo = getStarInfo(auth('sanctum')->user()->id);

            SendMail($adminInfo->email, $marketplace, $senderInfo);
            SendMail($managerInfo->email, $marketplace, $senderInfo);
        }


        return response()->json([
            'status' => 200,
            'message' => 'Product Update Successfully',
        ]);
    }

    public function starMarketplaceStore(Request $request)
    {


        // return $request->all();
        $validator = Validator::make($request->all(), [

            'title' => 'required|unique:marketplaces',
            'description' => 'required',
            'keywords' => 'required',
            'terms_conditions' => 'required',
            'image' => 'required|image',
            'unit_price' => 'required',
            'total_items' => 'required',
            'tax' => 'required',

        ], [
            'title.required' => 'Title Field Is Required',
            'title.unique' => 'This Title Already Exist',
            'description.required' => 'Description Field Is Required',
            'keywords.required' => 'Keywords Field Is Required',
            'image.required' => "Image Field Is Required",
            'unit_price.required' => "Unit Price Field Is Required",
            'total_items.required' => "Total Item Field Is Required",
            'tax.required' => "Tax Field Is Required",
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 402,
                'errors' => $validator->errors(),
            ]);
        }
        $id = Auth::user()->id;
        $parent_id = User::find($id);

        $marketplace = new Marketplace();

        $marketplace->title = $request->title;
        $marketplace->slug = Str::slug($request->title);
        $marketplace->description = $request->description;
        $marketplace->terms_conditions = $request->terms_conditions;
        $marketplace->tax = $request->tax;
        $marketplace->unit_price = $request->unit_price;
        $marketplace->total_items = $request->total_items;
        $marketplace->keywords = $request->keywords;
        $marketplace->status = 0;
        $marketplace->post_status = 1;
        $marketplace->total_selling = 0;
        $marketplace->superstar_admin_id = $parent_id->parent_user;
        $marketplace->superstar_id = $id;
        $marketplace->created_by_id = $id;
        $marketplace->category_id = Auth::user()->category_id;
        $marketplace->subcategory_id = Auth::user()->sub_category_id;


        if ($request->hasfile('image')) {

            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = 'uploads/images/marketplace/' . time() . '.' . $extension;

            Image::make($file)->resize(400, 400)->save($filename, 100);
            $marketplace->image = $filename;
        }

        $starAddResult = $marketplace->save();
        if ($starAddResult) {
            $managerInfo = getManagerInfoFromCategory(auth('sanctum')->user()->category_id);
            $adminInfo = getAdminInfo(auth('sanctum')->user()->parent_user);
            $senderInfo = getStarInfo(auth('sanctum')->user()->id);

            SendMail($adminInfo->email, $marketplace, $senderInfo);
            SendMail($managerInfo->email, $marketplace, $senderInfo);
        }

        return response()->json([
            'status' => 200,
            'message' => 'Marketplace Added Successfully',
        ]);
    }



    public function allStarProductList()
    {
        $id = Auth::user()->id;
        $parent_id = User::find($id);

        $approved = Marketplace::orderBy('id', 'DESC')->where('status', 1)
            ->where('superstar_admin_id', $parent_id->parent_user)
            ->get();

        $approvedCount = Marketplace::where('status', 1)
            ->where('superstar_admin_id', $parent_id->parent_user)
            ->count();

        return response()->json([
            'status' => 200,
            'approved' => $approved,
            'approvedCount' => $approvedCount,
        ]);
    }

    public function liveStarProductList()
    {
        $id = Auth::user()->id;
        $parent_id = User::find($id);

        $live = Marketplace::orderBy('id', 'DESC')->whereColumn('total_items', '>', 'total_selling')
            ->where('status', 1)
            ->where('post_status', 1)
            ->where('superstar_admin_id', $parent_id->parent_user)
            ->get();


        // $live = Marketplace::where('status', 1)->get();

        return response()->json([
            'status' => 200,
            'live' => $live,
        ]);
    }

    public function pendingStarProductList()
    {
        $id = Auth::user()->id;
        $parent_id = User::find($id);

        $pending = Marketplace::orderBy('id', 'DESC')->where('status', 0)
            ->where('superstar_admin_id', $parent_id->parent_user)
            ->get();
        $pendingCount = Marketplace::where('status', 0)
            ->where('superstar_admin_id', $parent_id->parent_user)
            ->count();

        return response()->json([
            'status' => 200,
            'pending' => $pending,
            'pendingCount' => $pendingCount,
        ]);
    }

    public function editStarProductList($id)
    {
        $editData = Marketplace::find($id);

        return response()->json([
            'status' => 200,
            'editData' => $editData,
        ]);
    }

    public function storeStarProductList(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [

            'title' => 'required|unique:marketplaces,title,' . $id,
            'description' => 'required',
            'keywords' => 'required',
            'terms_conditions' => 'required',
            'unit_price' => 'required',
            'total_items' => 'required',
            'tax' => 'required',

        ], [
            'title.required' => 'Title Field Is Required',
            'title.unique' => 'This Title Already Exist',
            'description.required' => 'Description Field Is Required',
            'keywords.required' => 'Keywords Field Is Required',
            'unit_price.required' => "Unit Price Field Is Required",
            'total_items.required' => "Total Item Field Is Required",
            'tax.required' => "Tax Field Is Required",
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 402,
                'errors' => $validator->errors(),
            ]);
        }
        $marketplace = Marketplace::find($id);

        $marketplace->title = $request->title;
        $marketplace->slug = Str::slug($request->title);
        $marketplace->description = $request->description;
        $marketplace->unit_price = $request->unit_price;
        $marketplace->tax = $request->tax;
        $marketplace->terms_conditions = $request->terms_conditions;
        $marketplace->total_items = $request->total_items;
        $marketplace->total_selling = $request->sellingItems;
        $marketplace->keywords = $request->keywords;

        if ($request->hasfile('image')) {
            $destination = $marketplace->image;
            if (File::exists($destination)) {
                File::delete($destination);
            }

            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = 'uploads/images/marketplace/' . time() . '.' . $extension;

            Image::make($file)->resize(400, 400)->save($filename, 100);
            $marketplace->image = $filename;
        }

        $marketplace->save();

        return response()->json([
            'status' => 200,
            'message' => 'Marketplace Updated Successfully',
        ]);
    }

    public function approvedStarProductList($id)
    {
        $marketplace = Marketplace::find($id);
        $marketplace->post_status = 1;
        $starApprove = $marketplace->save();

        if ($starApprove) {
            $managerInfo = getManagerInfoFromCategory(auth('sanctum')->user()->category_id);
            $senderInfo = getStarInfo(auth('sanctum')->user()->id);

            SendMail($managerInfo->email, $marketplace, $senderInfo);
        }

        return response()->json([
            'status' => 200,
            'message' => 'Marketplace Approved Successfully',
        ]);
    }

    public function declineStarProductList($id)
    {
        $marketplace = Marketplace::find($id);
        // $marketplace->post_status = 2;
        // $marketplace->save();
        $marketplace->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Marketplace Declined!',
        ]);
    }
}
