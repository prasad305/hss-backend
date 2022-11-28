<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Models\FAQ;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FAQController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $data = FAQ::where('status', 1)->orderBy('id', 'DESC')->get();
        return view('SuperAdmin.FAQ.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'faq' => FAQ::orderBy('id', 'desc')->where('status', 1)->get(),
        ];
        return view('SuperAdmin.FAQ.create', $data);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'details' => 'required',
          
        ]);
            $faq = new FAQ();
            $faq->title = $request->input('title');
            $faq->details = $request->input('details');
            $faq->status = 1;

        try {
            $faq->save();
                return response()->json([
                    'success' => true,
                    'message' => 'FAQ Add Successfully'
                ]);
            
        } catch (\Exception $exception) {
            return response()->json([
                'type' => 'error',
                'message' => 'Opps somthing went wrong. ' . $exception->getMessage(),
            ]);
        }
    }

    public function edit($id)
    {
        $data = FAQ::findOrfail($id);
      
        return view('SuperAdmin.FAQ.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'details' => 'required',
          
        ]);

            $faq = FAQ::findOrFail($id);
            $faq->title = $request->input('title');
            $faq->details = $request->input('details');
            $faq->status = $request->input('status');

        try {
            $faq->save();
            return response()->json([
                'success' => 'success',
                'message' => 'FAQ Updated Successfully'
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'type' => 'error',
                'message' => 'Opps somthing went wrong. ' . $exception->getMessage(),
            ]);
        }
    }

    public function destroy($id)
    {
        $faq = FAQ::findOrfail($id);
        try {
            $faq->delete();
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
