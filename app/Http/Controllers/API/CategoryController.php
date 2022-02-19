<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Category;
use App\Models\ChoiceList;
use App\Models\SubCategory;
use App\Models\SuperStar;

class CategoryController extends Controller
{
    //
    public function index()
    {
        $category = Category::all();

        return response()->json([
            'status' => 200,
            'category' => $category,
        ]);
    }

    public function fetch_subcategory($id)
    {
        $category = SubCategory::where('category_id', $id)->get();
        return response()->json([
            'status' => 200,
            'category' => $category,
        ]);
    }

    public function star_list()
    {
        $star = User::where('parent_user', auth('sanctum')->user()->id)->get();
        return response()->json([
            'status' => 200,
            'category' => $star,
        ]);
    }

    public function agreement_paper($id)
    {
        $star = SuperStar::where('star_id', $id)->first();

        return response()->json([
            'status' => 200,
            'star' => $star,
        ]);
    }

    public function select_category(Request $req)
    {

        $subCategories = SubCategory::whereIn('category_id',$req->cat)->get();

        $user = ChoiceList::where('user_id',auth('sanctum')->user()->id)->first();


        if($user)
        {
            $user->category = json_encode($req->cat);
            $user->update();
        }
        else{
            ChoiceList::create([
                'user_id'=> auth('sanctum')->user()->id,
                'category'=> json_encode($req->cat)
            ]);
        }

        return response()->json([
            'status' => 200,
            'message' => 'Working',
            'length' => $subCategories,
            'category' => $req->cat,
        ]);
    }


    public function check()
    {
        $data = ChoiceList::where('user_id',auth('sanctum')->user()->id)->first();


        return response()->json([
            'status' => 200,
            'message' => 'Working',
            'category' => json_decode($data->category),
        ]);

    }
}
