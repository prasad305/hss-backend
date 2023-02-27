<?php

namespace App\Http\Controllers\ManagerAdmin;

use App\Http\Controllers\Controller;
use App\Models\Auction;
use App\Models\Bidding;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManagerStatic as Image;

class AuctionController extends Controller
{
    public function all()
    {
        $product = Auction::orderBy('id','DESC')->where('star_approval',1)->where('category_id',auth()->user()->category_id)->latest()->get();

        return view('ManagerAdmin.Auction.index', compact('product'));
    }

    public function pending()
    {
        $product = Auction::orderBy('id','DESC')->where([['status', 0], ['star_approval', 1]])->where('category_id',auth()->user()->category_id)->latest()->get();

        return view('ManagerAdmin.Auction.index', compact('product'));
    }

    public function published()
    {
        $product = Auction::orderBy('id','DESC')->where('status', 1)->where('category_id',auth()->user()->category_id)->latest()->get();

        return view('ManagerAdmin.Auction.index', compact('product'));
    }

    public function details($id)
    {
        $product = Auction::with('star')->find($id);
        $allbidders = collect(Bidding::with('user')->where('auction_id',$id)->orderBy('amount','DESC')->get());
        $bidders = $allbidders->unique('user_id');
        $totalBidders = Bidding::with('user')->where('auction_id',$id)->orderBy('amount','DESC')->distinct('user_id')->count();
        //dd($product);

        return view('ManagerAdmin.Auction.details', compact(['product','bidders',"totalBidders"]));
    }


    public function edit($id)
    {
        $product = Auction::find($id);

        return view('ManagerAdmin.Auction.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {


            $request->validate([
    
                    'title' => 'required',
                    'details' => 'required',
                ],[
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
        

        // $product = Auction::findOrFail($id);
        // $product->fill($request->except('_token'));

        // $product->title = $request->input('title');
        // $product->details = $request->input('details');

        // if ($request->hasfile('product_image')) {

        //     // $destination = $meetup->image;
        //     // if (File::exists($destination)) {
        //     //     File::delete($destination);
        //     // }

        //     $file = $request->file('product_image');
        //     $extension = $file->getClientOriginalExtension();
        //     $filename = 'uploads/images/auction/' . time() . '.' . $extension;

        //     Image::make($file)->resize(900, 400)->save($filename, 50);
        //     $product->product_image = $filename;
        // }


        // try {
        //     $product->update();
        //     if ($product) {
        //         return response()->json([
        //             'success' => true,
        //             'message' => 'Updated Successfully'
        //         ]);
        //     }
        // } catch (\Exception $exception) {
        //     return response()->json([
        //         'type' => 'error',
        //         'message' => 'Opps somthing went wrong. ' . $exception->getMessage(),
        //     ]);
        // }
    }

    public function set_publish($id)
    {
        $product = Auction::find($id);
        if($product->status != 0 ){

            $product->status = 0;
            $product->update();
        }else{
            $product->status = 1;
           $approveManager = $product->update();

           if($approveManager){
            $userInfo = getUserInfo();
            $senderInfo = getManagerInfo(auth()->user()->id);
            foreach ($userInfo as $key => $data) {
                SendMail($data->email,$product,$senderInfo);
            }
           }
        }

        return redirect()->back()->with('success', 'Published');
    }
}
