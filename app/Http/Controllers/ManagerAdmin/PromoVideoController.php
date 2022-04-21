<?php

namespace App\Http\Controllers\ManagerAdmin;

use App\Http\Controllers\Controller;
use App\Models\PromoVideo;
use Illuminate\Http\Request;

class PromoVideoController extends Controller
{
    //
    public function all()
    {
        $promoVideo = PromoVideo::latest()->get();

        return view('ManagerAdmin.PromoVideo.index', compact('promoVideo'));
    }

    public function pending()
    {
        $promoVideo = PromoVideo::where([['status', 0], ['star_approval', 1]])->latest()->get();

        return view('ManagerAdmin.PromoVideo.index', compact('promoVideo'));
    }

    public function published()
    {
        $promoVideo = PromoVideo::where('status', 1)->latest()->get();

        return view('ManagerAdmin.PromoVideo.index', compact('promoVideo'));
    }

    public function details($id)
    {
        $promoVideo = PromoVideo::with(['star', 'admin'])->find($id);
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

    public function set_publish($id)
    {
        $promoVideo = PromoVideo::find($id);
        if ($promoVideo->status != 0) {

            $promoVideo->status = 0;
            $promoVideo->update();
        } else {
            $promoVideo->status = 1;
            $promoVideo->update();
            // $post =  Post::where('type','promoVideo')->where('event_id',$promoVideo->id)->first();
            // if (!isset($post)) {
            //     Post::create([
            //         'type' => 'promoVideo',
            //         'user_id' => '1',
            //         'event_id' => $promoVideo->id,
            //         'title' => $promoVideo->title,
            //         'details' => $promoVideo->description,
            //         'status' => 1,
            //         ]);
            // }
        }

        return redirect()->back()->with('success', 'Published');
    }
}
