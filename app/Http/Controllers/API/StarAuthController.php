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

        $validator = Validator::make($request->all(),[
            // 'email' => 'required|unique:users,email',
            // 'phone' => 'required|unique:users,phone',
            // 'password' => 'required|min:4'
        ]);

        if($validator->fails())
        {
            return response()->json([
                'validation_errors'=>$validator->errors(),
            ]);
        }

        else
        {

            $user = new User();

            $user->first_name = $request->input('first_name');
            $user->last_name = $request->input('last_name');
            $user->user_type = 'star';
            $user->parent_user = auth('sanctum')->user()->id;


            if($request->hasfile('image'))
            {
                $destination = $user->image;
                if(File::exists($destination))
                {
                    File::delete($destination);
                }
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension();
                $filename = 'uploads/images/users/'.time(). '.' . $extension;

                Image::make($file)->resize(400,400)
                ->save($filename, 100);

                $user->image = $filename;
            }

            if($request->hasfile('imagem[]'))
            {

                return response()->json([
                    'status'=>200,
                    'message'=> 'Multi Image Working',
                ]);

                $destination = $user->image;
                if(File::exists($destination))
                {
                    File::delete($destination);
                }
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension();
                $filename = 'uploads/images/users/'.time(). '.' . $extension;

                Image::make($file)->resize(400,400)
                ->save($filename, 100);

                $user->image = $filename;
            }

            $user->save();


            $star = new SuperStar();

            $star->star_id = $user->id;
            $star->admin_id = auth('sanctum')->user()->id;
            $star->category_id = $request->input('category_id');
            $star->sub_category_id = $request->input('subcategory_id');
            $star->terms_and_condition = $request->input('terms&condition');
            $star->qr_code = rand( 10000000 , 99999999 );


            $star->save();

            return response()->json([
                'status'=>200,
                'message'=> 'Star Added Successfully',
            ]);
        }
    }

    public function superStar_register(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'email' => 'required|unique:users,email',
            'phone' => 'required|unique:users,phone',
            'password' => 'required|min:4'
        ]);

        // return $request->all();

        if($validator->fails())
        {
            return response()->json([
                'validation_errors'=>$validator->errors(),
            ]);
        }

        else
        {

            $user = User::find($request->input('id'));

            $user->email = $request->input('email');
            $user->phone = $request->input('phone');
            $user->otp = rand(100000, 999999);
            $user->password = Hash::make($request->input('password'));

            $user->save();

            $token = $user->createToken($user->email.'_Token')->plainTextToken;

            send_sms('Welcome to Hello SuperStars, your otp is : ' . $user->otp, $user->phone);


            return response()->json([
                'status'=>200,
                'id'=>$user->id,
                'auth_type'=>$user->user_type,
                'name'=>$user->first_name.' '.$user->last_name,
                'token'=>$token,
                'message'=>'Verify Phone Number',
            ]);
        }
    }


    public function admin_add_live_session(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'title' => 'required|unique:live_chats,title',
        ]);

        if($validator->fails())
        {
            return response()->json([
                'validation_errors'=>$validator->errors(),
            ]);
        }

        else
        {
            $superStar = SuperStar::where('star_id',$request->input('star_id'))->first();

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

            if($request->hasfile('image'))
            {
                $destination = $liveChat->banner;
                if(File::exists($destination))
                {
                    File::delete($destination);
                }
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension();
                $filename = 'uploads/images/live_chat/'.time(). '.' . $extension;

                Image::make($file)->resize(400,400)->save($filename, 100);
                $liveChat->banner = $filename;
            }

            $liveChat->save();
            return response()->json([
                'status'=>200,
                'message'=>'Live Session Added',
            ]);
        }
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'email' => 'required',
            'password' => 'required|min:4'
        ]);

        if($validator->fails())
        {
            return response()->json([
                'validation_errors'=>$validator->errors(),
            ]);
        }
        else
        {
            $user = User::where('email', $request->email)->orWhere('phone', $request->email)->first();

            if (! $user || ! Hash::check($request->password, $user->password)) {
                return response()->json([
                    'status'=>401,
                    'message'=>'Invalid Credantials',
                ]);
            }
            else
            {
                if($user->user_type == 'admin' && $user->status == 1)
                {
                    $token = $user->createToken($user->email.'_AdminToken', ['server:admin'])->plainTextToken;
                    $role = 'admin';
                }
                else if($user->user_type == 'star' && $user->status == 1)
                {
                    $token = $user->createToken($user->email.'_StarToken', ['server:star'])->plainTextToken;
                    $role = 'star';
                }
                else if($user->user_type == 'audition-admin' && $user->status == 1)
                {
                    $token = $user->createToken($user->email.'_StarToken', ['server:audition-admin'])->plainTextToken;
                    $role = 'audition-admin';
                }
                else if($user->user_type == 'jury' && $user->status == 1)
                {
                    $token = $user->createToken($user->email.'_StarToken', ['server:audition-admin'])->plainTextToken;
                    $role = 'jury';
                }
                else if($user->status != 1)
                {
                    return response()->json([
                        'status'=>401,
                        'message'=>'You are not approved yet..',
                    ]);
                }
                else
                {
                    return response()->json([
                        'status'=>401,
                        'message'=>'Invalid Credantials',
                    ]);
                }

                send_sms('Welcome to Hello Super Stars, Your otp is : ' . $user->otp, $user->phone);

                return response()->json([
                    'status'=>200,
                    'name'=>$user->first_name.' '.$user->last_name,
                    'token'=>$token,
                    'role'=>$role,
                    'phone'=>$user->phone,
                    'message'=>'Verify Your Phone Number',
                ]);
            }
        }
    }


    public function otp_verify(Request $request)
    {

            $user = User::where('email', auth('sanctum')->user()->email)->first();

            if ($request->otp == $user->otp) {

                return response()->json([
                    'status'=>200,
                    'message'=>'You are logged in successfully!',
                    'phone'=>$user->phone,
                    'auth_type'=>$user->user_type,
                ]);
            }
            else
            {
                return response()->json([
                    'status'=>401,
                    'message'=>'Invalid OTP',
                ]);
            }
    }

    public function qr_verify(Request $request)
    {


        $superStar = SuperStar::all();

        $juryBoard = JuryBoard::all();
        
        $merged = $superStar->merge($juryBoard);
        
        $user = $merged->where('qr_code',$request->qr_code)->first();

            if ($user) {

                return response()->json([
                    'status'=>200,
                    'star_id' => $user->star_id,
                    'auth_type' => $user->user_type,
                    'message'=>'QR Code Matched!',
                ]);
            }
            else
            {
                return response()->json([
                    'status'=>401,
                    'message'=>'Invalid QR Code!',
                ]);
            }
    }
}
