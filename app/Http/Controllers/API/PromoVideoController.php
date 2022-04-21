<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\PromoVideo;
use Illuminate\Http\Request;

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
        // return $request->all();



        $promo = PromoVideo::create([
            'admin_id' => auth()->user()->id,
            'star_id' => $request->star_id,
            'title' => $request->title,
            'star_approval' => 0,
        ]);
        if ($request->hasFile('video_url')) {

            $file        = $request->file('video_url');
            $path        = 'uploads/videos/promos';
            $file_name   = time() . rand('0000', '9999') . '.' . $file->getClientOriginalName();
            $file->move($path, $file_name);
            $promo->video_url = $path . '/' . $file_name;
        }
        $promo->save();
        return response()->json([
            'status' => 200,
            'message' => "Video Uploaded Successfully"
        ]);
    }
    public function pendingVideos()
    {

        $promoVideos = PromoVideo::orderBy('id', 'DESC')->where('admin_id', auth()->user()->id)->where('status', 0)->get();


        return response()->json([
            'status' => 200,
            'promoVideos' => $promoVideos,
        ]);
    }
    public function liveVideos()
    {

        $promoVideos = PromoVideo::orderBy('id', 'DESC')->where('admin_id', auth()->user()->id)->where('status', 1)->get();

        return response()->json([
            'status' => 200,
            'promoVideos' => $promoVideos,

        ]);
    }
    public function promoVideoCount()
    {

        $pendingTotal = PromoVideo::where('admin_id', auth()->user()->id)->where('status', 0)->count();
        $liveTotal = PromoVideo::where('admin_id', auth()->user()->id)->where('status', 1)->count();

        return response()->json([
            'status' => 200,
            'pendingTotal' => $pendingTotal,
            'liveTotal' => $liveTotal,
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

    public function starPromopendingVideos()
    {

        $promoVideos = PromoVideo::orderBy('id', 'DESC')->where('star_id', auth()->user()->id)->where('star_approval', 0)->get();


        return response()->json([
            'status' => 200,
            'promoVideos' => $promoVideos,
        ]);
    }
    public function starPromoliveVideos()
    {

        $promoVideos = PromoVideo::orderBy('id', 'DESC')->where('star_id', auth()->user()->id)->where('star_approval', 1)->get();

        return response()->json([
            'status' => 200,
            'promoVideos' => $promoVideos,

        ]);
    }
    public function starPromoVideoCount()
    {

        $pendingTotal = PromoVideo::where('star_id', auth()->user()->id)->where('star_approval', 0)->count();
        $liveTotal = PromoVideo::where('star_id', auth()->user()->id)->where('star_approval', 1)->count();

        return response()->json([
            'status' => 200,
            'pendingTotal' => $pendingTotal,
            'liveTotal' => $liveTotal,
        ]);
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

        $promoVideos = PromoVideo::where('id', $id)->update(['star_approval' => 1]);

        return response()->json([
            'status' => 200,
            'promoVideos' => $promoVideos,
            'message' => "Video Approved Done"

        ]);
    }
    public function starPromoVideoDecline($id)
    {

        $promoVideos = PromoVideo::where('id', $id)->update(['star_approval' => 2]);

        return response()->json([
            'status' => 200,
            'promoVideos' => $promoVideos,
            'message' => "Video Decline Done"

        ]);
    }
}
