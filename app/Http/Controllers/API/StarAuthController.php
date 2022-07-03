<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\JuryBoard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\SuperStar;
use App\Models\LiveChat;
use Illuminate\Support\Facades\Hash;
use Auth;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;

class StarAuthController extends Controller
{
    public function register(Request $request)
    {


        $validator = Validator::make($request->all(), [
            // 'email' => 'required|unique:users,email',
            // 'phone' => 'required|unique:users,phone',
            'terms_and_condition' => 'required|min:4',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'validation_errors' => $validator->errors(),
            ]);
        } else {

            $user = User::find($request->star_id);

            if ($request->hasfile('image')) {
                // return $request->image;
                $destination = $user->image;
                if (File::exists($destination)) {
                    File::delete($destination);
                }
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension();
                $filename = 'uploads/images/users/stars' . time() . '.' . $extension;
                Image::make($file)->resize(900, 400)->save($filename, 50);

                $user->image = $filename;
            }

            $user->save();

            if ($user) {
                $star_profile = SuperStar::where('star_id', $user->id)->first();
                if (isset($star_profile) && $star_profile->id) {
                    $star = $star_profile;
                } else {
                    $star = new SuperStar();
                }


                $star->star_id = $user->id;
                $star->admin_id = auth('sanctum')->user()->id;
                $star->category_id = auth('sanctum')->user()->category_id;
                $star->sub_category_id =  auth('sanctum')->user()->sub_category_id;
                $star->terms_and_condition = $request->input('terms_and_condition');
                $star->qr_code = rand(10000000, 99999999);

                if ($request->hasfile('signature')) {

                    $destination = $star->signature;
                    if (File::exists($destination)) {
                        File::delete($destination);
                    }
                    $file = $request->file('signature');
                    $extension = $file->getClientOriginalExtension();
                    $filename = 'uploads/images/users/stars' . time() . '.' . $extension;
                    Image::make($file)->resize(900, 400)->save($filename, 50);

                    $star->signature = $filename;
                }

                if ($request->hasFile('profile_file_one')) {
                    if ($star->star_file_one != null && file_exists($star->star_file_one)) {
                        unlink($star->star_file_one);
                    }
                    $file        = $request->file('profile_file_one');
                    $path        = 'uploads/images/users/stars';
                    $file_name   = time() . rand('0000', '9999') . '.' . $file->getClientOriginalName();
                    $file->move($path, $file_name);
                    $star->star_file_one = $path . '/' . $file_name;
                }

                if ($request->hasFile('profile_file_two')) {
                    if ($star->star_file_two != null && file_exists($star->star_file_two)) {
                        unlink($star->star_file_two);
                    }
                    $file        = $request->file('profile_file_two');
                    $path        = 'uploads/images/users/stars';
                    $file_name   = time() . rand('0000', '9999') . '.' . $file->getClientOriginalName();
                    $file->move($path, $file_name);
                    $star->star_file_two = $path . '/' . $file_name;
                }

                $star->save();
            }

            return response()->json([
                'status' => 200,
                'message' => 'Star Added Successfully',
            ]);
        }
    }

    public function star_details($id)
    {
        $star = User::find($id);
        $star_details = SuperStar::where('star_id', $id)->first();
        return response()->json([
            'status' => 200,
            'star_details' => $star_details,
        ]);
    }

    /**
     * star instruction
     */
    public function starInstrucation()
    {
        $star = SuperStar::where('star_id', auth('sanctum')->user()->id)->first();

        return response()->json([
            'status' => 200,
            'star_details' => $star,
        ]);
    }

    public function superStar_register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|unique:users,email',
            'phone' => 'required|unique:users,phone',
            'password' => 'required|min:4'
        ]);



        if ($validator->fails()) {
            return response()->json([
                'validation_errors' => $validator->errors(),
            ]);
        } else {

            $user = User::find($request->input('id'));

            $user->email = $request->input('email');
            $user->phone = $request->input('phone');
            $user->otp = rand(100000, 999999);
            $user->password = Hash::make($request->input('password'));

            $user->save();

            $token = $user->createToken($user->email . '_Token')->plainTextToken;

            send_sms('Welcome to Hello SuperStars, your otp is : ' . $user->otp, $user->phone);


            return response()->json([
                'status' => 200,
                'id' => $user->id,
                'auth_type' => $user->user_type,
                'name' => $user->first_name . ' ' . $user->last_name,
                'token' => $token,
                'message' => 'Verify Phone Number',
            ]);
        }
    }


    public function admin_add_live_session(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:live_chats,title',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'validation_errors' => $validator->errors(),
            ]);
        } else {
            $superStar = SuperStar::where('star_id', $request->input('star_id'))->first();

            $liveChat = new LiveChat();
            $liveChat->title = $request->input('title');
            $liveChat->star_id = $request->input('star_id');
            $liveChat->category_id = $superStar->category_id;
            $liveChat->admin_id = $superStar->admin_id;
            $liveChat->created_by_id = auth('sanctum')->user()->id;
            $liveChat->description = $request->input('description');
            $liveChat->date = $request->input('date');
            $liveChat->start_time = Carbon::parse($request->input('start_time'));
            $liveChat->end_time = Carbon::parse($request->input('end_time'));
            $liveChat->fee = $request->input('fee');

            if ($request->hasfile('image')) {
                $destination = $liveChat->banner;
                if (File::exists($destination)) {
                    File::delete($destination);
                }
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension();
                $filename = 'uploads/images/live_chat/' . time() . '.' . $extension;

                Image::make($file)->resize(400, 400)->save($filename, 100);
                $liveChat->banner = $filename;
            }

            $liveChat->save();
            return response()->json([
                'status' => 200,
                'message' => 'Live Session Added',
            ]);
        }
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required|min:4'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'validation_errors' => $validator->errors(),
            ]);
        } else {
            $user = User::where('email', $request->email)->orWhere('phone', $request->email)->first();

            if (!$user || !Hash::check($request->password, $user->password)) {
                return response()->json([
                    'status' => 401,
                    'message' => 'Invalid Credantials',
                ]);
            } else {
                if ($user->user_type == 'admin' && $user->status == 1) {
                    $token = $user->createToken($user->email . '_AdminToken', ['server:admin'])->plainTextToken;
                    $role = 'admin';
                } else if ($user->user_type == 'star' && $user->status == 1) {
                    $token = $user->createToken($user->email . '_StarToken', ['server:star'])->plainTextToken;
                    $role = 'star';
                } else if ($user->user_type == 'audition-admin' && $user->status == 1) {
                    $token = $user->createToken($user->email . '_StarToken', ['server:audition-admin'])->plainTextToken;
                    $role = 'audition-admin';
                } else if ($user->user_type == 'jury' && $user->status == 1) {
                    $token = $user->createToken($user->email . '_StarToken', ['server:audition-admin'])->plainTextToken;
                    $role = 'jury';
                } else if ($user->status != 1) {
                    return response()->json([
                        'status' => 401,
                        'message' => 'You are not approved yet..',
                    ]);
                } else {
                    return response()->json([
                        'status' => 401,
                        'message' => 'Invalid Credantials',
                    ]);
                }

                send_sms('Welcome to Hello Super Stars, Your otp is : ' . $user->otp, $user->phone);

                return response()->json([
                    'status' => 200,
                    'name' => $user->first_name . ' ' . $user->last_name,
                    'token' => $token,
                    'role' => $role,
                    'phone' => $user->phone,
                    'message' => 'Verify Your Phone Number',
                ]);
            }
        }
    }


    public function otp_verify(Request $request)
    {

        $user = User::where('email', auth('sanctum')->user()->email)->first();

        if ($request->otp == $user->otp) {

            return response()->json([
                'status' => 200,
                'message' => 'You are logged in successfully!',
                'phone' => $user->phone,
                'auth_type' => $user->user_type,
            ]);
        } else {
            return response()->json([
                'status' => 401,
                'message' => 'Invalid OTP',
            ]);
        }
    }

    public function qr_verify(Request $request)
    {

        $superStar = SuperStar::all();

        $juryBoard = JuryBoard::all();

        $merged = $superStar->merge($juryBoard);

        $user = $merged->where('qr_code', $request->qr_code)->first();



        if ($user) {
            if (User::find($user->star_id)->email && User::find($user->star_id)->phone) {
                return response()->json([
                    'status' => 409,
                    'message' => 'This Star Already Registered!',
                ]);
            } else {
                return response()->json([
                    'status' => 200,
                    'star_id' => $user->star_id,
                    'auth_type' => User::find($user->star_id)->user_type,
                    'message' => 'QR Code Matched!',
                ]);
            }
        } else {
            return response()->json([
                'status' => 401,
                'message' => 'Invalid QR Code!',
            ]);
        }
    }
}
