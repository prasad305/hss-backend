<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\QnA;
use App\Models\QnaRegistration;
use App\Models\SuperStar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManagerStatic as Image;

class QnaController extends Controller
{
    public function add_qna(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'star_id' => 'required',
            'title' => 'required|unique:live_chats,title',
            'image' => 'required',
            'instruction' => 'required|min:5',
            'description' => 'required|min:5',
            'event_date' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'registration_start_date' => 'required',
            'registration_end_date' => 'required',
            'fee' => 'required',
            // 'question_quantity' => 'required',
            'min_time' => 'required|min:1',
            'max_time' => 'required|min:1',
            'time_interval' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'validation_errors' => $validator->errors(),
            ]);
        } else {
            $superStar = SuperStar::where('star_id', $request->input('star_id'))->first();

            $qna = new QnA();
            $qna->title = $request->input('title');
            $qna->slug = Str::slug($request->input('title'));
            $qna->star_id = $request->input('star_id');
            $qna->category_id = $superStar->category_id;
            $qna->sub_category_id = $superStar->sub_category_id;
            $qna->admin_id = auth('sanctum')->user()->id;
            $qna->created_by_id = auth('sanctum')->user()->id;
            $qna->description = $request->input('description');
            $qna->instruction = $request->input('instruction');
            $qna->event_date = $request->input('event_date');
            $qna->start_time = Carbon::parse($request->input('start_time'));
            $qna->end_time = Carbon::parse($request->input('end_time'));
            $qna->registration_start_date = $request->input('registration_start_date');
            $qna->registration_end_date = $request->input('registration_end_date');
            $qna->fee = $request->input('fee');
            // $qna->question_quantity = $request->input('question_quantity');
            $qna->min_time = $request->input('min_time');
            $qna->max_time = $request->input('max_time');
            $qna->time_interval = $request->input('time_interval');

            if ($request->hasfile('image')) {
                $destination = $qna->banner;
                if (File::exists($destination)) {
                    File::delete($destination);
                }
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension();
                $filename = 'uploads/images/qna/' . time() . '.' . $extension;

                Image::make($file)->resize(900, 400)->save($filename, 100);
                $qna->banner = $filename;
            }

            if ($request->hasFile('video')) {
                $destination = $qna->video;
                if (File::exists($destination)) {
                    File::delete($destination);
                }

                $file        = $request->file('video');
                $path        = 'uploads/videos/qna';
                $file_name   = time() . rand('0000', '9999') . '.' . $file->getClientOriginalName();
                $file->move($path, $file_name);
                $qna->video = $path . '/' . $file_name;
            }

            $qna->save();


            return response()->json([
                'status' => 200,
                'message' => 'QnA Successfully Added ',
            ]);
        }
    }
    public function admin_update_Qna(Request $request)
    {
        // return $request->all();
        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:live_chats,title',
            'event_date' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'instruction' => 'required|min:5',
            'description' => 'required|min:5',
            'registration_start_date' => 'required',
            'registration_end_date' => 'required',
            'fee' => 'required',
            // 'question_quantity' => 'required',
            'min_time' => 'required|min:1',
            'max_time' => 'required|min:1',
            'time_interval' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'validation_errors' => $validator->errors(),
            ]);
        } else {

            $superStar = SuperStar::where('star_id', $request->input('star_id'))->first();

            $qna = QnA::where('slug',$request->slug)->first();
            $qna->title = $request->input('title');
            $qna->slug = Str::slug($request->input('title'));
            $qna->star_id = $request->star_id;
            $qna->category_id =  $superStar->category_id;
            $qna->sub_category_id =  $superStar->sub_category_id;
            $qna->admin_id = auth('sanctum')->user()->id;
            $qna->created_by_id = auth('sanctum')->user()->id;
            $qna->description = $request->input('description');
            $qna->instruction = $request->input('instruction');
            $qna->event_date = $request->input('event_date');
            $qna->start_time = Carbon::parse($request->input('start_time'));
            $qna->end_time = Carbon::parse($request->input('end_time'));
            $qna->registration_start_date = $request->input('registration_start_date');
            $qna->registration_end_date = $request->input('registration_end_date');
            $qna->fee = $request->input('fee');
            // $qna->question_quantity = $request->input('question_quantity');
            $qna->min_time = $request->input('min_time');
            $qna->max_time = $request->input('max_time');
            $qna->time_interval = $request->input('time_interval');

            if ($request->hasfile('image')) {
                $destination = $qna->banner;
                if (File::exists($destination)) {
                    File::delete($destination);
                }
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension();
                $filename = 'uploads/images/qna/' . time() . '.' . $extension;

                Image::make($file)->resize(900, 400)->save($filename, 100);
                $qna->banner = $filename;
            }
            if ($request->hasFile('video')) {
                $destination = $qna->video;
                if (File::exists($destination)) {
                    File::delete($destination);
                }

                $file        = $request->file('video');
                $path        = 'uploads/videos/qna';
                $file_name   = time() . rand('0000', '9999') . '.' . $file->getClientOriginalName();
                $file->move($path, $file_name);
                $qna->video = $path . '/' . $file_name;
            }

            $qna->update();

            // return $request->input('description');
            return response()->json([
                'status' => 200,
                'message' => 'QnA Updated !',
            ]);
        }
    }
    public function pendingQna()
    {
        $events = QnA::where([['admin_id', auth('sanctum')->user()->id], ['status', '<', 2]]);

        return response()->json([
            'status' => 200,
            'events' => $events->latest()->get(),
            'count' => $events->count(),
        ]);
    }
    public function count()
    {
        $approved = QnA::where([['admin_id', auth('sanctum')->user()->id], ['status', 2]])->count();
        $pending = QnA::where([['admin_id', auth('sanctum')->user()->id], ['status', '<', 2]])->count();

        return response()->json([
            'status' => 200,
            'approved' => $approved,
            'pending' => $pending,
        ]);
    }
    public function details($slug)
    {
        $event = QnA::where('slug', $slug)->first();
        return response()->json([
            'status' => 200,
            'message' => 'Ok',
            'event' => $event,
        ]);
    }
    public function liveQnalist()
    {
        $events = QnA::where([['admin_id', auth('sanctum')->user()->id], ['status', 2]]);

        return response()->json([
            'status' => 200,
            'events' => $events->latest()->get(),
            'count' => $events->count(),
        ]);
    }
    public function qna_completed()
    {
        $events = QnA::where([['admin_id', auth('sanctum')->user()->id], ['status', 9]]);

        return response()->json([
            'status' => 200,
            'events' => $events->latest()->get(),
            'count' => $events->count(),
        ]);
    }
    public function qna_rejected()
    {
        $events = QnA::where([['admin_id', auth('sanctum')->user()->id], ['star_approval', 2]]);

        return response()->json([
            'status' => 200,
            'events' => $events->latest()->get(),
            'count' => $events->count(),
        ]);
    }
    public function registeredList($slug)
    {
        $event = QnA::where('slug', $slug)->first();
        $users = QnaRegistration::where('qna_id', $event->id)->get();

        return response()->json([
            'status' => 200,
            'message' => 'Ok',
            'users' => $users,
        ]);
    }


    // Star Section

    public function star_add_qna(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:live_chats,title',
            'image' => 'required',
            'event_date' => 'required',
            'instruction' => 'required|min:5',
            'description' => 'required|min:5',
            'start_time' => 'required',
            'end_time' => 'required',
            'registration_start_date' => 'required',
            'registration_end_date' => 'required',
            'fee' => 'required',
            // 'question_quantity' => 'required',
            'min_time' => 'required|min:1',
            'max_time' => 'required|min:1',
            'time_interval' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'validation_errors' => $validator->errors(),
            ]);
        } else {
            // $superStar = SuperStar::where('star_id', $request->input('star_id'))->first();

            $qna = new QnA();
            $qna->title = $request->input('title');
            $qna->slug = Str::slug($request->input('title'));
            $qna->star_id = auth('sanctum')->user()->id;
            $qna->category_id =  auth()->user()->category_id;
            $qna->sub_category_id =  auth()->user()->sub_category_id;
            $qna->admin_id = auth()->user()->parent_user;
            $qna->created_by_id = auth('sanctum')->user()->id;
            $qna->description = $request->input('description');
            $qna->instruction = $request->input('instruction');
            $qna->event_date = $request->input('event_date');
            $qna->start_time = Carbon::parse($request->input('start_time'));
            $qna->end_time = Carbon::parse($request->input('end_time'));
            $qna->registration_start_date = $request->input('registration_start_date');
            $qna->registration_end_date = $request->input('registration_end_date');
            $qna->fee = $request->input('fee');
            $qna->star_approval = 1;
            // $qna->question_quantity = $request->input('question_quantity');
            $qna->min_time = $request->input('min_time');
            $qna->max_time = $request->input('max_time');
            $qna->time_interval = $request->input('time_interval');

            if ($request->hasfile('image')) {
                $destination = $qna->banner;
                if (File::exists($destination)) {
                    File::delete($destination);
                }
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension();
                $filename = 'uploads/images/qna/' . time() . '.' . $extension;

                Image::make($file)->resize(900, 400)->save($filename, 100);
                $qna->banner = $filename;
            }
            if ($request->hasFile('video')) {
                $destination = $qna->video;
                if (File::exists($destination)) {
                    File::delete($destination);
                }

                $file        = $request->file('video');
                $path        = 'uploads/videos/qna';
                $file_name   = time() . rand('0000', '9999') . '.' . $file->getClientOriginalName();
                $file->move($path, $file_name);
                $qna->video = $path . '/' . $file_name;
            }

            $qna->save();


            return response()->json([
                'status' => 200,
                'message' => 'QnA Successfully Added ',
            ]);
        }
    }
    public function update_Qna(Request $request)
    {
        // return $request->all();
        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:live_chats,title',
            'event_date' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'instruction' => 'required|min:5',
            'description' => 'required|min:5',
            'registration_start_date' => 'required',
            'registration_end_date' => 'required',
            'fee' => 'required',
            // 'question_quantity' => 'required',
            'min_time' => 'required|min:1',
            'max_time' => 'required|min:1',
            'time_interval' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'validation_errors' => $validator->errors(),
            ]);
        } else {

            $qna = QnA::find($request->id);
            $qna->title = $request->input('title');
            $qna->slug = Str::slug($request->input('title'));
            $qna->admin_id = auth()->user()->parent_user;
            $qna->description = $request->input('description');
            $qna->instruction = $request->input('instruction');
            $qna->event_date = $request->input('event_date');
            $qna->start_time = Carbon::parse($request->input('start_time'));
            $qna->end_time = Carbon::parse($request->input('end_time'));
            $qna->registration_start_date = $request->input('registration_start_date');
            $qna->registration_end_date = $request->input('registration_end_date');
            $qna->fee = $request->input('fee');
            // $qna->question_quantity = $request->input('question_quantity');
            $qna->min_time = $request->input('min_time');
            $qna->max_time = $request->input('max_time');
            $qna->time_interval = $request->input('time_interval');

            if ($request->hasfile('image')) {
                $destination = $qna->banner;
                if (File::exists($destination)) {
                    File::delete($destination);
                }
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension();
                $filename = 'uploads/images/qna/' . time() . '.' . $extension;

                Image::make($file)->resize(900, 400)->save($filename, 100);
                $qna->banner = $filename;
            }
            if ($request->hasFile('video')) {
                $destination = $qna->video;
                if (File::exists($destination)) {
                    File::delete($destination);
                }

                $file        = $request->file('video');
                $path        = 'uploads/videos/qna';
                $file_name   = time() . rand('0000', '9999') . '.' . $file->getClientOriginalName();
                $file->move($path, $file_name);
                $qna->video = $path . '/' . $file_name;
            }

            $qna->update();

            // return $request->input('description');
            return response()->json([
                'status' => 200,
                'message' => 'QnA Updated !',
            ]);
        }
    }

    public function star_pendingQna()
    {
        $events = QnA::where([['star_id', auth('sanctum')->user()->id], ['star_approval', 0]]);

        return response()->json([
            'status' => 200,
            'events' => $events->latest()->get(),
            'count' => $events->count(),
        ]);
    }
    public function star_count()
    {
        $approved = QnA::where([['star_id', auth('sanctum')->user()->id], ['star_approval', 1]])->count();
        $pending = QnA::where([['star_id', auth('sanctum')->user()->id], ['star_approval', 0]])->count();

        return response()->json([
            'status' => 200,
            'approved' => $approved,
            'pending' => $pending,
        ]);
    }
    public function qna_details($slug)
    {
        $event = QnA::where('slug', $slug)->first();
        return response()->json([
            'status' => 200,
            'message' => 'Ok',
            'event' => $event,
        ]);
    }
    public function star_liveQnalist()
    {
        $events = QnA::where([['star_id', auth('sanctum')->user()->id], ['star_approval', 1]]);

        return response()->json([
            'status' => 200,
            'events' => $events->latest()->get(),
            'count' => $events->count(),
        ]);
    }
    public function star_qna_completed()
    {
        $events = QnA::where([['star_id', auth('sanctum')->user()->id], ['status', 9]]);

        return response()->json([
            'status' => 200,
            'events' => $events->latest()->get(),
            'count' => $events->count(),
        ]);
    }
    public function setApprovedQna($id)
    {
        $approvedQna = QnA::find($id);
        $approvedQna->star_approval = 1;
        $approvedQna->update();

        return response()->json([
            'status' => 200,
            'message' => 'Event Approved',
        ]);
    }
    public function setRejectedQna($id)
    {
        $rejectedQna = QnA::find($id);
        $rejectedQna->star_approval = 2;
        $rejectedQna->update();

        return response()->json([
            'status' => 200,
            'message' => 'Event Rejected',
        ]);
    }
    public function QnaRegisteredList($slug)
    {
        $event = QnA::where('slug', $slug)->first();
        $users = QnaRegistration::where('qna_id', $event->id)->get();

        return response()->json([
            'status' => 200,
            'message' => 'Ok',
            'users' => $users,
        ]);
    }
}
