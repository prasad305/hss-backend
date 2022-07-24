<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ChoiceList;
use App\Models\Post;
use App\Models\PromoVideo;
use Illuminate\Http\Request;

class GuestController extends Controller
{
    public function paginate_all_post($limit)
    {
        $cat_post = Post::select("*")
            ->orderBy('id','DESC')->paginate($limit);

        $sub_cat_post = [];

        $post = $cat_post->concat($sub_cat_post);

        return response()->json([
            'status' => 200,
            'message' => 'Ok',
            'posts' => $post,
        ]);
    }


    public function getPromoVideo()
    {
        $cat_promo = PromoVideo::latest()->get();
        $sub_cat_promo = [];
        $promoVideos = $cat_promo->concat($sub_cat_promo);

        return response()->json([
            'status' => 200,
            'promoVideos' => $promoVideos,
        ]);
    }
}
