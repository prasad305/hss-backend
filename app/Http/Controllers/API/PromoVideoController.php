<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\PromoVideo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManagerStatic as Image;

class PromoVideoController extends Controller
{

    public function adminAllPromoVideos()
    {

        $promoVideos = PromoVideo::orderBy('id', 'DESC')->where('admin_id', auth()->user()->id)->get();


        return response()->json([
            'status' => 200,
            'promoVideos' => $promoVideos,
        ]);
    }

    public function videoStore(Request $request)
    {
        // return auth('sanctum')->user()->category_id;
        $validator = Validator::make($request->all(),[
            'star_id' => 'required',
            'title' => 'required',
            'video_url' => 'required|mimes:mp4,mov,ogg',
            'thumbnail' => 'required|mimes:jpeg,jpg,png,webp | max:1000'
        ]);

        if($validator->fails())
        {
            return response()->json([
                'validation_errors'=>$validator->errors(),
            ]);
        }else{
            $promo = PromoVideo::create([
                'category_id' => auth('sanctum')->user()->category_id,
                'sub_category_id' => auth('sanctum')->user()->sub_category_id,
                'created_by' => auth('sanctum')->user()->id,
                'admin_id' => auth()->user()->id,
                'star_id' => $request->star_id,
                'title' => $request->title,
                'status' => 0,
            ]);

            if ($request->hasFile('video_url')) {

                $file        = $request->file('video_url');
                $path        = 'uploads/videos/promos';
                $file_name   = time() . rand('0000', '9999') . '.' . $file->getClientOriginalName();
                $file->move($path, $file_name);
                $promo->video_url = $path . '/' . $file_name;
            }
            if ($request->hasFile('thumbnail')) {

                $file        = $request->file('thumbnail');
                $path        = 'uploads/videos/promos/';
                $file_name   = $path . time() . rand('0000', '9999') . '.' . $file->getClientOriginalName();
                Image::make($file)->resize(900, 400)->save($file_name);
                $promo->thumbnail = $file_name;
            }

            $promo->save();

            return response()->json([
                'status' => 200,
                'message' => "Video Uploaded Successfully"
            ]);
        }



    }


    public function adminEdit($id)
    {
        $promo_video = PromoVideo::findOrFail($id);
        return response()->json([
            'status' => 200,
            'promo_video' => $promo_video,
        ]);
    }

