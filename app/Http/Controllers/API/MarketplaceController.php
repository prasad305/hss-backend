<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\Marketplace;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManagerStatic as Image;

class MarketplaceController extends Controller
{
    public function marketplaceStore(Request $request){

        // return $request->all();

        $marketplace = new Marketplace();
        
        $marketplace->title = $request->title;
        $marketplace->slug = Str::slug($request->input('title'));
        $marketplace->description = $request->description;
        $marketplace->unit_price = $request->unit_price;
        $marketplace->total_items = $request->total_items;
        $marketplace->keywords = $request->keywords;
        $marketplace->status = 0;
        $marketplace->total_selling = 0;
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

    public function starMarketplaceStore(Request $request){

        // return $request->all();

        $marketplace = new Marketplace();
        
        $marketplace->title = $request->title;
        $marketplace->slug = Str::slug($request->input('title'));
        $marketplace->description = $request->description;
        $marketplace->unit_price = $request->unit_price;
        $marketplace->total_items = $request->total_items;
        $marketplace->keywords = $request->keywords;
        $marketplace->status = 0;
        $marketplace->total_selling = 0;
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

    public function allProductList(){
        $approved = Marketplace::where('status', 1)->get();
        
        return response()->json([
            'status' => 200,
            'approved' => $approved,
        ]);
    }

    public function liveProductList(){
        $live = Marketplace::whereColumn('total_items','>','total_selling')->where('status',1)->get();


        // $live = Marketplace::where('status', 1)->get();
        
        return response()->json([
            'status' => 200,
            'live' => $live,
        ]);
    }

    public function pendingProductList(){
        $pending = Marketplace::where('status', 0)->get();

        return response()->json([
            'status' => 200,
            'pending' => $pending,
        ]);
    }
}
