<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\Marketplace;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManagerStatic as Image;

class MarketplaceController extends Controller
{
    //SuperStar Admin for marketplace

    public function marketplaceStore(Request $request){

        $id = Auth::user()->id;
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
        $marketplace->superstar_id = 0;
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
        
        return response()->json([
            'status' => 200,
            'approved' => $approved,
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
        $pending = Marketplace::where('status', 0)
                                ->where('superstar_admin_id', Auth::user()->id)
                                ->get();

        return response()->json([
            'status' => 200,
            'pending' => $pending,
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
        $marketplace->superstar_id = Auth('sanctum')->user()->id;

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

        $approved = Marketplace::where('status', 1)
                                ->where('post_status', 1)
                                ->where('superstar_admin_id', $parent_id->parent_user)
                                ->get();
        
        return response()->json([
            'status' => 200,
            'approved' => $approved,
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

        return response()->json([
            'status' => 200,
            'pending' => $pending,
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
        $marketplace->post_status = 2;
        $marketplace->save();

        return response()->json([
            'status' => 200,
            'message' => 'Marketplace Declined!',
        ]);
    }


}
