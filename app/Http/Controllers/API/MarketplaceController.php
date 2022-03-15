<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\Marketplace;
use App\Models\User;
use App\Models\Country;
use App\Models\State;
use App\Models\Order;
use App\Models\City;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManagerStatic as Image;

class MarketplaceController extends Controller
{
    // Marketplace Homepage

    public function marketplaceAll(){
        $data = Marketplace::where('status', 1)
                            ->where('post_status', 1)
                            ->get();

        return response()->json([
                'status' => 200,
                'data' => $data,
            ]);
    }
    
    
    public function viewCountry(){
        $data = Country::where('status', 1)
                            ->get();

        return response()->json([
                'status' => 200,
                'data' => $data,
            ]);
    }
    public function viewState($id){
        $country = Country::where('id',$id)->first();
        $state = State::where('country_id',$country->id)->get();

        return response()->json([
                'status' => 200,
                'state' => $state,
            ]);
    }
    public function viewCity($id){
        $state = State::where('id',$id)->first();
        $city = City::where('state_id',$state->id)->get();

        return response()->json([
                'status' => 200,
                'city' => $city,
            ]);
    }
    public function getSlugDetails($slug){
        $slugdetails = Marketplace::where('slug',$slug)->first();

        return response()->json([
                'status' => 200,
                'slugdetails' => $slugdetails,
            ]);
    }

    public function viewMarketplaceOrder(Request $request){
        $marketplace = Marketplace::where('slug', $request->marketplace_slug)->first();

        $date = (int) Carbon::now()->format('dmYHis');
        $rand = rand(100,999).$date;

        $data = new Order();
        $data->country_id = $request->country_id;
        $data->state_id = $request->state_id;
        $data->city_id = $request->city_id;
        $data->area = $request->area;
        $data->phone = $request->phone;
        $data->order_no = $rand;
        $data->items = $request->items;
        $data->unit_price = $request->unit_price;
        $data->delivery_charge = $request->delivery_charge;
        $data->cvc = $request->cvc;
        $data->card_no = $request->card_no;
        $data->expire_date = $request->expire_date;
        $data->user_id = Auth::user()->id;
        $data->marketplace_id = $marketplace->id;
        $data->superstar_id = $marketplace->superstar_id;
        $data->superstar_admin_id = $marketplace->superstar_admin_id;
        $data->total_price = ($request->items * $request->unit_price) + $request->delivery_charge;
        $data->status = 0;

        $data->save();

        return response()->json([
            'status' => 200,
            'message' => 'Order submit Successfully',
        ]);
    }

    public function viewMarketplaceActivities(){
        $data = Order::where('user_id', Auth::user()->id)
                    ->latest()
                    ->get();

        return response()->json([
            'status' => 200,
            'data' => $data,
        ]);
    }

    //SuperStar Admin for marketplace

    public function marketplaceStore(Request $request){

        $id = Auth::user()->id;
        $parent_id = User::find($id);
        // return $request->all();

        $marketplace = new Marketplace();
        
        $marketplace->title = $request->title;
        $marketplace->slug = Str::slug($request->input('title'));
        $marketplace->description = $request->description;
        $marketplace->unit_price = $request->unit_price;
        $marketplace->total_items = $request->total_items;
        $marketplace->keywords = $request->keywords;
        $marketplace->post_status = 0;
        $marketplace->status = 0;
        $marketplace->total_selling = 0;
        $marketplace->created_by = $id;
        $marketplace->superstar_id = $request->star_id;
        $marketplace->superstar_admin_id = $id;

        if ($request->hasfile('image')) {

            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = 'uploads/images/marketplace/' . time() . '.' . $extension;

            Image::make($file)->resize(400, 400)->save($filename, 100);
            $marketplace->image = $filename;
        }

        $marketplace->save();

        return response()->json([
            'status' => 200,
            'message' => 'Marketplace Added Successfully',
        ]);
    }

