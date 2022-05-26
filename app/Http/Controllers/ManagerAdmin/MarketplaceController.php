<?php

namespace App\Http\Controllers\ManagerAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Marketplace;
use App\Models\Order;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManagerStatic as Image;
use Carbon\Carbon;

class MarketplaceController extends Controller
{
    public function all()
    {
        // $date = (int) Carbon::now()->format('dmYHis');
        // $rand = rand(100,999).$date;

        $post = Marketplace::latest()->where('post_status', 1)->where('category_id',auth()->user()->category_id)->get();

        return view('ManagerAdmin.marketplace.index', compact('post'));
    }

    public function allOrderList(){
        $orders = Order::latest()
                       ->get();

        return view('ManagerAdmin.marketplace.order', compact('orders'));
    }
    public function allOrderDetails($id){
        $order = Order::find($id);
        // dd($order);

        return view('ManagerAdmin.marketplace.order-view', compact('order'));
    }

    public function pending()
    {
        $post = Marketplace::where([['status',0],['post_status',1]])->where('category_id',auth()->user()->category_id)->latest()->get();

        return view('ManagerAdmin.marketplace.index', compact('post'));
    }

    public function published()
    {
        $post = Marketplace::where('status',1)->where('category_id',auth()->user()->category_id)->latest()->get();

        return view('ManagerAdmin.marketplace.index', compact('post'));
    }

    public function details($id)
    {
        $post = Marketplace::find($id);

        return view('ManagerAdmin.marketplace.details', compact('post'));
    }


    public function edit($id)
    {
        $event = Marketplace::find($id);

        return view('ManagerAdmin.marketplace.edit', compact('event'));
    }

    public function update(Request $request, $id)
    {
        $marketplace = Marketplace::findOrFail($id);
        $marketplace->fill($request->except('_token'));

        $marketplace->title = $request->input('title');
        $marketplace->description = $request->input('description');
        $marketplace->keywords = $request->input('keywords');
        $marketplace->total_items = $request->input('total_items');
        $marketplace->unit_price = $request->input('unit_price');


        if ($request->hasfile('image')) {

            // $destination = $marketplace->image;
            // if (File::exists($destination)) {
            //     File::delete($destination);
            // }

            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = 'uploads/images/marketplace/' . time() . '.' . $extension;

            Image::make($file)->resize(400, 400)->save($filename, 50);
            $marketplace->image = $filename;


        }


            try {
                $marketplace->update();
                if($marketplace){
                    return response()->json([
                        'success' => true,
                        'message' => 'Marketplace Updated Successfully'
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
        $spost = Marketplace::find($id);

        if($spost->status != 1)
        {
            $spost->status = 1;
            $spost->update();
        }
        else
        {
            $spost->status = 0;
            $spost->update();
        }

        return redirect()->back()->with('success', 'Published');


    }
}
