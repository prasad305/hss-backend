<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\SuperStar;
use App\Models\ChoiceList;
use App\Models\SubCategory;

class SubCategoryController extends Controller
{
    public function index($slug)
    {
        $category = Category::where('slug',$slug)->first();
        $subcategory = SubCategory::where('category_id',$category->id)->get();

        $id = auth('sanctum')->user()->id;
        $selectedCategory = ChoiceList::where('user_id' ,$id)->first();

        $selectedCategory = json_decode($selectedCategory->category);

        return response()->json([
            'status' => 200,
            'subcategory' => $subcategory,
            'selectedCategory' => $selectedCategory,
        ]);
    }


    public function select_sub_category(Request $req)
    {

        $subCategories = SuperStar::whereIn('sub_category_id',$req->cat)->get();

        $user = ChoiceList::where('user_id',auth('sanctum')->user()->id)->first();

        if($user)
        {
            $user->subcategory = json_encode($req->cat);
            $user->update();
        }
        else{
            ChoiceList::create([
                'user_id'=>auth('sanctum')->user()->id,
                'subcategory'=> json_encode($req->cat)
            ]);
        }

        return response()->json([
            'status' => 200,
            'message' => 'Working ok',
            'length' => $subCategories,
        ]);
    }


    public function select_star(Request $req)
    {

        $user = ChoiceList::where('user_id',auth('sanctum')->user()->id)->first();

        if($user)
        {
            $user->star_id = json_encode($req->cat);
            $user->update();
        }
        else{
            ChoiceList::create([
                'user_id'=>auth('sanctum')->user()->id,
                'star_id'=> json_encode($req->cat)
            ]);
        }

        return response()->json([
            'status' => 200,
            'message' => 'Super Stars Selected',
            'result' => $req->all(),
        ]);


    }
}
