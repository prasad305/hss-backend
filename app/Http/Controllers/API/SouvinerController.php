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
use App\Models\SouvenirApply;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

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
            $user = User::find($id);

            $souvenir = new SouvenirCreate();
            $souvenir->title = $request->title;
            $souvenir->slug = Str::slug($request->input('title'));
            $souvenir->description = $request->description;
            $souvenir->instruction = $request->instruction;
            $souvenir->category_id = $user->category_id;
            $souvenir->sub_category_id = $user->sub_category_id;

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
            $user = User::find($id);         

            $souvenir = new SouvenirCreate();
            $souvenir->title = $request->title;
            $souvenir->slug = Str::slug($request->input('title'));
            $souvenir->description = $request->description;
            $souvenir->instruction = $request->instruction;
            $souvenir->price = $request->price;

            $souvenir->category_id = $user->category_id;
            $souvenir->sub_category_id = $user->sub_category_id;

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

    public function getUserSouvenir($starId){

        $getSouviner = SouvenirCreate::where('star_id', $starId)->where('status', 1)->first();

        if($getSouviner){
            return response()->json([
                'status' => 200,
                'getSouviner' => $getSouviner,
            ]);
        }else{
            return response()->json([
                'message' => 'Not Services!',
            ]);
        }
        
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

            $user = User::find($idd);

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
        $souviner->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Souvenir Declined!',
        ]);
    }

    public function souvinerStarEdit($id){

        $getSouviner = SouvenirCreate::find($id);

        return response()->json([
            'status' => 200,
            'getSouviner' => $getSouviner,
        ]);
    }

    public function souvinerStarUpdate(Request $request, $id){

        $validator = Validator::make($request->all(),[
            'title' => 'required',
            'description' => 'required',
            'instruction' => 'required',
            'price' => 'required',
        ]);

        if($validator->fails())
        {
            return response()->json([
                'validation_errors'=>$validator->errors(),
            ]);
        }

        else{

            $souvenir = SouvenirCreate::find($id);

            $souvenir->title = $request->title;
            $souvenir->slug = Str::slug($request->input('title'));
            $souvenir->description = $request->description;
            $souvenir->instruction = $request->instruction;
            $souvenir->price = $request->price;

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

            $souvenir->save();

            return response()->json([
                'status' => 200,
                'message' => 'Souvenir Updated Successfully',
            ]);

        }
    }

    // User Apply Souvenir
    public function applyUserSouvenir(Request $request, $starId){

        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'country_id' => 'required',
            'state_id' => 'required',
            'city_id' => 'required',
            'description' => 'required',
            'area' => 'required',
            'mobile_no' => 'required',
            'image' => 'required',
            'password' => 'required',
        ]);

        if($validator->fails())
        {
            return response()->json([
                'validation_errors'=>$validator->errors(),
            ]);
        }else{
            $user = User::find(auth('sanctum')->user()->id);
            $star = User::find($starId);

            if (Hash::check($request->password, $user->password)){

                $apply = new SouvenirApply();
                $apply->name = $request->name;
                $apply->country_id = $request->country_id;
                $apply->state_id = $request->state_id;
                $apply->city_id = $request->city_id;
                $apply->souvenir_id = $request->souvinerId;
                $apply->description = $request->description;
                $apply->area = $request->area;
                $apply->mobile_no = $request->mobile_no;
                $apply->user_id = auth('sanctum')->user()->id;
                $apply->star_id = $starId;
                $apply->admin_id = $star->parent_user;
                $apply->category_id = $star->category_id;

                if ($request->hasfile('image')) {
                    $destination = $apply->image;
                    if (File::exists($destination)) {
                        File::delete($destination);
                    }

                    $file = $request->file('image');
                    $extension = $file->getClientOriginalExtension();
                    $filename = 'uploads/images/souviner/apply/' . time() . '.' . $extension;

                    Image::make($file)->resize(400, 400)->save($filename, 100);
                    $apply->image = $filename;
                }
                $apply->save();

                return response()->json([
                    'status' => 200,
                    'message' => 'Souvenir Applied Successfully',
                ]);
                

            }else {
                return response()->json([
                    'status' => 201,
                    'message' => 'Passowrd Not Match'
                ]);
            }
        }
    }

    public function registerUserSouvenirList(){
        $admin = auth('sanctum')->user()->id;

        $registerSouvenir = SouvenirApply::where('admin_id', $admin)->where('status', 0)->latest()->get();

        return response()->json([
            'status' => 200,
            'registerSouvenir' => $registerSouvenir,
        ]);
    }
    public function starRegisterUserSouvenirList(){
        $star = auth('sanctum')->user()->id;

        $registerSouvenir = SouvenirApply::where('star_id', $star)->where('status', 0)->latest()->get();

        return response()->json([
            'status' => 200,
            'registerSouvenir' => $registerSouvenir,
        ]);
    }

    public function activitiesUserSouvenir(){
        $user = auth('sanctum')->user()->id;

        $userSouvenir = SouvenirApply::where('user_id', $user)->latest()->get();

        return response()->json([
            'status' => 200,
            'userSouvenir' => $userSouvenir,
        ]);
    }

    public function registerSouvenirApprove($id){

        $registerSouvenir = SouvenirApply::find($id);
        $registerSouvenir->status = 1;
        $registerSouvenir->save();

        return response()->json([
            'status' => 200,
            'message' => 'Souvenir Approve Successfully'
        ]);
    }
    public function registerSouvenirDecline($id){

        $registerSouvenir = SouvenirApply::find($id);
        $registerSouvenir->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Souvenir Declined Successfully'
        ]);
    }

    public function registerSouvenirView($id){

        $souvinerView = SouvenirApply::find($id);

        return response()->json([
            'status' => 200,
            'souvinerView' => $souvinerView,
        ]);
    }

}
