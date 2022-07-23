<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ChoiceList;
use App\Models\Post;
use Illuminate\Http\Request;

class GuestController extends Controller
{
    public function paginate_all_post($limit)
    {
        // $id = auth('sanctum')->user()->id;

        // $selectedCategory = ChoiceList::where('user_id', $id)->first();

        // $selectedCat = json_decode($selectedCategory->category);
        // $selectedSubCat = json_decode($selectedCategory->subcategory);
        // $selectedSubSubCat = json_decode($selectedCategory->star_id);

        // $cat_post = Post::select("*")
        //     ->whereIn('category_id', $selectedCat)
        //     ->orderBy('id','DESC')->paginate($limit);

        // if (isset($sub_cat_post)) {
        //     $sub_cat_post = Post::select("*")
        //         ->whereIn('sub_category_id', $selectedSubCat)
        //         ->orderBy('id','DESC')->paginate($limit);
        // } else {
        //     $sub_cat_post = [];
        // }

        // if (isset($sub_sub_cat_post)) {
        //     $sub_sub_cat_post = Post::select("*")
        //         ->whereIn('user_id', $selectedSubSubCat)
        //         ->orderBy('id','DESC')->paginate($limit);
        // } else {
        //     $sub_sub_cat_post = [];
        // }

        $cat_post = Post::select("*")
            ->orderBy('id','DESC')->paginate($limit);

        $sub_cat_post = [];

        $post = $cat_post->concat($sub_cat_post);
        // $post = $cat_post;

        return response()->json([
            'status' => 200,
            'message' => 'Ok',
            'posts' => $post,
        ]);
    }
}