    public function adminUpdate(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'star_id' => 'required',
            'title' => 'required',
        ]);

        if($validator->fails())
        {
            return response()->json([
                'validation_errors'=>$validator->errors(),
            ]);
        }else{
            $promo = PromoVideo::findOrFail($request->id);
            
            $promo->star_id = $request->star_id;
            $promo->title = $request->title;

            if ($request->hasFile('video_url')) {
                if ($promo->video_url != null && file_exists($promo->video_url)) {
                    unlink($promo->video_url);
                }
                $file        = $request->file('video_url');
                $path        = 'uploads/videos/promos';
                $file_name   = time() . rand('0000', '9999') . '.' . $file->getClientOriginalName();
                $file->move($path, $file_name);
                $promo->video_url = $path . '/' . $file_name;
            }
            if ($request->hasFile('thumbnail')) {
                if ($promo->thumbnail != null && file_exists($promo->thumbnail)) {
                    unlink($promo->thumbnail);
                }
                $file        = $request->file('thumbnail');
                $path        = 'uploads/videos/promos/';
                $file_name   = $path . time() . rand('0000', '9999') . '.' . $file->getClientOriginalName();
                Image::make($file)->resize(900, 400)->save($file_name);
                $promo->thumbnail = $file_name;
            }

            $promo->save();

            return response()->json([
                'status' => 200,
                'message' => "Video Updated Successfully"
            ]);
        }
    }

    public function pendingVideos()
    {
        $promoVideos = PromoVideo::orderBy('id', 'DESC')->where('admin_id', auth()->user()->id)->where('status',0)->get();
        return response()->json([
            'status' => 200,
            'promoVideos' => $promoVideos,
        ]);
    }

    public function approvedVideos()
    {
        $promoVideos = PromoVideo::orderBy('id', 'DESC')->where('admin_id',auth()->user()->id)->where('status',1)->get();
        return response()->json([
            'status' => 200,
            'promoVideos' => $promoVideos,
        ]);
    }

    public function videoDetails($promo_id)
    {
        $promoVideo = PromoVideo::find($promo_id);
        return response()->json([
            'status' => 200,
            'promoVideo' => $promoVideo,
        ]);
    }


    public function liveVideos()
    {

        $promoVideos = PromoVideo::orderBy('id', 'DESC')->where('admin_id', auth()->user()->id)->where('status',2)->get();

        return response()->json([
            'status' => 200,
            'promoVideos' => $promoVideos,

        ]);
    }

    public function rejectVideos()
    {

        $promoVideos = PromoVideo::orderBy('id', 'DESC')->where('admin_id', auth()->user()->id)->where([['status',11]])->get();

        return response()->json([
            'status' => 200,
            'promoVideos' => $promoVideos,

        ]);
    }
    public function promoVideoCount()
    {
      

        $pendingTotal = PromoVideo::where('admin_id', auth()->user()->id)->where('status',0)->count();
        $liveTotal = PromoVideo::where('admin_id', auth()->user()->id)->where('status',2)->count();
        $approveTotal = PromoVideo::where('admin_id', auth()->user()->id)->where('status',1)->count();

        return response()->json([
            'status' => 200,
            'pendingTotal' => $pendingTotal,
            'liveTotal' => $liveTotal,
            'approveTotal' => $approveTotal,
        ]);
    }

    // Star Portal

    public function starPromovideoAll()
    {

        $promoVideos = PromoVideo::orderBy('id', 'DESC')->where('star_id', auth()->user()->id)->get();


        return response()->json([
            'status' => 200,
            'promoVideos' => $promoVideos,
        ]);
    }

    public function starPromovideoStore(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'title' => 'required',
            'video_url' => 'required|mimes:mp4,mov,ogg',
            'thumbnail' => 'required|mimes:jpeg,jpg,png,webp | max:1000'
        ]);

        if($validator->fails())
        {
            return response()->json([
                'validation_errors'=>$validator->errors(),
            ]);
        }else{
            $promo = PromoVideo::create([
                'category_id' => auth('sanctum')->user()->category_id,
                'sub_category_id' => auth('sanctum')->user()->sub_category_id,
                'created_by' => auth('sanctum')->user()->id,
                'admin_id' => auth()->user()->parent_user,
                'star_id' => auth('sanctum')->user()->id,
                'title' => $request->title,
                'status' => 1,
            ]);

            if ($request->hasFile('video_url')) {

                $file        = $request->file('video_url');
                $path        = 'uploads/videos/promos';
                $file_name   = time() . rand('0000', '9999') . '.' . $file->getClientOriginalName();
                $file->move($path, $file_name);
                $promo->video_url = $path . '/' . $file_name;
            }
            if ($request->hasFile('thumbnail')) {

                $file        = $request->file('thumbnail');
                $path        = 'uploads/videos/promos/';
                $file_name   = $path . time() . rand('0000', '9999') . '.' . $file->getClientOriginalName();
                Image::make($file)->resize(900, 400)->save($file_name);
                $promo->thumbnail = $file_name;
            }

            $promo->save();

            return response()->json([
                'status' => 200,
                'message' => "Video Uploaded Successfully"
            ]);
        }

    }



    public function starPromopendingVideos()
    {

        $promoVideos = PromoVideo::orderBy('id', 'DESC')->where('star_id', auth()->user()->id)->where('status',0)->get();
        return response()->json([
            'status' => 200,
            'promoVideos' => $promoVideos,
        ]);
    }

    public function starPromoApprovedVideos()
    {

        $promoVideos = PromoVideo::orderBy('id', 'DESC')->where('star_id', auth()->user()->id)->where('status',1)->get();
        return response()->json([
            'status' => 200,
            'promoVideos' => $promoVideos,
        ]);
    }

    public function starPromoRejectedVideos()
    {

        $promoVideos = PromoVideo::orderBy('id', 'DESC')->where('star_id',auth()->user()->id)->where('status',11)->get();

        return response()->json([
            'status' => 200,
            'promoVideos' => $promoVideos,
        ]);
    }

    public function starPromoliveVideos()
    {

        $promoVideos = PromoVideo::orderBy('id', 'DESC')->where('star_id', auth()->user()->id)->where('status',2)->get();

        return response()->json([
            'status' => 200,
            'promoVideos' => $promoVideos,

        ]);
    }
    public function starPromoVideoCount()
    {

        $pendingTotal = PromoVideo::where('star_id', auth()->user()->id)->where('status', 0)->count();
        $approveTotal = PromoVideo::where('star_id', auth()->user()->id)->where('status', 1)->count();
        $liveTotal    = PromoVideo::where('star_id', auth()->user()->id)->where('status', 2)->count();

        return response()->json([
            'status' => 200,
            'pendingTotal' => $pendingTotal,
            'approveTotal' => $approveTotal,
            'liveTotal' => $liveTotal,
        ]);
    }

    public function edit($id)
    {
        $promo_video = PromoVideo::findOrFail($id);
        return response()->json([
            'status' => 200,
            'promo_video' => $promo_video,

        ]);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'title' => 'required',
        ]);

        if($validator->fails())
        {
            return response()->json([
                'validation_errors'=>$validator->errors(),
            ]);
        }else{
            $promo = PromoVideo::findOrFail($request->id);
            
            $promo->title = $request->title;

            if ($request->hasFile('video_url')) {
                if ($promo->video_url != null && file_exists($promo->video_url)) {
                    unlink($promo->video_url);
                }
                $file        = $request->file('video_url');
                $path        = 'uploads/videos/promos';
                $file_name   = time() . rand('0000', '9999') . '.' . $file->getClientOriginalName();
                $file->move($path, $file_name);
                $promo->video_url = $path . '/' . $file_name;
            }
            if ($request->hasFile('thumbnail')) {
                if ($promo->thumbnail != null && file_exists($promo->thumbnail)) {
                    unlink($promo->thumbnail);
                }
                $file        = $request->file('thumbnail');
                $path        = 'uploads/videos/promos/';
                $file_name   = $path . time() . rand('0000', '9999') . '.' . $file->getClientOriginalName();
                Image::make($file)->resize(900, 400)->save($file_name);
                $promo->thumbnail = $file_name;
            }

            $promo->save();

            return response()->json([
                'status' => 200,
                'message' => "Video Updated Successfully"
            ]);
        }

    }

    public function starVideosDetails($id)
    {

        $promoVideos = PromoVideo::findOrFail($id);

        return response()->json([
            'status' => 200,
            'promoVideos' => $promoVideos,

        ]);
    }



    public function starPromoVideoApproved($id)
    {

        $promoVideos = PromoVideo::where('id', $id)->update(['status' => 1]);

        return response()->json([
            'status' => 200,
            'promoVideos' => $promoVideos,
            'message' => "Video Approved Done"

        ]);
    }
    public function starPromoVideoDecline($id)
    {

        $promoVideos = PromoVideo::where('id', $id)->update(['status' =>11]);

        return response()->json([
            'status' => 200,
            'promoVideos' => $promoVideos,
            'message' => "Video Decline Done"

        ]);
    }
}
