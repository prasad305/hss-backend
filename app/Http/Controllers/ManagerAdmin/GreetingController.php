<?php

namespace App\Http\Controllers\ManagerAdmin;

use App\Http\Controllers\Controller;
use App\Models\Auction;
use App\Models\Greeting;
use App\Models\Marketplace;
use App\Models\User;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Str;

class GreetingController extends Controller
{

    // public function dashboard()
    // {
    //     // all of those are dummy for greeting dashboard
    //     $subcategory = SubCategory::where('category_id', Auth::user()->category_id)->latest()->get();
    //     // $subcategory = Category::with(subCategories)
    //     // dd($subcategory);
    //     $totalUser = User::where('user_type', 'user')->count();
    //     $totalAdmin = User::where('user_type', 'admin')->where('parent_user', auth()->user()->id)->count();
    //     $totalStar = User::where('user_type', 'star')->where('parent_user', auth()->user()->id)->count();
    //     $totalAuctionProduct = Auction::where('category_id', auth()->user()->category_id)->count();
    //     $totalMarketPlaceProduct = Marketplace::where('category_id', auth()->user()->category_id)->count();
    //     return view('ManagerAdmin.greeting.dashboard', compact(['totalUser', 'subcategory', 'totalAdmin', 'totalStar', 'totalAuctionProduct', 'totalMarketPlaceProduct']));
    // }
    public function subcategory($id)
    {
        $greetings = Greeting::where('category_id', $id)->get();
        return view('ManagerAdmin.greeting.subcategory', compact(['greetings']));
    }

    public function request()
    {
        $greetings = Greeting::where([['category_id', Auth::user()->category_id], ['status', '>=', 1]])->get();
        return view('ManagerAdmin.greeting.request', compact('greetings'));
    }
    public function published()
    {
        $greetings = Greeting::where([['category_id', Auth::user()->category_id], ['status', '>', 1]])->get();
        return view('ManagerAdmin.greeting.published', compact('greetings'));
    }

    public function show($greeting_id)
    {
        $greeting = Greeting::findOrFail($greeting_id);
        return view('ManagerAdmin.greeting.show', compact('greeting'));
    }

    public function edit($greeting_id)
    {
        $greeting = Greeting::findOrFail($greeting_id);
        return view('ManagerAdmin.greeting.edit', compact('greeting'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'instruction' => 'required|min:5',
            'cost' => 'required',
            'minimum_required_day' => 'required',
            'banner' => 'nullable|mimes:png,jpg,jpeg',
            'video' => 'nullable',
        ]);

        $greeting = Greeting::findOrFail($id);
        $greeting->title = $request->title;
        $greeting->instruction = $request->instruction;
        $greeting->cost = $request->cost;
        $greeting->user_required_day = $request->minimum_required_day;

        if ($request->hasfile('banner')) {
            $destination = $greeting->banner;
            if (File::exists($destination)) {
                File::delete($destination);
            }
            $file = $request->file('banner');
            $extension = $file->getClientOriginalExtension();
            $filename = 'uploads/images/greeting/' . time() . '.' . $extension;
            Image::make($file)->resize(900, 400)->save($filename, 50);
            $greeting->banner = $filename;
        }

        if ($request->hasFile('video')) {
            if ($greeting->video != null && file_exists($greeting->video)) {
                unlink($greeting->video);
            }
            $file        = $request->file('video');
            $path        = 'uploads/videos/greeting';
            $file_name   = time() . rand('0000', '9999') . '.' . $file->getClientOriginalName();
            $file->move($path, $file_name);
            $greeting->video = $path . '/' . $file_name;
        }

        try {
            $greeting->save();
            if ($greeting) {
                return response()->json([
                    'success' => true,
                    'message' => 'Greeting Updated Successfully'
                ]);
            }
        } catch (\Exception $exception) {
            return response()->json([
                'type' => 'error',
                'message' => 'Opps somthing went wrong. ' . $exception->getMessage(),
            ]);
        }
    }


    public function publish($greeting_id)
    {
        $greeting = Greeting::findOrFail($greeting_id);
        $greeting->status = 2;
        try {
            $greeting->save();
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
