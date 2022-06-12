<?php

namespace App\Http\Controllers\ManagerAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\SouvenirCreate;
use App\Models\SouvenirApply;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManagerStatic as Image;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class SouvenirController extends Controller
{
    public function all()
    {

        $post = SouvenirCreate::latest()->where('approval_status', 1)->where('category_id',auth()->user()->category_id)->get();

        return view('ManagerAdmin.souvenir.index', compact('post'));
    }

    public function pending()
    {
        $post = SouvenirCreate::where('status',0)->where('category_id',auth()->user()->category_id)->latest()->get();

        return view('ManagerAdmin.souvenir.index', compact('post'));
    }

    public function published()
    {
        $post = SouvenirCreate::where('status',1)->where('category_id',auth()->user()->category_id)->latest()->get();

        return view('ManagerAdmin.souvenir.index', compact('post'));
    }

    public function details($id)
    {
        $post = SouvenirCreate::find($id);

        return view('ManagerAdmin.souvenir.details', compact('post'));
    }


    public function edit($id)
    {
        $event = SouvenirCreate::find($id);

        return view('ManagerAdmin.souvenir.edit', compact('event'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([

            'title' => 'required',
            'description' => 'required',
            'instruction' => 'required',

        ]);

        $souvenir = SouvenirCreate::findOrFail($id);
        $souvenir->fill($request->except('_token','banner', 'video'));

        $souvenir->title = $request->input('title');
        $souvenir->slug = Str::slug($request->input('title').'-'.rand(9999,99999));
        $souvenir->description = $request->input('description');
        $souvenir->instruction = $request->input('instruction');


        // if ($request->hasfile('image')) {
        //     $destination = $marketplace->image;
        //     if ($destination != null && file_exists($destination)) {
        //         unlink($destination);
        //     }
        //     $file = $request->file('image');
        //     $extension = $file->getClientOriginalExtension();
        //     $filename = 'uploads/images/marketplace/' . time() . '.' . $extension;

        //     Image::make($file)->resize(400, 400)->save($filename, 50);
        //     $marketplace->image = $filename;

        // }

        if ($request->hasfile('banner')) {
            $destination = $souvenir->banner;
            if (File::exists($destination)) {
                File::delete($destination);
            }

            $file = $request->file('banner');
            $extension = $file->getClientOriginalExtension();
            $filename = 'uploads/images/souviner/' . time() . '.' . $extension;

            Image::make($file)->resize(800, 300)->save($filename, 100);
            $souvenir->banner = $filename;
        }


        if ($request->hasFile('video')) {
            if ($souvenir->video != null && file_exists($souvenir->video)) {
                unlink($souvenir->video);
            }
            $file        = $request->file('video');
            $path        = 'uploads/videos/souviner/';
            $file_name   = time() . rand('0000', '9999') . '.' . $file->getClientOriginalName();
            $file->move($path, $file_name);
            $souvenir->video = $path . '/' . $file_name;
        }
        

        try {

            $souvenir->update();
         
             return response()->json([
                 'success' => true,
                 'message' => 'Souvenir Updated Successfully'
             ]);
            
        } catch (\Exception $exception) {
            return response()->json([
                'type' => 'error',
                'message' => 'Opps somthing went wrong. ' . $exception->getMessage(),
            ]);
        }
    }

    public function set_publish($id)
    {
        $spost = SouvenirCreate::find($id);

        if($spost->status != 1)
        {
            $spost->status = 1;
            $spost->update();
        }
        else
        {
            $spost->status = 0;
            $spost->update();
        }

        return redirect()->back()->with('success', 'Published');
    }

    public function showApplySouvenir()
    {
        $applySouvenir = SouvenirApply::where('category_id', auth('sanctum')->user()->category_id)
                                        ->latest()
                                        ->get();

        return view('ManagerAdmin.souvenir.show-apply', compact('applySouvenir'));
    }
}
