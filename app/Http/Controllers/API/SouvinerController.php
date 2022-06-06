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
use App\Models\Souvenir;
use App\Models\User;

class SouvinerController extends Controller
{
    public function souvinerStore(Request $request){
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

            $souvenir = new Souvenir();
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

            $souvenir = new Souvenir();
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

            $souvenir->approval_status = 1;

            $souvenir->save();

            return response()->json([
                'status' => 200,
                'message' => 'Souvenir Added Successfully',
            ]);

        }
    }
}
