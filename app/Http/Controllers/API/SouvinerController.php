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
use App\Models\Activity;
use App\Models\SouvenirPayment;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Mail\PostNotification;
use Illuminate\Support\Facades\Mail;

class SouvinerController extends Controller
{
    public function souvinerStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:souvenir_creates',
            'description' => 'required',
            'instruction' => 'required',
            'star_id' => 'required',
            'price' => 'required',
            'delivery_charge' => 'required',
            'tax' => 'required',
            'banner' => 'required',
            'video' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'validation_errors' => $validator->errors(),
            ]);
        } else {
            $id = auth('sanctum')->user()->id;
            $user = User::find($id);

            $souvenir = new SouvenirCreate();
            $souvenir->title = $request->title;
            $souvenir->slug = Str::slug($request->title);
            $souvenir->description = $request->description;
            $souvenir->instruction = $request->instruction;
            $souvenir->category_id = $user->category_id;
            $souvenir->sub_category_id = $user->sub_category_id;

            $souvenir->price = $request->price;
            $souvenir->delivery_charge = $request->delivery_charge;
            $souvenir->tax = $request->tax;

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

           $adminAddResult =  $souvenir->save();
           if($adminAddResult){
                $starInfo = getStarInfo($souvenir->star_id);
                $senderInfo = getAdminInfo($souvenir->admin_id);

                SendMail($starInfo->email,$souvenir,$senderInfo);
           }

            return response()->json([
                'status' => 200,
                'message' => 'Souvenir Added Successfully',
                'souvenirId' => $souvenir->id,
            ]);
        }
    }
    public function souvinerStarStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:souvenir_creates',
            'description' => 'required',
            'instruction' => 'required',
            'price' => 'required',
            'delivery_charge' => 'required',
            'tax' => 'required',
            'banner' => 'required',
            'video' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'validation_errors' => $validator->errors(),
            ]);
        } else {
            $id = auth('sanctum')->user()->id;
            $user = User::find($id);

            $souvenir = new SouvenirCreate();
            $souvenir->title = $request->title;
            $souvenir->slug = Str::slug($request->title);
            $souvenir->description = $request->description;
            $souvenir->instruction = $request->instruction;
            $souvenir->price = $request->price;
            $souvenir->delivery_charge = $request->delivery_charge;
            $souvenir->tax = $request->tax;

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

            $starAddResult = $souvenir->save();
            if($starAddResult){
                $managerInfo = getManagerInfoFromCategory(auth('sanctum')->user()->category_id);
                $adminInfo = getAdminInfo(auth('sanctum')->user()->parent_user);
                $senderInfo = getStarInfo(auth('sanctum')->user()->id);

                SendMail($adminInfo->email,$souvenir,$senderInfo);
                SendMail($managerInfo->email,$souvenir,$senderInfo);
            }

            return response()->json([
                'status' => 200,
                'message' => 'Souvenir Added Successfully',
            ]);
        }
    }
    public function souvinerStarStoreMobile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:souvenir_creates',
            'description' => 'required',
            'instruction' => 'required',
            'price' => 'required',
            'delivery_charge' => 'required',
            'tax' => 'required',
            'banner' => 'required',
            'video' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'validation_errors' => $validator->errors(),
            ]);
        } else {
            $id = auth('sanctum')->user()->id;
            $user = User::find($id);

            $souvenir = new SouvenirCreate();
            $souvenir->title = $request->title;
            $souvenir->slug = Str::slug($request->title);
            $souvenir->description = $request->description;
            $souvenir->instruction = $request->instruction;
            $souvenir->price = $request->price;
            $souvenir->delivery_charge = $request->delivery_charge;
            $souvenir->tax = $request->tax;

            $souvenir->category_id = $user->category_id;
            $souvenir->sub_category_id = $user->sub_category_id;

            $souvenir->admin_id = $user->parent_user;
            $souvenir->star_id = $id;

            // Upload Banner started 
            
            if($request->banner['type']){
                try{
                    $originalExtension = str_ireplace("image/", "", $request->banner['type']);
    
                    $folder_path       = 'uploads/images/souviner/apply/';
    
                    $image_new_name    = Str::random(20) . '-' . now()->timestamp . '.' . $originalExtension;
                    $decodedBase64 = $request->banner['data'];
                
                    Image::make($decodedBase64)->save($folder_path . $image_new_name);
                    $location = $folder_path . $image_new_name;
                    $souvenir->banner = $location;
                }
    
                catch (\Exception $exception) {
                    return response()->json([
                        "error" => $exception->getMessage(),
                        "status" => "from image",
                    ]);
                }
            }
            
            // Upload Banner ended


            // Upload Video started 

            if($request->video['type']){
                try{
                    $originalExtension = str_ireplace("video/", "", $request->video['type']);

                    $folder_path       = 'uploads/videos/souviner/';

                    $image_new_name    = Str::random(20) . '-' . now()->timestamp . '.' . $originalExtension;
                    $decodedBase64 = $request->video['data'];
                    $videoPath = $folder_path . $image_new_name;
                    file_put_contents($videoPath, base64_decode($decodedBase64, true));
                    
                    $souvenir->video = $videoPath;
                }
    
                catch (\Exception $exception) {
                    return response()->json([
                        "error" => $exception->getMessage(),
                        "status" => "from video",
                    ]);
                }
            }
            
            // Upload Video ended

            $souvenir->approval_status = 1;

            $souvenir->save();

            return response()->json([
                'status' => 200,
                'message' => 'Souvenir Added Successfully',
            ]);
        }
    }

    public function souvinerCheck()
    {
        $id = auth('sanctum')->user()->id;

        $getUser = SouvenirCreate::where('admin_id', $id)->first();

        return response()->json([
            'status' => 200,
            'getUser' => $getUser,
        ]);
    }

    public function getUserSouvenir($starId)
    {

        $getSouviner = SouvenirCreate::where('star_id', $starId)->where('status', 1)->first();
        return response()->json([
            'status' => 200,
            'getSouviner' => $getSouviner,
        ]);

        // if ($getSouviner) {
        //     return response()->json([
        //         'status' => 200,
        //         'getSouviner' => $getSouviner,
        //     ]);
        // } else {
        //     return response()->json([
        //         'message' => 'Not Services!',
        //     ]);
        // }
    }

    public function statusSouvenirChange($status, $souvenirId)
    {

        $getSouviner = SouvenirApply::find($souvenirId);
        $getSouviner->status = $status;
        $getSouviner->save();

        return response()->json([
            'status' => 200,
            'message' => 'Souvenir status Updated',
        ]);
    }

    public function orderDetailsSouvenir($souvenirId)
    {

        $getSouviner = SouvenirApply::find($souvenirId);

        return response()->json([
            'status' => 200,
            'getSouviner' => $getSouviner,
        ]);
    }

    public function souvinerView($id)
    {
        $viewSouviner = SouvenirCreate::find($id);

        return response()->json([
            'status' => 200,
            'viewSouviner' => $viewSouviner,
        ]);
    }

    public function souvinerUpdate(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:souvenir_creates,title,'.$id,
            'description' => 'required',
            'instruction' => 'required',
            'price' => 'required',
            'delivery_charge' => 'required',
            'tax' => 'required',
            'star_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'validation_errors' => $validator->errors(),
            ]);
        } else {
            $idd = auth('sanctum')->user()->id;

            $user = User::find($idd);

            $souvenir = SouvenirCreate::find($id);

            $souvenir->title = $request->title;
            $souvenir->slug = Str::slug($request->title);
            $souvenir->description = $request->description;
            $souvenir->instruction = $request->instruction;
            $souvenir->price = $request->price;
            $souvenir->delivery_charge = $request->delivery_charge;
            $souvenir->tax = $request->tax;



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

    public function souvinerStarCheck()
    {
        $id = auth('sanctum')->user()->id;

        $getSouviner = SouvenirCreate::where('star_id', $id)->first();

        return response()->json([
            'status' => 200,
            'getSouviner' => $getSouviner,
        ]);
    }

    public function souvinerStarApprove($id)
    {

        $souviner = SouvenirCreate::find($id);
        $souviner->approval_status = 1;
        $approveStar = $souviner->save();
        if($approveStar){
            $managerInfo = getManagerInfoFromCategory(auth('sanctum')->user()->category_id);
            $senderInfo = getStarInfo(auth('sanctum')->user()->id);

            SendMail($managerInfo->email,$souviner,$senderInfo);
        }

        return response()->json([
            'status' => 200,
            'message' => 'Souvenir Approved Successfully',
        ]);
    }

    public function souvinerStarDecline($id)
    {

        $souviner = SouvenirCreate::find($id);
        $souviner->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Souvenir Declined!',
        ]);
    }

    public function souvinerStarEdit($id)
    {

        $getSouviner = SouvenirCreate::find($id);

        return response()->json([
            'status' => 200,
            'getSouviner' => $getSouviner,
        ]);
    }

    public function souvinerStarUpdate(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:souvenir_creates,title,'.$id,
            'description' => 'required',
            'instruction' => 'required',
            'price' => 'required',
            'delivery_charge' => 'required',
            'tax' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'validation_errors' => $validator->errors(),
            ]);
        } else {

            $souvenir = SouvenirCreate::find($id);

            $souvenir->title = $request->title;
            $souvenir->slug = Str::slug($request->title);
            $souvenir->description = $request->description;
            $souvenir->instruction = $request->instruction;
            $souvenir->price = $request->price;
            $souvenir->delivery_charge = $request->delivery_charge;
            $souvenir->tax = $request->tax;

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
    public function applyUserSouvenir(Request $request, $starId)
    {

        $validator = Validator::make($request->all(), [
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

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'validation_errors' => $validator->errors(),
            ]);
        } else {
            $user = User::find(auth('sanctum')->user()->id);
            $star = User::find($starId);
            $souvenirAmount = SouvenirCreate::find($request->souvinerId);

            if (Hash::check($request->password, $user->password)) {

                $apply = new SouvenirApply();
                $apply->name = $request->name;
                $apply->country_id = $request->country_id;
                $apply->state_id = $request->state_id;
                $apply->city_id = $request->city_id;
                $apply->invoice_no = rand(999999999, 9999999999);
                $apply->souvenir_id = $request->souvinerId;
                $apply->total_amount =  $souvenirAmount->price + $souvenirAmount->delivery_charge + $souvenirAmount->tax;
                $apply->description = $request->description;
                $apply->area = $request->area;
                $apply->mobile_no = $request->mobile_no;
                $apply->user_id = auth('sanctum')->user()->id;
                $apply->star_id = $starId;
                $apply->admin_id = $star->parent_user;
                $apply->category_id = $star->category_id;
                if ($request->isRequestFromApp && $request->isRequestFromApp === true) {
                    if ($request['image']['type'] && $request['image']['data']) {
                        // code for image save by base64 data
                        $originalExtension = str_ireplace("image/", "", $request['image']['type']);
                        $folder_path       = 'uploads/images/souviner/apply/';
                        $image_new_name    = Str::random(20) . '-' . now()->timestamp . '.' . $originalExtension;
                        $decodedBase64 = $request['image']['data'];
                        Image::make($decodedBase64)->save($folder_path . $image_new_name);
                        $apply->image = $folder_path . $image_new_name;
                    }
                } else {
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
                }

                $apply->save();

                $activity = new Activity();
                $activity->user_id = auth('sanctum')->user()->id;
                $activity->event_id = $souvenirAmount->id;
                $activity->event_registration_id =  $apply->id;
                $activity->type = 'souvenir';
                $activity->save();

                return response()->json([
                    'status' => 200,
                    'message' => 'Souvenir Applied Successfully',
                ]);
            } else {
                return response()->json([
                    'status' => 201,
                    'message' => 'Passowrd Not Match'
                ]);
            }
        }
    }

    public function registerUserSouvenirList()
    {
        $admin = auth('sanctum')->user()->id;

        $registerSouvenir = SouvenirApply::where('admin_id', $admin)->where('status', 0)->where('is_delete', 0)->latest()->get();
        $userPaymentDueSouvenir = SouvenirApply::where('admin_id', $admin)->where('status', 1)->where('is_delete', 0)->get();
        $userPaymentSouvenir = SouvenirApply::where('admin_id', $admin)->where('status', '>=', 2)->latest()->get();

        return response()->json([
            'status' => 200,
            'registerSouvenir' => $registerSouvenir,
            'userPaymentDueSouvenir' => $userPaymentDueSouvenir,
            'userPaymentSouvenir' => $userPaymentSouvenir,
        ]);
    }
    public function starRegisterUserSouvenirList()
    {
        $star = auth('sanctum')->user()->id;

        $registerSouvenir = SouvenirApply::where('star_id', $star)->where('status', 0)->where('is_delete', 0)->latest()->get();

        $userPaymentDueSouvenir = SouvenirApply::where('star_id', $star)->where('status', 1)->where('is_delete', 0)->get();
        $userPaymentSouvenir = SouvenirApply::where('star_id', $star)->where('status', '>=', 2)->latest()->get();

        return response()->json([
            'status' => 200,
            'registerSouvenir' => $registerSouvenir,
            'userPaymentDueSouvenir' => $userPaymentDueSouvenir,
            'userPaymentSouvenir' => $userPaymentSouvenir,
        ]);
    }

    public function activitiesUserSouvenir()
    {
        $user = auth('sanctum')->user()->id;

        $userSouvenir = SouvenirApply::where('user_id', $user)->latest()->get();

        return response()->json([
            'status' => 200,
            'userSouvenir' => $userSouvenir,
        ]);
    }

    public function registerSouvenirApprove($id)
    {


        $registerSouvenir = SouvenirApply::find($id);
        $registerSouvenir->status = 1;
        $registerSouvenir->save();

        $allRegisterSouvenir = SouvenirApply::where('status', 0)->where('is_delete', 0)->latest()->get();

        return response()->json([
            'status' => 200,
            'allRegisterSouvenir' => $allRegisterSouvenir,
            'message' => 'Souvenir Approve Successfully'
        ]);
    }
    public function registerSouvenirDecline($id)
    {

        $registerSouvenir = SouvenirApply::find($id);
        $registerSouvenir->is_delete = 1;
        $registerSouvenir->save();

        $allRegisterSouvenir = SouvenirApply::where('status', 0)->where('is_delete', 0)->latest()->get();

        return response()->json([
            'status' => 200,
            'allRegisterSouvenir' => $allRegisterSouvenir,
            'message' => 'Souvenir Declined Successfully'
        ]);
    }

    public function registerSouvenirView($id)
    {

        $souvinerView = SouvenirApply::find($id);

        return response()->json([
            'status' => 200,
            'souvinerView' => $souvinerView,
        ]);
    }

    public function activitiesDetailsUserSouvenir($id)
    {

        $detailsSouvenir = SouvenirApply::find($id);

        return response()->json([
            'status' => 200,
            'detailsSouvenir' => $detailsSouvenir,
        ]);
    }

    public function userSouvenirPaymentStore(Request $request)
    {


        $souvenir = new SouvenirPayment();

        $souvenir->souvenir_create_id = $request->souvenir_create_id;
        $souvenir->souvenir_apply_id = $request->souvenir_apply_id;
        $souvenir->user_id = auth('sanctum')->user()->id;
        $souvenir->total_amount = $request->total_amount;
        $souvenir->save();

        return response()->json([
            'status' => 200,
            'message' => 'Souvenir Payment Successfully'
        ]);
    }
}
