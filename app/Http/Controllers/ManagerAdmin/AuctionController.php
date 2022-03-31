<?php

namespace App\Http\Controllers\ManagerAdmin;

use App\Http\Controllers\Controller;
use App\Models\Auction;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;

class AuctionController extends Controller
{
    public function all()
    {
        $product = Auction::where('star_approval',1)->latest()->get();

        return view('ManagerAdmin.Auction.index', compact('product'));
    }

    public function pending()
    {
        $product = Auction::where([['status', 0], ['star_approval', 1]])->latest()->get();

        return view('ManagerAdmin.Auction.index', compact('product'));
    }

    public function published()
    {
        $product = Auction::where('status', 1)->latest()->get();

        return view('ManagerAdmin.Auction.index', compact('product'));
    }

    public function details($id)
    {
        $product = Auction::with('star')->find($id);
        //dd($product);

        return view('ManagerAdmin.Auction.details', compact('product'));
    }


    public function edit($id)
    {
        $product = Auction::find($id);

        return view('ManagerAdmin.Auction.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
        $product = Auction::findOrFail($id);
        $product->fill($request->except('_token'));

        $product->name = $request->input('name');
        $product->details = $request->input('details');

        // $meetup->event_link= $request->input('event_link');
        // $meetup->meetup_type = $request->input('meetup_type');
        // $meetup->date = $request->input('date');
        // $meetup->start_time = $request->input('start_time');
        // $meetup->end_time = $request->input('end_time');
        // $meetup->venue = $request->input('venue');

        if ($request->hasfile('product_image')) {

            // $destination = $meetup->image;
            // if (File::exists($destination)) {
            //     File::delete($destination);
            // }

            $file = $request->file('product_image');
            $extension = $file->getClientOriginalExtension();
            $filename = 'uploads/images/auction/' . time() . '.' . $extension;

            Image::make($file)->resize(900, 400)->save($filename, 50);
            $product->product_image = $filename;
        }


        try {
            $product->update();
            if ($product) {
                return response()->json([
                    'success' => true,
                    'message' => 'Updated Successfully'
                ]);
            }
        } catch (\Exception $exception) {
            return response()->json([
                'type' => 'error',
                'message' => 'Opps somthing went wrong. ' . $exception->getMessage(),
            ]);
        }
    }

    public function set_publish($id)
    {
        $product = Auction::find($id);
        if($product->status != 0 ){

            $product->status = 0;
            $product->update();
        }else{
            $product->status = 1;
            $product->update();
        }

        return redirect()->back()->with('success', 'Published');
    }
}
