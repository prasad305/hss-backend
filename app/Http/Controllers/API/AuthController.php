<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\AuditionParticipant;
use App\Models\GreetingsRegistration;
use App\Models\LearningSessionRegistration;
use App\Models\MeetupEventRegistration;
use App\Models\LiveChatRegistration;
use App\Models\LiveChat;
use App\Models\QnaRegistration;
use App\Models\SuperStar;
//use Dotenv\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\UserInfo;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
//use Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;


class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|unique:users,email|email:rfc,dns|email',
            'phone' => 'required|unique:users,phone',
            'password' => 'required|min:4'

        ]);

        if ($validator->fails()) {
            return response()->json([
                'validation_errors' => $validator->errors(),
            ]);
        } else {
            $user = User::create([
                'username' => $request->first_name . now()->timestamp,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
                'otp' => rand(100000, 999999)
            ]);

            $token = $user->createToken($user->email . '_Token')->plainTextToken;

            // send sms via helper function
            send_sms('Welcome to Hello Super Stars, Your otp is : ' . $user->otp, $user->phone);


            return response()->json([
                'status' => 200,
                'id' => $user->id,
                'token' => $token,
                'user' => $user,
                'message' => 'Verify Phone Number',
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
            $user = User::where([['email', $request->email], ['user_type', 'user']])->orWhere([['phone', $request->email], ['user_type', 'user']])->first();

            if (!$user || !Hash::check($request->password, $user->password)) {
                return response()->json([
                    'status' => 401,
                    'message' => 'Invalid Credantials',
                ]);
            } else {
                if ($user->user_type == 'user') {
                    $token = $user->createToken($user->email . '_UserToken', ['server:user'])->plainTextToken;
                    $role = 1;
                } else if ($user->user_type == 'admin' && $user->status == 1) {
                    $token = $user->createToken($user->email . '_AdminToken', ['server:admin'])->plainTextToken;
                    $role = 8;
                } else if ($user->user_type == 'star' && $user->status == 1) {
                    $token = $user->createToken($user->email . '_StarToken', ['server:star'])->plainTextToken;
                    $role = 7;
                } else if ($user->user_type == null) {
                    $token = $user->createToken($user->email . '_Token', [''])->plainTextToken;
                    $role = 0;
                } else {
                    $token = $user->createToken($user->email . '_Token', [''])->plainTextToken;
                    $role = 0;
                }

                return response()->json([
                    'status' => 200,
                    'email' => $user->email,
                    'name' => $user->first_name . ' ' . $user->last_name,
                    'id' => $user->id,
                    'user_type' => $user->user_type,
                    'token' => $token,
                    'role' => $role,
                    'user' => $user,
                    'message' => 'Logged In Successfully',
                ]);
            }
        }
    }


    public function user_authentication(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required|min:4'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'validation_errors' => $validator->errors(),
            ]);
        } else {
            $user = User::where('username', $request->username)->first();

            if (!$user || !Hash::check($request->password, $user->password)) {
                return response()->json([
                    'status' => 401,
                    'message' => 'Invalid Credantials',
                ]);
            } else {
                if ($user->user_type == 'user') {
                    $token = $user->createToken($user->email . '_UserToken', ['server:user'])->plainTextToken;
                    $role = 1;
                } else if ($user->user_type == 'admin' && $user->status == 1) {
                    $token = $user->createToken($user->email . '_AdminToken', ['server:admin'])->plainTextToken;
                    $role = 8;
                } else if ($user->user_type == 'star' && $user->status == 1) {
                    $token = $user->createToken($user->email . '_StarToken', ['server:star'])->plainTextToken;
                    $role = 7;
                } else if ($user->user_type == null) {
                    $token = $user->createToken($user->email . '_Token', [''])->plainTextToken;
                    $role = 0;
                } else {
                    $token = $user->createToken($user->email . '_Token', [''])->plainTextToken;
                    $role = 0;
                }

                return response()->json([
                    'status' => 200,
                    'email' => $user->email,
                    'name' => $user->first_name . ' ' . $user->last_name,
                    'id' => $user->id,
                    'user_type' => $user->user_type,
                    'token' => $token,
                    'role' => $role,
                    'user' => $user,
                    'message' => 'Logged In Successfully',
                ]);
            }
        }
    }



    public function verify_user(Request $request)
    {
        $user = User::find(auth('sanctum')->user()->id);

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => 401,
                'message' => 'Invalid Credantials',
            ]);
        } else {
            return response()->json([
                'status' => 200,
                'message' => 'Verified',
            ]);
        }
    }

    public function VerifyToRegisterEvent(Request $request)
    {
        $user = User::find(auth('sanctum')->user()->id);
        $eventId = (string)$request->event_id;
        $modelName = $request->model_name;

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => 401,
                'message' => 'Invalid Credantials',
            ]);
        } else {
            // MeetupEventRegistration
            if ($modelName == 'MeetupEventRegistration') {
                $countValue  = MeetupEventRegistration::where('user_id', $user->id)->where('meetup_event_id', $eventId)->count();
            }
            if ($modelName == 'LearningSessionRegistration') {
                $countValue  = LearningSessionRegistration::where('user_id', $user->id)->where('learning_session_id', $eventId)->count();
            }
            if ($modelName == 'LiveChatRegistration') {
                $countValue  = LiveChatRegistration::where('user_id', $user->id)->where('live_chat_id', $eventId)->count();
            }
            if ($modelName == 'QnaRegistration') {
                $countValue  = QnaRegistration::where('user_id', $user->id)->where('qna_id', $eventId)->count();
            }
            if ($modelName == 'GreetingsRegistration') {
                $countValue  = GreetingsRegistration::where([['user_id', $user->id], ['greeting_id', $eventId], ['status', 0]])->count();
            }
            // if( $modelName == 'AuditionParticipant'){
            //     $countValue  = AuditionParticipant::where('user_id',$user->id)->where('audition_id',$eventId)->count();
            // }

            if ($countValue > 0) {
                $is_already_registered = true;
            } else {
                $is_already_registered = false;
            }
            return response()->json([
                'status' => 200,
                'message' => 'Verified',
                'is_already_registered' => $is_already_registered,
            ]);
        }
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Logged Out Successfully',
        ]);
    }

    public function activity_count()
    {
        $activity = Activity::where('user_id', auth('sanctum')->user()->id)->count();

        return response()->json([
            'status' => 200,
            'activity' => $activity,
        ]);
    }


    public function otp_verify(Request $request)
    {

        $user = User::where('email', auth('sanctum')->user()->email)->first();

        if ($request->otp == $user->otp) {

            $user->user_type = 'user';
            $user->otp_verified_at = Carbon::now();
            $user->save();

            return response()->json([
                'status' => 200,
                'message' => 'Registration Successful!',
                'phone' => $user->phone,

            ]);
        } else {
            return response()->json([
                'status' => 401,
                'message' => 'Invalid OTP',
            ]);
        }


        //return auth()->user();

    }

    public function resend_otp()
    {
        $user = auth('sanctum')->user();

        // send sms via helper function
        send_sms('Welcome to Hello SuperStars, your otp is : ' . $user->otp, $user->phone);

        return response()->json([
            'status' => 200,
            'message' => 'OTP has been Sent Again in ' . $user->phone,
        ]);
    }

    public function reset_otp()
    {
        $user = User::find(auth('sanctum')->user()->id);

        $user->otp = rand('100000', '999999');

        $user->update();

        return response()->json([
            'status' => 200,
        ]);
    }

    public function user_info()
    {
        $user = User::find(auth('sanctum')->user()->id);

        $user_info = UserInfo::where('user_id', $user->id)->first();
        $star_details = SuperStar::where('star_id', auth('sanctum')->user()->id)->first();

        if (empty($user_info)) {
            $user_info = new UserInfo;
        }

        return response()->json([
            'status' => 200,
            'users' => $user,
            'info' => $user_info,
            'star_details' => $star_details
        ]);
    }

    public function user_data($id)
    {
        $user = User::find($id);

        $user_info = UserInfo::where('user_id', $user->id)->first();
        $star_details = SuperStar::where('star_id', $user->id)->first();

        if (empty($user_info)) {
            $user_info = new UserInfo;
        }

        return response()->json([
            'status' => 200,
            'users' => $user,
            'info' => $user_info,
            'star_details' => $star_details
        ]);
    }



    public function user_info_update(Request $request)
    {

        // return $request->all();

        $user = User::find(auth('sanctum')->user()->id);

        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->password = Hash::make($request->new_password);

        if ($request->hasFile('image')) {
            if ($user->image != null)
                File::delete(public_path($user->image)); //Old image delete
            $image             = $request->file('image');
            $folder_path       = 'uploads/images/users/';
            $image_new_name    = Str::random(3) . '-' . now()->timestamp . '.' . $image->getClientOriginalExtension();
            //resize and save to server
            Image::make($image->getRealPath())->resize(400, 400)->save($folder_path . $image_new_name, 100);
            $user->image   = $folder_path . $image_new_name;
        }

        if ($request->hasFile('cover_photo')) {
            if ($user->cover_photo != null)
                File::delete(public_path($user->cover_photo)); //Old image delete
            $image             = $request->file('cover_photo');
            $folder_path       = 'uploads/images/users/';
            $image_new_name    = Str::random(3) . '-' . now()->timestamp . '.' . $image->getClientOriginalExtension();
            //resize and save to server
            Image::make($image->getRealPath())->resize(900, 300)->save($folder_path . $image_new_name, 100);
            $user->cover_photo   = $folder_path . $image_new_name;
        }


        $user->update();

        $user_info = UserInfo::where('user_id', $user->id)->first();

        if (empty($user_info)) {
            $user_info = new UserInfo;
        }

        $user_info->user_id = $user->id;
        $user_info->dob = $request->dob;
        $user_info->country = $request->country;
        $user_info->save();


        return response()->json([
            'status' => 200,
            'message' => 'Your Information Updated Successfully'
        ]);
    }

    public function user_OtherInfo_update(Request $request)
    {
        $user = auth('sanctum')->user();

        $user_info = UserInfo::where('user_id', $user->id)->first();

        if (empty($user_info)) {
            $user_info = new UserInfo;
        }

        $user_info->occupation = $request->occupation;
        $user_info->edu_level = $request->edu_level;
        $user_info->institute = $request->institute;
        $user_info->subject = $request->subject;
        $user_info->position = $request->position;
        $user_info->company = $request->company;
        $user_info->salery_range = $request->salery_range;

        $user_info->save();


        return response()->json([
            'status' => 200,
            'message' => 'Your Other Information Updated Successfully'
        ]);
    }



    public function star_admin_info_update(Request $request)
    {

        // return $request->all();

        $user = User::find(auth('sanctum')->user()->id);
        if (Hash::check($request->password, $user->password) || Hash::check($request->current_password, $user->password)) {

            if ($request->filled('first_name')) {
                $user->first_name = $request->first_name;
            }
            if ($request->filled('last_name')) {
                $user->last_name = $request->last_name;
            }
            if ($request->filled('email')) {
                $user->email = $request->email;
            }
            if ($request->filled('new_password')) {
                $user->password =  Hash::make($request->new_password);
            }
            if ($request->filled('phone')) {
                $user->phone = $request->phone;
            }

            if ($request->hasFile('image')) {
                if ($user->image != null)
                    File::delete(public_path($user->image)); //Old image delete
                $image             = $request->file('image');
                $folder_path       = 'uploads/images/users/';
                $image_new_name    = Str::random(3) . '-' . now()->timestamp . '.' . $image->getClientOriginalExtension();
                //resize and save to server
                Image::make($image->getRealPath())->resize(400, 400)->save($folder_path . $image_new_name, 100);
                $user->image   = $folder_path . $image_new_name;
            }

            if ($request->hasFile('cover_photo')) {
                if ($user->cover_photo != null)
                    File::delete(public_path($user->cover_photo)); //Old image delete
                $image             = $request->file('cover_photo');
                $folder_path       = 'uploads/images/users/';
                $image_new_name    = Str::random(3) . '-' . now()->timestamp . '.' . $image->getClientOriginalExtension();
                //resize and save to server
                Image::make($image->getRealPath())->resize(900, 300)->save($folder_path . $image_new_name, 100);
                $user->cover_photo   = $folder_path . $image_new_name;
            }


            $user->update();

            $user_info = UserInfo::where('user_id', $user->id)->first();

            if (empty($user_info)) {
                $user_info = new UserInfo;
            }
            $user_info->user_id = $user->id;
            if ($request->filled('dob')) {
                $user_info->dob = $request->dob;
            }
            if ($request->filled('country')) {

                $user_info->country = $request->country;
            }
            $user_info->save();


            return response()->json([
                'status' => 200,
                'message' => 'Your Information Updated Successfully'
            ]);
        } else {
            return response()->json([
                'status' => 402,
                'message' => 'Password Not Match'
            ]);
        }
    }
}
