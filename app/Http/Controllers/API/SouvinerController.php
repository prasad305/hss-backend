<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManagerStatic as Image;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use App\Models\SouvenirCreate;
use App\Models\User;

class SouvinerController extends Controller
{
    public function souvinerStore(Request $request){
        $validator = Validator::make($request->all(),[
            'title' => 'required',
            'description' => 'required',
            'instruction' => 'required',
            'star_id' => 'required',
            'price' => 'required',
            'banner' => 'required',
            'video' => 'required',
        ]);

        if($validator->fails())
        {
            return response()->json([
                'validation_errors'=>$validator->errors(),
            ]);
        }

        else{
            $id = auth('sanctum')->user()->id;

            $souvenir = new SouvenirCreate();
            $souvenir->title = $request->title;
            $souvenir->slug = Str::slug($request->input('title'));
            $souvenir->description = $request->description;
            $souvenir->instruction = $request->instruction;
            $souvenir->price = $request->price;

            $souvenir->admin_id = $id;
            $souvenir->star_id = $request->star_id;

            if ($request->hasfile('banner')) {

                $file = $request->file('banner');
                $extension = $file->getClientOriginalExtension();
                $filename = 'uploads/images/souviner/' . time() . '.' . $extension;

                Image::make($file)->resize(800, 300)->save($filename, 100);
                $souvenir->banner = $filename;
            }
            // if ($request->hasfile('video')) {

            //     $file = $request->file('video');
            //     $extension = $file->getClientOriginalExtension();
            //     $filename = 'uploads/images/souviner/videos/' . time() . '.' . $extension;

            //     Image::make($file)->resize(800, 300)->save($filename, 100);
            //     $souvenir->video = $filename;
            // }

            if ($request->hasFile('video')) {
                // if ($greeting->video != null && file_exists($greeting->video)) {
                //     unlink($greeting->video);
                // }
                $file        = $request->file('video');
                $path        = 'uploads/videos/souviner';
                $file_name   = time() . rand('0000', '9999') . '.' . $file->getClientOriginalName();
                $file->move($path, $file_name);
                $souvenir->video = $path . '/' . $file_name;
            }

            $souvenir->approval_status = 0;

            $souvenir->save();

            return response()->json([
                'status' => 200,
                'message' => 'Souvenir Added Successfully',
            ]);

        }
    }
    public function souvinerStarStore(Request $request){
        $validator = Validator::make($request->all(),[
            'title' => 'required',
            'description' => 'required',
            'instruction' => 'required',
            'price' => 'required',
            'banner' => 'required',
        ]);

        if($validator->fails())
        {
            return response()->json([
                'validation_errors'=>$validator->errors(),
            ]);
        }

        else{
            $id = auth('sanctum')->user()->id;
            $user = User::find($id);

            $souvenir = new SouvenirCreate();
            $souvenir->title = $request->title;
            $souvenir->slug = Str::slug($request->input('title'));
            $souvenir->description = $request->description;
            $souvenir->instruction = $request->instruction;
            $souvenir->price = $request->price;

            $souvenir->admin_id = $user->parent_user;
            $souvenir->star_id = $id;

            if ($request->hasfile('banner')) {

                $file = $request->file('banner');
                $extension = $file->getClientOriginalExtension();
                $filename = 'uploads/images/souviner/' . time() . '.' . $extension;

                Image::make($file)->resize(800, 300)->save($filename, 100);
                $souvenir->banner = $filename;
            }

            if ($request->hasFile('video')) {
                // if ($greeting->video != null && file_exists($greeting->video)) {
                //     unlink($greeting->video);
                // }
                $file        = $request->file('video');
                $path        = 'uploads/videos/souviner';
                $file_name   = time() . rand('0000', '9999') . '.' . $file->getClientOriginalName();
                $file->move($path, $file_name);
                $souvenir->video = $path . '/' . $file_name;
            }

            $souvenir->approval_status = 1;

            $souvenir->save();

            return response()->json([
                'status' => 200,
                'message' => 'Souvenir Added Successfully',
            ]);

        }
    }

    public function souvinerCheck(){
        $id = auth('sanctum')->user()->id;

        $getUser = SouvenirCreate::where('admin_id', $id)->first();

        return response()->json([
            'status' => 200,
            'getUser' => $getUser,
        ]);
    }

    public function souvinerView($id){
        $viewSouviner = SouvenirCreate::find($id);

        return response()->json([
            'status' => 200,
            'viewSouviner' => $viewSouviner,
        ]);
    }

    public function souvinerUpdate(Request $request, $id){
        $validator = Validator::make($request->all(),[
            'title' => 'required',
            'description' => 'required',
            'instruction' => 'required',
            'price' => 'required',
            'star_id' => 'required',
        ]);

        if($validator->fails())
        {
            return response()->json([
                'validation_errors'=>$validator->errors(),
            ]);
        }

        else{
            $idd = auth('sanctum')->user()->id;

            $souvenir = SouvenirCreate::find($id);

            $souvenir->title = $request->title;
            $souvenir->slug = Str::slug($request->input('title'));
            $souvenir->description = $request->description;
            $souvenir->instruction = $request->instruction;
            $souvenir->price = $request->price;

            $souvenir->admin_id = $idd;
            $souvenir->star_id = $request->star_id;

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

            $souvenir->approval_status = 0;

            $souvenir->save();

            return response()->json([
                'status' => 200,
                'message' => 'Souvenir Updated Successfully',
            ]);

        }
    }

    public function souvinerStarCheck(){
        $id = auth('sanctum')->user()->id;

        $getSouviner = SouvenirCreate::where('star_id', $id)->first();

        return response()->json([
            'status' => 200,
            'getSouviner' => $getSouviner,
        ]);
    }
    public function souvinerStarApprove($id){

        $souviner = SouvenirCreate::find($id);
        $souviner->approval_status = 1;
        $souviner->save();

        return response()->json([
            'status' => 200,
            'message' => 'Souvenir Approved Successfully',
        ]);
    }
    public function souvinerStarDecline($id){

        $souviner = SouvenirCreate::find($id);
        $souviner->approval_status = 2;
        $souviner->save();

        return response()->json([
            'status' => 200,
            'message' => 'Souvenir Declined!',
        ]);
    }
}
