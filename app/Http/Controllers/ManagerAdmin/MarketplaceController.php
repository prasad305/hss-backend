<?php

namespace App\Http\Controllers\ManagerAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Marketplace;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManagerStatic as Image;

class MarketplaceController extends Controller
{
    public function all()
    {
        $post = Marketplace::latest()->where('post_status', 1)->get();

        return view('ManagerAdmin.marketplace.index', compact('post'));
    }

    public function pending()
    {
        $post = Marketplace::where([['status',0],['post_status',1]])->latest()->get();

        return view('ManagerAdmin.marketplace.index', compact('post'));
    }

    public function published()
    {
        $post = Marketplace::where('status',1)->latest()->get();

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