    public function allProductList(){
        $approved = Marketplace::where('status', 1)
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

    public function orderAdminProductList(){
        $orderList = Order::where('superstar_admin_id', Auth::user()->id)
                                ->get();
        
        return response()->json([
            'status' => 200,
            'orderList' => $orderList,
        ]);
    }

    public function liveProductList(){
        $live = Marketplace::whereColumn('total_items','>','total_selling')
                            ->where('status',1)
                            ->where('superstar_admin_id', Auth::user()->id)
                            ->where('post_status',1)
                            ->get();


        // $live = Marketplace::where('status', 1)->get();
        
        return response()->json([
            'status' => 200,
            'live' => $live,
        ]);
    }

    public function pendingProductList(){
        $pending = Marketplace::where('post_status', 0)
                                ->where('superstar_admin_id', Auth::user()->id)
                                ->get();
        $pendingCount = Marketplace::where('post_status', 0)
                                ->where('superstar_admin_id', Auth::user()->id)
                                ->count();

        return response()->json([
            'status' => 200,
            'pending' => $pending,
            'pendingCount' => $pendingCount,
        ]);
    }

    public function editAdminProductList($id){
        $editData = Marketplace::find($id);

        return response()->json([
            'status' => 200,
            'editData' => $editData,
        ]);
    }
    public function storeAdminProductList(Request $request ,$id){
        $marketplace = Marketplace::find($id);

        $marketplace->title = $request->title;
        $marketplace->slug = Str::slug($request->input('title'));
        $marketplace->description = $request->description;
        $marketplace->unit_price = $request->unit_price;
        $marketplace->total_items = $request->total_items;
        $marketplace->total_selling = $request->sellingItems;
        $marketplace->keywords = $request->keywords;

        if ($request->hasfile('image')) {
            $destination = $marketplace->image;
                if(File::exists($destination))
                {
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

    public function starMarketplaceStore(Request $request){

        // return $request->all();
        $id = Auth::user()->id;
        $parent_id = User::find($id);

        $marketplace = new Marketplace();
        
        $marketplace->title = $request->title;
        $marketplace->slug = Str::slug($request->input('title'));
        $marketplace->description = $request->description;
        $marketplace->unit_price = $request->unit_price;
        $marketplace->total_items = $request->total_items;
        $marketplace->keywords = $request->keywords;
        $marketplace->status = 0;
        $marketplace->post_status = 1;
        $marketplace->total_selling = 0;
        $marketplace->superstar_admin_id = $parent_id->parent_user;
        $marketplace->superstar_id = $id;
        $marketplace->created_by = $id;

        if ($request->hasfile('image')) {

            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = 'uploads/images/marketplace/' . time() . '.' . $extension;

            Image::make($file)->resize(400, 400)->save($filename, 100);
            $marketplace->image = $filename;
        }

        $marketplace->save();

        return response()->json([
            'status' => 200,
            'message' => 'Marketplace Added Successfully',
        ]);
    }

    public function allStarProductList(){
        $id = Auth::user()->id;
        $parent_id = User::find($id);

        $approved = Marketplace::where('post_status', 1)
                                ->where('superstar_admin_id', $parent_id->parent_user)
                                ->get();

        $approvedCount = Marketplace::where('post_status', 1)
                                ->where('superstar_admin_id', $parent_id->parent_user)
                                ->count();
        
        return response()->json([
            'status' => 200,
            'approved' => $approved,
            'approvedCount' => $approvedCount,
        ]);
    }

    public function liveStarProductList(){
        $id = Auth::user()->id;
        $parent_id = User::find($id);

        $live = Marketplace::whereColumn('total_items','>','total_selling')
                            ->where('status',1)
                            ->where('post_status', 1)
                            ->where('superstar_admin_id', $parent_id->parent_user)
                            ->get();


        // $live = Marketplace::where('status', 1)->get();
        
        return response()->json([
            'status' => 200,
            'live' => $live,
        ]);
    }

    public function pendingStarProductList(){
        $id = Auth::user()->id;
        $parent_id = User::find($id);

        $pending = Marketplace::where('post_status', 0)
                            ->where('superstar_admin_id', $parent_id->parent_user)
                            ->get();
        $pendingCount = Marketplace::where('post_status', 0)
                            ->where('superstar_admin_id', $parent_id->parent_user)
                            ->count();

        return response()->json([
            'status' => 200,
            'pending' => $pending,
            'pendingCount' => $pendingCount,
        ]);
    }

    public function editStarProductList($id){
        $editData = Marketplace::find($id);

        return response()->json([
            'status' => 200,
            'editData' => $editData,
        ]);
    }
    public function storeStarProductList(Request $request ,$id){
        $marketplace = Marketplace::find($id);

        $marketplace->title = $request->title;
        $marketplace->slug = Str::slug($request->input('title'));
        $marketplace->description = $request->description;
        $marketplace->unit_price = $request->unit_price;
        $marketplace->total_items = $request->total_items;
        $marketplace->total_selling = $request->sellingItems;
        $marketplace->keywords = $request->keywords;

        if ($request->hasfile('image')) {
            $destination = $marketplace->image;
                if(File::exists($destination))
                {
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

    public function approvedStarProductList($id){
        $marketplace = Marketplace::find($id);
        $marketplace->post_status = 1;
        $marketplace->save();

        return response()->json([
            'status' => 200,
            'message' => 'Marketplace Approved Successfully',
        ]);
    }

    public function declineStarProductList($id){
        $marketplace = Marketplace::find($id);
        $marketplace->post_status = 0;
        $marketplace->save();

        return response()->json([
            'status' => 200,
            'message' => 'Marketplace Declined!',
        ]);
    }


}
