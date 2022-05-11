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

        $id = auth('sanctum')->user()->id;
        $selectedCategory = ChoiceList::where('user_id' ,$id)->first();

        if($selectedCategory)
        {
            $selectedCategory = json_decode($selectedCategory->category);

            // $sugg_category = Category::whereNotIn('id', $selectedCategory)->get();
            $sugg_category = Category::select("*")
                        ->whereNotIn('id', $selectedCategory)
                        ->get();
        }else{
            $selectedCategory = [];
            $sugg_category = [];
        }
        


        return response()->json([
            'status' => 200,
            'category' => $category,
            'selectedCategory' => $selectedCategory,
            'sugg_category' => $sugg_category,
        ]);
    }

    public function allSubcategoryList($catId){

        $allSubCat = SubCategory::where('category_id', $catId)
                            ->latest()
                            ->get();

        $id = auth('sanctum')->user()->id;
        $selectedCategory = ChoiceList::where('user_id' ,$id)->first();

        $selectedSubCategory = json_decode($selectedCategory->subcategory);

        // $someSubCat = SubCategory::where('category_id', $catId)
        //                     ->whereIn('id', subcategory)
        //                     ->latest()
        //                     ->get();
        // return $allSubCat;

        return response()->json([
            'status' => 200,
            'message' => 'Ok',
            'allSubCat' => $allSubCat,
            'selectedSubCategory' => $selectedSubCategory,
            // 'someSubCat' => $someSubCat,
        ]);
    }

    public function allLeftSubcategoryList($slug){
        $category = Category::where('slug',$slug)->first();
        $allSubCat = SubCategory::where('category_id',$category->id)->get();

        $id = auth('sanctum')->user()->id;
        $selectedCategory = ChoiceList::where('user_id' ,$id)->first();

        $selectedSubCategory = json_decode($selectedCategory->subcategory);

        // $someSubCat = SubCategory::where('category_id', $catId)
        //                     ->whereIn('id', subcategory)
        //                     ->latest()
        //                     ->get();
        // return $allSubCat;

        return response()->json([
            'status' => 200,
            'message' => 'Ok',
            'allSubCat' => $allSubCat,
            'selectedSubCategory' => $selectedSubCategory,
            // 'someSubCat' => $someSubCat,
        ]);
    }

    public function allStarCategoryList($subCatId){

        $allStarCat = SuperStar::where('sub_category_id', $subCatId)
                            ->latest()
                            ->get();

        $id = auth('sanctum')->user()->id;
        $selectedCategory = ChoiceList::where('user_id' ,$id)->first();

        $selectedStarCategory = json_decode($selectedCategory->star_id);

        // $someSubCat = SubCategory::where('category_id', $subCatId)
        //                     ->whereIn('id', subcategory)
        //                     ->latest()
        //                     ->get();
        // return $allSubCat;

        return response()->json([
            'status' => 200,
            'message' => 'Ok',
            'allStarCat' => $allStarCat,
            'selectedStarCategory' => $selectedStarCategory,
            // 'someSubCat' => $someSubCat,
        ]);
    }

    public function starFollowingList(){

        $id = auth('sanctum')->user()->id;
        $selectedCategory = ChoiceList::where('user_id' ,$id)->first();

        $followStarCategory = json_decode($selectedCategory->star_id);

        $followingStarCategory = Superstar::select("*")
                    ->whereIn('id', $followStarCategory)
                    ->get();

        if($followingStarCategory != null){
            $suggFollowingStarCategory = Superstar::select("*")
                    ->whereNotIn('id', $followStarCategory)
                    ->get();
        }else{
            $suggFollowingStarCategory = Superstar::latest()->get();
        }


        return response()->json([
            'status' => 200,
            'message' => 'Ok',
            'followStarCategory' => $followStarCategory,
            'followingStarCategory' => $followingStarCategory,
            'suggFollowingStarCategory' => $suggFollowingStarCategory,
        ]);
    }

    public function selectedCategoryStore(Request $request)
    {

        $id = auth('sanctum')->user()->id;
        $cat = ChoiceList::where('user_id' ,$id)->first();

        $category = json_decode($request->category);
        $subcategory = json_decode($cat->subcategory);
        $starcategory = json_decode($cat->star_id);

        $subCat=array();
        $starCat=array();

        $catLen=count($category);
        $subCatLen=count($subcategory);
        $starCatLen=count($starcategory ? $starcategory : []);

        for($x=0; $x<$subCatLen; $x++){
            $ok= false;
            for($y=0; $y<$catLen; $y++){
                $scat = SubCategory::find($subcategory[$x]);
                if($category[$y] == $scat->category_id){
                    $ok= true;
                }
            }
            if($ok === false){
                array_push($subCat, $subcategory[$x]);
                // $ok = false;
            }
        }

        for($x=0; $x<$starCatLen; $x++){
            $ok= false;
            for($y=0; $y<$catLen; $y++){
                $scat = SuperStar::find($starcategory[$x]);
                if($category[$y] == $scat->category_id){
                    $ok= true;
                }
            }
            if($ok === false){
                array_push($starCat, $starcategory[$x]);
                // $ok = false;
            }
        }

        $cat->category = $category;
        $cat->subcategory = $subCat;
        $cat->star_id = $starCat;
        $cat->save();

        return response()->json([
            'status' => 200,
            'message' => 'Admin category added',
        ]);
    }

    public function selectedSubCategoryStore(Request $request)
    {

        $id = auth('sanctum')->user()->id;
        $cat = ChoiceList::where('user_id' ,$id)->first();

        $subcategory = json_decode($request->subcategory);
        $starcategory = json_decode($cat->star_id);

        $starCat=array();

        $subCatLen=count($subcategory);
        $starLen=count($starcategory);

        for($x=0; $x<$starLen; $x++){
            $ok= false;
            for($y=0; $y<$subCatLen; $y++){
                $scat = SuperStar::find($starcategory[$x]);
                if($subcategory[$y] == $scat->sub_category_id){
                    $ok= true;
                }
            }
            if($ok === false){
                array_push($starCat, $starcategory[$x]);
                // $ok = false;
            }
        }

        $cat->subcategory = $subcategory;
        $cat->star_id = $starCat;
        $cat->save();

        return response()->json([
            'status' => 200,
            'message' => 'Admin category added',
        ]);
    }

    public function selectedStarCategoryStore(Request $request)
    {

        $id = auth('sanctum')->user()->id;
        $cat = ChoiceList::where('user_id' ,$id)->first();

        $cat->star_id = $request->star_id;
        $cat->save();

        return response()->json([
            'status' => 200,
            'message' => 'Admin category added',
        ]);
    }

    public function selectedCategory()
    {
        $id = auth('sanctum')->user()->id;
        $selectedCategory = ChoiceList::where('user_id' ,$id)->first();

        $selectedCategory = json_decode($selectedCategory->category);

        $userCategory = Category::select("*")
                    ->whereIn('id', $selectedCategory)
                    ->get();

        return response()->json([
            'status' => 200,
            'selectedCategory' => $selectedCategory,
            'userCategory' => $userCategory,
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
