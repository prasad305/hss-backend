<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Auction;
use App\Models\AuctionTerms;
use App\Models\Bidding;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManagerStatic as Image;

class AuctionController extends Controller
{
    public function index()
    {

        $instruction = AuctionTerms::orderBy('id', 'DESC')->get();
        return view('SuperAdmin.AuctionTerms.index', compact('instruction'));
    }
    public function termsCreate()
    {

        return view('SuperAdmin.AuctionTerms.create');
    }
    public function termsEdit($id)
    {
        $instruction = AuctionTerms::findOrFail($id);
        return view('SuperAdmin.AuctionTerms.edit', compact('instruction'));
    }
    public function termsStore(Request $request)
    {

        $request->validate([

            'acquired_instruction' => 'required',


        ], [
            'acquired_instruction.required' => 'Instruction Field Is Required',

        ]);

        try {
            $instruction = AuctionTerms::create(
                $request->all()
            );
            if ($instruction) {
                return response()->json([
                    'success' => true,
                    'message' => 'Instruction Add Successfully'
                ]);
            }
        } catch (\Exception $exception) {
            return response()->json([
                'type' => 'error',
                'message' => 'Opps somthing went wrong. ' . $exception->getMessage(),
            ]);
        }
    }

    public function termsUpdate(Request $request, $id)
    {
        $request->validate([
            'acquired_instruction' => 'required',

        ], [
            'acquired_instruction.required' => 'Instruction Field Is Required',

        ]);

        try {
            $instruction = AuctionTerms::findOrFail($id)->Update(
                [
                    'acquired_instruction' => $request->acquired_instruction
                ]

            );
            if ($instruction) {
                return response()->json([
                    'success' => true,
                    'message' => 'Instruction Updated Successfully'
                ]);
            }
        } catch (\Exception $exception) {
            return response()->json([
                'type' => 'error',
                'message' => 'Opps somthing went wrong. ' . $exception->getMessage(),
            ]);
        }
    }
    public function termsDestroy($id)
    {
        $term = AuctionTerms::findOrfail($id);
        try {
            $term->delete();
            return response()->json([
                'type' => 'success',
                'message' => 'Successfully Deleted !!',
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'type' => 'error',
                'message' => 'error' . $exception->getMessage(),
            ]);
        }
    }
    public function dashboard()
    {
        $categories = Category::get();
        return view('SuperAdmin.Auction.dashboard', compact('categories'));
    }
    public function auctionList($categoryId)
    {
        $postList = Auction::where('category_id', $categoryId)->latest()->get();
        return view('SuperAdmin.Auction.postList', compact('postList'));
    }
    public function auctionDetails($postId)
    {
        $product = Auction::with('star')->find($postId);
        $allbidders = collect(Bidding::with('user')->where('auction_id', $postId)->orderBy('amount', 'DESC')->get());
        $bidders = $allbidders->unique('user_id');
        $totalBidders = Bidding::with('user')->where('auction_id', $postId)->orderBy('amount', 'DESC')->distinct('user_id')->count();
        //dd($product);

        return view('SuperAdmin.Auction.details', compact(['product', 'bidders', "totalBidders"]));
    }
    public function auctionEdit($id)
    {

        $product = Auction::find($id);

        return view('SuperAdmin.Auction.edit', compact('product'));
    }
    public function auctionUpdate(Request $request, $id)
    {

        $request->validate([

            'title' => 'required',
            'details' => 'required',


        ], [
            'title.required' => 'Title Field Is Required',
            'details.required' => 'Description Field Is Required',

        ]);
        $product = Auction::findOrFail($id);

        if ($request->hasfile('product_image')) {

            $destination = $product->product_image;
            if (File::exists($destination)) {
                File::delete($destination);
            }

            $file = $request->file('product_image');
            $extension = $file->getClientOriginalExtension();
            $filename = 'uploads/images/auction/' . time() . '.' . $extension;

            Image::make($file)->resize(900, 400)->save($filename, 50);
            $product->product_image = $filename;
        }

        $product->title = $request->input('title');
        $product->details = $request->input('details');

        try {

            $product->update();

            return response()->json([
                'success' => true,
                'message' => 'Description Updated Successfully'
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'type' => 'error',
                'message' => 'Opps somthing went wrong. ' . $exception->getMessage(),
            ]);
        }
    }
    public function auctionDestroy($id)
    {
        $post = Post::where('event_id', $id)->first();
        $postDelete = Auction::findOrfail($id);
        try {
            $post->delete();
            $postDelete->delete();
            return response()->json([
                'type' => 'success',
                'message' => 'Successfully Deleted !!',
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'type' => 'error',
                'message' => 'error' . $exception->getMessage(),
            ]);
        }
    }
}
