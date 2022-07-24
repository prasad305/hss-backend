<?php

namespace App\Http\Controllers\ManagerAdmin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\QnA;
use App\Models\QnaRegistration;
use App\Models\SuperStar;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManagerStatic as Image;

class QnaController extends Controller
{
    public function show($id)
    {
        $event = QnA::find($id);
        return view('ManagerAdmin.QnA.details', compact('event'));
    }


    public function pending()
    {
        $upcommingEvent = QnA::where([
            ['star_approval', 1], ['status', 0]
        ])->latest()->get();

        return view('ManagerAdmin.QnA.index', compact('upcommingEvent'));
    }

    public function published()
    {
        $upcommingEvent = QnA::where([
            ['status', 2]
        ])->latest()->latest()->get();

        return view('ManagerAdmin.QnA.index', compact('upcommingEvent'));
    }

    public function all()
    {
        $upcommingEvent = QnA::where('category_id',auth()->user()->category_id)->where([['star_approval',1],['status','<',10]])->latest()->get();

        return view('ManagerAdmin.QnA.index', compact('upcommingEvent'));
    }

    public function manager_event_details($id)
    {
        $event = QnA::find($id);

        $allRegistered = collect(QnaRegistration::with('user')->where('qna_id',$id)->orderBy('id','DESC')->get());
        $registered = $allRegistered->unique('user_id');

        $totalRegistered = QnaRegistration::where('qna_id',$id)->orderBy('id','DESC')->distinct('user_id')->count();

        return view('ManagerAdmin.QnA.details', compact(['event','totalRegistered','registered']));
    }


    public function manager_event_set_publish(Request $request, $id)
    {
        $event = QnA::find($id);

        if ($event->status != 2) {
            $request->validate([
                'post_start_date' => 'required',
                'post_end_date' => 'required',
            ]);

            $event->status = 2;
            $event->update();
            $starCat = SuperStar::where('star_id', $event->star_id)->first();

            // Create New post //
            $post = new Post();
            $post->type = 'qna';
            $post->user_id = $event->star_id;
            $post->star_id = json_decode($event->star_id);
            $post->event_id = $event->id;
            $post->category_id = $starCat->category_id;
            $post->sub_category_id = $starCat->sub_category_id;
            $post->post_start_date = Carbon::parse($request->post_start_date);
            $post->post_end_date = Carbon::parse($request->post_end_date);
            $post->save();

        } else {
            $event->status = 10;
            $event->update();
            // Remove post //
            $post = Post::where('event_id', $id)->first();
            $post->delete();
        }

        return redirect()->back()->with('success', 'Published');
    }

    public function edit($id)
    {
        $event = QnA::find($id);

        return view('ManagerAdmin.QnA.edit', compact('event'));
    }

    public function update(Request $request, $id)
    {


        $request->validate([

            'title' => 'required',
            'description' => 'required',
            'instruction' => 'required',


        ],[
            'title.required' => 'Title Field Is Required',
            'description.required' => 'Description Field Is Required',
            'instruction.required' => 'Instruction Field Is Required',

        ]);

        $qnA = QnA::findOrFail($id);
        $qnA->fill($request->except('_token'));

        $qnA->title = $request->input('title');
        $qnA->description = $request->input('description');
        $qnA->instruction = $request->input('instruction');

        // $qnA->date = $request->input('date');
        // $qnA->start_time = Carbon::parse($request->input('start_time'));
        // $qnA->end_time = Carbon::parse($request->input('end_time'));

        $qnA->fee = $request->input('fee');
        // $qnA->total_seat = $request->input('slots');

        if ($request->hasfile('banner')) {
            $destination = $qnA->banner;
            if (File::exists($destination)) {
                File::delete($destination);
            }
            $file = $request->file('banner');
            $extension = $file->getClientOriginalExtension();
            $filename = 'uploads/images/qna/' . time() . '.' . $extension;

            Image::make($file)->resize(900, 400)->save($filename, 100);
            $qnA->banner = $filename;
        }
        if ($request->hasfile('video')) {

            $destination = $qnA->video;
            if (File::exists($destination)) {
                File::delete($destination);
            }
            if ($request->hasFile('video')) {

                $file        = $request->file('video');
                $path        = 'uploads/videos/qna';
                $file_name   = time() . rand('0000', '9999') . '.' . $file->getClientOriginalName();
                $file->move($path, $file_name);
                $qnA->video = $path . '/' . $file_name;
            }


        }

        try {
            $qnA->update();
            if ($qnA) {
                return response()->json([
                    'success' => true,
                    'message' => 'QnA Event Updated Successfully'
                ]);
            }
        } catch (\Exception $exception) {
            return response()->json([
                'type' => 'error',
                'message' => 'Opps somthing went wrong. ' . $exception->getMessage(),
            ]);
        }
    }
}
