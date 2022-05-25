<?php

namespace App\Http\Controllers\API\Audition\Jury;

use App\Http\Controllers\Controller;
use App\Models\JuryBoard;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\User;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\File;

class JuryAuthController extends Controller
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
            $user->user_type = 'jury';
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


            $star = new JuryBoard();

            $star->star_id = $user->id;
            $star->admin_id = auth('sanctum')->user()->id;
            $star->category_id = $request->input('category_id');
            $star->sub_category_id = $request->input('subcategory_id');
            $star->terms_and_condition = $request->input('terms&condition');
            $star->qr_code = rand( 10000000 , 99999999 );


            $star->save();

            return response()->json([
                'status'=>200,
                'message'=> 'Jury Added Successfully',
            ]);
        }
    }

}
