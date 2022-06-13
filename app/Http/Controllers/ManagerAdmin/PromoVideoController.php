<?php

namespace App\Http\Controllers\ManagerAdmin;

use App\Http\Controllers\Controller;
use App\Models\PromoVideo;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PromoVideoController extends Controller
{
    //
    public function all()
    {
        $promoVideo = PromoVideo::where([['category_id',auth()->user()->category_id],['status','>',0]])->orderBy('updated_at','desc')->get();

        return view('ManagerAdmin.PromoVideo.index', compact('promoVideo'));
    }

    public function pending()
    {
        $promoVideo = PromoVideo::where([['status',1],['category_id',auth()->user()->category_id]])->orderBy('updated_at','desc')->get();

        return view('ManagerAdmin.PromoVideo.index', compact('promoVideo'));
    }

    public function published()
    {
        $promoVideo = PromoVideo::where([['status',2],['category_id',auth()->user()->category_id]])->orderBy('updated_at','desc')->get();

        return view('ManagerAdmin.PromoVideo.index', compact('promoVideo'));
    }

    public function details($id)
    {
        $promoVideo = PromoVideo::with(['star', 'admin'])->where('category_id',auth()->user()->category_id)->find($id);
        return view('ManagerAdmin.PromoVideo.details', compact('promoVideo'));
    }


    public function edit($id)
    {
        $event = PromoVideo::find($id);

        return view('ManagerAdmin.PromoVideo.edit', compact('event'));
    }

    public function update(Request $request, $id)
    {
        $promoVideo = PromoVideo::findOrFail($id);
        $promoVideo->fill($request->except('_token'));

        $promoVideo->title = $request->input('title');

        if ($request->hasfile('video_url')) {

            // $destination = $promoVideo->image;
            // if (File::exists($destination)) {
            //     File::delete($destination);
            // }

            $file = $request->file('video_url');
            $extension = $file->getClientOriginalExtension();
            $filename = 'uploads/videos/promos/' . time() . '.' . $extension;
            $promoVideo->video_url = $filename;
        }


        try {
            $promoVideo->update();
            if ($promoVideo) {
                return response()->json([
                    'success' => true,
                    'message' => 'Promo Video Updated'
                ]);
            }
        } catch (\Exception $exception) {
            return response()->json([
                'type' => 'error',
                'message' => 'Opps somthing went wrong. ' . $exception->getMessage(),
            ]);
        }
    }

    public function set_publish(Request $request,$id)
    {
        $promoVideo = PromoVideo::find($id);
        if ($promoVideo->status != 2) {

            $request->validate([
                'publish_start_date' => 'required',
                'publish_end_date' => 'required',
            ]);

            $promoVideo->status = 2;
            $promoVideo->publish_start_date = Carbon::parse($request->publish_start_date);
            $promoVideo->publish_end_date = Carbon::parse($request->publish_end_date);
            $promoVideo->update();
            return redirect()->back()->with('success', 'Published');
        } else {
            $promoVideo->status = 1;
            $promoVideo->publish_start_date = null;
            $promoVideo->publish_end_date = null;
            $promoVideo->update();
            return redirect()->back()->with('success', 'Unpublished');
        }

        
    }
}
