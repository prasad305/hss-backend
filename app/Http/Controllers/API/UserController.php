<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Acquired_app;
use App\Models\Activity;
use App\Models\Auction;
use App\Models\AuctionTerms;
use App\Models\Audition\Audition;
use App\Models\Audition\AuditionParticipant;
use App\Models\Audition\AuditionRoundAppealRegistration;
use App\Models\Audition\AuditionRoundInfo;
use App\Models\Audition\AuditionRoundMarkTracking;
use App\Models\Audition\AuditionUploadVideo;
use App\Models\AuditionOxygenReplyVideo;
use App\Models\AuditionOxygenVideo;
use App\Models\AuditionRoundInstruction;
use App\Models\Bidding;
use App\Models\FanGroupMessage;
use App\Models\Greeting;
use App\Models\GreetingsRegistration;
use App\Models\LearningSession;
use App\Models\SubCategory;
use App\Models\UserEmployment;
use App\Models\LearningSessionRegistration;
use App\Models\LiveChat;
use App\Models\LiveChatRegistration;
use App\Models\MeetupEvent;
use App\Models\MeetupEventRegistration;
use App\Models\Notification;
use App\Models\Post;
use App\Models\FanPost;
use App\Models\React;
use App\Models\SimplePost;
use App\Models\ChoiceList;
use App\Models\GeneralPostPayment;
use App\Models\GreetingType;
use App\Models\InterestType;
use App\Models\LearningSessionAssignment;
use App\Models\LearningSessionCertificate;
use App\Models\LearningSessionEvaluation;
use App\Models\LiveChatRoom;
use App\Models\Message;
use App\Models\PromoVideo;
use App\Models\QnA;
use App\Models\QnaRegistration;
use App\Models\User;
use App\Models\UserInterest;
use App\Models\UserEducation;
use App\Models\Audition\AuditionAssignJudge;
use App\Models\SuperStar;
use App\Models\AuditionCertification;
use App\Models\AuditionCertificationContent;
use App\Models\Fan_Group_Join;
use Carbon\Carbon;
use DateTime;
use DateTimeZone;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Str;
use App\Models\SouvenirCreate;
use App\Models\FanGroup;
use App\Models\LoveReact;
use App\Models\LoveReactPayment;
use App\Models\UserInfo;
use App\Models\Marketplace;
use App\Models\Payment;
use App\Models\Wallet;
use PhpParser\Node\Stmt\TryCatch;
use App\Models\WildCard;
use Illuminate\Support\Arr;
use PDF;

class UserController extends Controller
{
    public function star_info($id)
    {
        $star = User::find($id);


        return response()->json([
            'status' => 200,
            'message' => 'Ok',
            'star' => $star,
        ]);
    }


    public function star_list()
    {
        $stars = User::where('user_type', 'star')->get();

        return response()->json([
            'status' => 200,
            'stars' => $stars,
        ]);
    }

    public function allSearchData($query)
    {
        // return gettype($query);

        $superstar = User::where('user_type', 'star')->latest()->get();

        $posts = Post::latest()->get();

        $marketplace = Marketplace::where('status', 1)->latest()->get();

        $auction = Auction::with('star')->where('status', 1)->latest()->get();

        $souvenir = SouvenirCreate::with('star')->where('status', 1)->latest()->get();

        $fangroup = FanGroup::where('status', 1)->latest()->get();

        // return $posts;


        // $superstar = User::where('user_type', 'star')->where('first_name', 'LIKE', "%$query%")
        //                          ->orWhere('last_name', 'LIKE', "%$query%")
        //                          ->latest()->get();

        // $posts = Post::where('title', 'LIKE', "%$query%")
        //                     ->orWhere('details', 'LIKE', "%$query%")
        //                     ->latest()->get();

        // $marketplace = Marketplace::where('description', 'LIKE', "%$query%")
        //                     ->orWhere('terms_conditions', 'LIKE', "%$query%")
        //                     ->orWhere('title', 'LIKE', "%$query%")
        //                     ->orWhere('keywords', 'LIKE', "%$query%")
        //                     ->latest()->get();

        // $auction = Auction::with('star')->where('details', 'LIKE', "%$query%")
        //                     ->orWhere('title', 'LIKE', "%$query%")
        //                     ->orWhere('keyword', 'LIKE', "%$query%")
        //                     ->latest()->get();

        // $souvenir = SouvenirCreate::with('star')->where('description', 'LIKE', "%$query%")
        //                     ->orWhere('title', 'LIKE', "%$query%")
        //                     ->orWhere('instruction', 'LIKE', "%$query%")
        //                     ->latest()->get();

        // $fangroup = FanGroup::where('group_name', 'LIKE', "%$query%")
        //                     ->orWhere('description', 'LIKE', "%$query%")
        //                     ->latest()->get();

        return response()->json([
            'status' => 200,
            'superstar' => $superstar,
            'posts' => $posts,
            'marketplace' => $marketplace,
            'auction' => $auction,
            'souvenir' => $souvenir,
            'fangroup' => $fangroup,
            'message' => 'Success',
        ]);
    }

    public function postShare($postId)
    {
        $post = Post::find($postId);
        $post->share_count += 1;
        $post->update();
        return response()->json([
            'status' => 200,
            'post' => $post,
            'message' => 'Success',
        ]);
    }
    public function postShareStore($postId)
    {
        $post = Post::find($postId);
        $post->share_count += 1;
        $post->save();

        return response()->json([
            'status' => 200,
            'message' => 'Success',
        ]);
    }

    public function fanPostShare($postId)
    {
        $post = FanPost::find($postId);
        return response()->json([
            'status' => 200,
            'post' => $post,
            'message' => 'Success',
        ]);
    }
    public function fanPostShareStore($postId)
    {
        $post = FanPost::find($postId);
        $post->share_count += 1;
        $post->save();

        return response()->json([
            'status' => 200,
            'message' => 'Success',
        ]);
    }

    public function total_notification_count()
    {
        $notification = Notification::where([['user_id', auth('sanctum')->user()->id], ['view_status', 0]])->count();

        return response()->json([
            'status' => 200,
            'totalNotification' => $notification,
        ]);
    }

    public function notification_view_status_update($id)
    {
        $notification = Notification::find($id);
        $notification->view_status = 1;
        $notification->update();

        $total_notification = Notification::where([['user_id', auth('sanctum')->user()->id], ['view_status', 0]])->count();

        return response()->json([
            'status' => 200,
            'totalNotification' => $total_notification,
        ]);
    }


    public function all_post()
    {
        $id = auth('sanctum')->user()->id;
        $selectedCategory = ChoiceList::where('user_id', $id)->first();

        $selectedCat = json_decode($selectedCategory->category);
        $selectedSubCat = json_decode($selectedCategory->subcategory);
        $selectedSubSubCat = json_decode($selectedCategory->star_id);

        $cat_post = Post::select("*")
            ->whereIn('category_id', $selectedCat)
            ->latest()->get();

        if (isset($sub_cat_post)) {
            $sub_cat_post = Post::select("*")
                ->whereIn('sub_category_id', $selectedSubCat)
                ->latest()->get();
        } else {
            $sub_cat_post = [];
        }

        if (isset($sub_sub_cat_post)) {
            $sub_sub_cat_post = Post::select("*")
                ->whereIn('user_id', $selectedSubSubCat)
                ->latest()->get();
        } else {
            $sub_sub_cat_post = [];
        }

        $post = $cat_post->concat($sub_cat_post)->concat($sub_sub_cat_post);

        return response()->json([
            'status' => 200,
            'message' => 'Ok',
            'posts' => $post,
        ]);
    }


    /**
     * mobile media upload
     */

    public function MobileImageUpUser(Request $request)
    {
        //      return response()->json([
        //     "message" => "uload successfully",
        //     "status" => "200",
        //     "path" =>   $request->img['data']
        // ]);


        try {
            if ($request->img['data']) {

                $originalExtension = str_ireplace("image/", "", $request->img['type']);

                $folder_path       = 'uploads/';

                $image_new_name    = Str::random(20) . '-' . now()->timestamp . '.' . $originalExtension;
                $decodedBase64 = $request->img['data'];
            }


            Image::make($decodedBase64)->save($folder_path . $image_new_name);

            $filePath = $folder_path . $image_new_name;

            return response()->json([
                "message" => "Upload successfully",
                "status" => "200",
                "path" =>   $filePath
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                "message" => "Image field required, invalid image !",
                "error" => $exception->getMessage(),
                "path" => "",
            ]);
        }
    }


    /**
     * post with pagination
     */
    public function paginate_all_post($limit)
    {
        $id = auth('sanctum')->user()->id;
        $selectedCategory = ChoiceList::where('user_id', $id)->first();

        $selectedCat = json_decode($selectedCategory->category);
        $selectedSubCat = json_decode($selectedCategory->subcategory);
        $selectedSubSubCat = json_decode($selectedCategory->star_id);

        // $cat_post = Post::select("*")
        //     ->whereIn('category_id', $selectedCat)
        //     ->orderBy('id', 'DESC')->paginate($limit);


        // $cat_post = Post::where('type', 'fangroup')->orderBy('id', 'DESC')->paginate($limit);

        $PostArray = Post::select("*")
            ->whereIn('type', ['fangroup', 'audition'])
            ->orWhereIn('star_id', $selectedSubSubCat)
            ->orWhereIn('sub_category_id', $selectedSubCat)
            ->orderBy('id', 'DESC')->paginate($limit);

        // if (isset($selectedSubCat)) {
        //     $sub_cat_post = Post::select("*")
        //         ->whereIn('sub_category_id', $selectedSubCat)
        //         ->orderBy('id', 'DESC')->paginate($limit);
        // } else {
        //     $sub_cat_post = [];
        // }

        // if (isset($selectedSubSubCat)) {
        //     $sub_sub_cat_post = Post::select("*")
        //         ->whereIn('star_id', $selectedSubSubCat)
        //         ->orderBy('id', 'DESC')->paginate($limit);
        // } else {
        //     $sub_sub_cat_post = [];
        // }
        $dame = array();
        // $post = $cat_post->concat($sub_cat_post)->concat($sub_sub_cat_post);
        $post = $PostArray->concat($dame);

        return response()->json([
            'status' => 200,
            'message' => 'Ok',
            'posts' => $post,
        ]);
    }



    public function single_type_post($type)
    {
        $id = auth('sanctum')->user()->id;

        $selectedCategory = ChoiceList::where('user_id', $id)->first();
        $selectedCat = json_decode($selectedCategory->category);
        $selectedSubCat = json_decode($selectedCategory->subcategory);
        $selectedSubSubCat = json_decode($selectedCategory->star_id);

        $cat_post = Post::select("*")
            ->whereIn('category_id', $selectedCat)
            ->where('type', $type)
            ->latest()->get();

        if (isset($sub_cat_post)) {
            $sub_cat_post = Post::select("*")
                ->whereIn('sub_category_id', $selectedSubCat)
                ->latest()->get();
        } else {
            $sub_cat_post = [];
        }

        if (isset($sub_sub_cat_post)) {
            $sub_sub_cat_post = Post::select("*")
                ->whereIn('user_id', $selectedSubSubCat)
                ->latest()->get();
        } else {
            $sub_sub_cat_post = [];
        }

        $post = $cat_post->concat($sub_cat_post)->concat($sub_sub_cat_post);

        return response()->json([
            'status' => 200,
            'message' => 'Ok',
            'post' => $post,
        ]);
    }
    public function generalPostPayment(Request $request)
    {
        $postPayment = GeneralPostPayment::create([

            'post_id' => $request->post_id,
            'user_id' => auth('sanctum')->user()->id,
            'amount' => $request->amount,
            'status' => 1,
        ]);


        return response()->json([
            'status' => 200,
            'postPayment' => $postPayment,
            'message' => "Payment success"
        ]);
    }
    public function generalPostPaymentCheck($post_id)
    {

        $payment_status = GeneralPostPayment::where('user_id', auth('sanctum')->user()->id)->where('post_id', $post_id)->where('status', 1)->first();

        return response()->json([
            'status' => 200,
            'payment_status' => $payment_status,
        ]);
    }
    public function simplePostPaymentCheck()
    {

        $lockStatus = GeneralPostPayment::where('user_id', auth('sanctum')->user()->id)->where('status', 1)->pluck('post_id');

        return response()->json([
            'status' => 200,
            'lockStatus' => $lockStatus,
        ]);
    }

    public function paginate_single_type_post($type, $limit)
    {
        $id = auth('sanctum')->user()->id;

        $selectedCategory = ChoiceList::where('user_id', $id)->first();
        $selectedCat = json_decode($selectedCategory->category);
        $selectedSubCat = json_decode($selectedCategory->subcategory);
        $selectedSubSubCat = json_decode($selectedCategory->star_id);

        $cat_post = Post::select("*")
            ->whereIn('category_id', $selectedCat)
            ->where('type', $type)
            ->latest()->paginate($limit);

        if (isset($sub_cat_post)) {
            $sub_cat_post = Post::select("*")
                ->whereIn('sub_category_id', $selectedSubCat)
                ->latest()->paginate($limit);
        } else {
            $sub_cat_post = [];
        }

        if (isset($sub_sub_cat_post)) {
            $sub_sub_cat_post = Post::select("*")
                ->whereIn('user_id', $selectedSubSubCat)
                ->latest()->paginate($limit);
        } else {
            $sub_sub_cat_post = [];
        }

        $post = $cat_post->concat($sub_cat_post)->concat($sub_sub_cat_post);

        return response()->json([
            'status' => 200,
            'message' => 'Ok',
            'post' => $post,
        ]);
    }


    public function allSubcategoryList($catId)
    {

        $allSubCat = SubCategory::where('category_id', $catId)
            ->latest()
            ->get();

        // $someSubCat = SubCategory::where('category_id', $catId)
        //                     ->whereIn('id', subcategory)
        //                     ->latest()
        //                     ->get();
        // return $allSubCat;
        return response()->json([
            'status' => 200,
            'message' => 'Ok',
            'allSubCat' => $allSubCat,
            // 'someSubCat' => $someSubCat,
        ]);
    }



    public function getAllLearningSession()
    {

        $post = Post::where('type', 'learningSession')->latest()->get();


        return response()->json([
            'status' => 200,
            'message' => 'Ok sonet',
            'post' => $post,
        ]);
    }

    public function singleLearnigSession($slug)
    {
        $learnigSession = LearningSession::where([['slug', $slug]])->first();

        return response()->json([
            'status' => 200,
            'message' => 'Ok',
            'learnigSession' => $learnigSession,
        ]);
    }

    public function userSingleLearnigSession($slug)
    {
        $learnigSession = LearningSession::where([['slug', $slug]])->with(['learningSessionAssignment' => function ($query) {
            return $query->where('user_id', auth()->user()->id)->get();
        }])->first();

        $userLearningSession = LearningSessionRegistration::where([['learning_session_id', $learnigSession->id], ['user_id', auth()->user()->id]])->first();

        return response()->json([
            'status' => 200,
            'message' => 'Ok',
            'learnigSession' => $learnigSession,
            'userLearningSession' => $userLearningSession,
        ]);
    }

    public function learningSeesionResult($slug)
    {
        // return $slug;
        $learnigSession = LearningSession::where('slug', $slug)->first();

        $marked_videos = LearningSessionAssignment::where([['event_id', $learnigSession->id], ['user_id', auth()->user()->id], ['send_to_user', 1], ['mark', '>', 0]])->get();

        $rejected_videos = LearningSessionAssignment::where([['event_id', $learnigSession->id], ['user_id', auth()->user()->id], ['status', 2], ['send_to_user', 1]])->get();

        return response()->json([
            'status' => 200,
            'message' => 'Ok',
            'markedVideos' => $marked_videos,
            'rejectedVideos' => $rejected_videos,
        ]);
    }


    public function LearningSessionRegistration(Request $request)
    {
        // New Learning Session Registration
        $learnigSession = new LearningSessionRegistration();
        $learnigSession->learning_session_id = $request->input('post_id');
        $learnigSession->user_id = auth('sanctum')->user()->id;
        $learnigSession->save();

        // New Activity Add For Learning Session Registrartion
        $activity = new Activity();
        $activity->user_id = auth('sanctum')->user()->id;
        $activity->event_id = $request->input('post_id');
        $activity->event_registration_id =  $learnigSession->id;
        $activity->type = 'learningSession';
        $activity->save();

        return response()->json([
            'status' => 200,
            'message' => 'Registration Successful',
            'learnigSession' => $learnigSession,
        ]);
    }

    public function star_photo($id)
    {
        $post = SimplePost::where([['status', 1], ['star_id', $id]])->latest()->get();

        return response()->json([
            'status' => 200,
            'message' => 'Ok',
            'post' => $post,
        ]);
    }

    public function star_video($id)
    {
        $post = SimplePost::where([['status', 1], ['star_id', $id]])->latest()->get();

        return response()->json([
            'status' => 200,
            'message' => 'Ok',
            'post' => $post,
        ]);
    }


    public function getStarPost($id, $type)
    {
        $star_id = json_decode($id);
        $int_value = (int) $id;
        if ($type == 'livechat') {
            $post = Post::where([['user_id', $id], ['type', 'livechat']])->latest()->get();
        }
        if ($type == 'meetup') {
            $post = Post::where([['user_id', $id], ['type', 'meetup']])->latest()->get();
        }
        if ($type == 'learning') {
            $post = Post::where([['user_id', $id], ['type', 'learningSession']])->latest()->get();
        }
        if ($type == 'audition') {
            $post = Post::where('type', 'audition')->whereJsonContains('star_id', [$int_value])->latest()->get();
        }
        if ($type == 'all') {
            $post = Post::where('user_id', $id)->orWhereJsonContains('star_id', [$int_value])->latest()->get();
        }

        return response()->json([
            'status' => 200,
            'message' => 'Ok',
            'posts' => $post,
        ]);
    }

    public function paginate_getStarPost($id, $type, $limit)
    {
        // $star_ids = '['.$id.']';
        $star_id = json_decode($id);
        $int_value = (int) $id;

        if ($type == 'livechat') {
            $post = Post::select("*")->where([['user_id', $id], ['type', 'livechat']])->latest()->paginate($limit);
        }
        if ($type == 'meetup') {
            $post = Post::select("*")->where([['user_id', $id], ['type', 'meetup']])->latest()->paginate($limit);
        }
        if ($type == 'learning') {
            $post = Post::select("*")->where([['user_id', $id], ['type', 'learningSession']])->latest()->paginate($limit);
        }
        if ($type == 'all') {
            // $post = Post::select("*")->where('user_id', $id)->latest()->paginate($limit);
            $post = Post::where('type', '!=', null)->where('star_id', $star_id)->orWhereJsonContains('star_id', [$int_value])->latest()->get();
        }


        $demo = [];
        $starpost = $post->concat($demo);

        return response()->json([
            'status' => 200,
            'message' => 'Ok',
            'posts' => $starpost,
        ]);
    }


    public function interestType()
    {
        $interestTypes = InterestType::where('status', 1)->latest()->get();

        $userId = auth('sanctum')->user()->id;

        $interest_topic_id = UserInterest::where('user_id', $userId)->first();

        if ($interest_topic_id) {
            $interest_topic_id = json_decode($interest_topic_id->interest_topic_id);
        } else {
            $interest_topic_id = [];
        }
        return response()->json([
            'status' => 200,
            'message' => 'Ok',
            'allinteresttypes' => $interestTypes,
            'interest_topic_id' => $interest_topic_id,
        ]);
    }


    public function interestStore(Request $request)
    {
        $userId = auth('sanctum')->user()->id;
        // return gettype($userId);

        $interestTypes = UserInterest::where('user_id', $userId)->first();

        if ($interestTypes) {
            $interestTypes->interest_topic_id = $request->interest_topic_id;
            $interestTypes->save();

            return response()->json([
                'status' => 200,
                'message' => 'Interest Updated Successfully'
            ]);
        } else {
            $newInterest = new UserInterest();
            $newInterest->user_id = $userId;
            $newInterest->interest_topic_id = $request->interest_topic_id;
            $newInterest->save();

            return response()->json([
                'status' => 200,
                'message' => 'Interest Added Successfully'
            ]);
        }
    }

    public function userEducationCheck()
    {
        $userId = auth('sanctum')->user()->id;

        $educationList = UserEducation::where('user_id', $userId)->first();

        // return $educationList;

        return response()->json([
            'status' => 200,
            'message' => 'Ok',
            'educationList' => $educationList,
        ]);
    }

    public function educationalStore(Request $request)
    {
        // return $request->all();
        $userId = auth('sanctum')->user()->id;
        // return gettype($userId);

        $educationTypes = UserEducation::where('user_id', $userId)->first();

        if ($educationTypes) {

            $educationTypes->subject = $request->subject;
            $educationTypes->institute = $request->institute;
            $educationTypes->grade = $request->degree;
            $educationTypes->save();

            return response()->json([
                'status' => 200,
                'message' => 'Education Updated Successfully'
            ]);
        } else {
            $newEducation = new UserEducation();
            $newEducation->user_id = $userId;
            $newEducation->subject = $request->subject;
            $newEducation->institute = $request->institute;
            $newEducation->grade = $request->degree;
            $newEducation->save();

            return response()->json([
                'status' => 200,
                'message' => 'Education Added Successfully'
            ]);
        }
    }

    public function userEmploymentCheck()
    {
        $userId = auth('sanctum')->user()->id;

        $employmentList = UserEmployment::where('user_id', $userId)->first();

        // return $employmentList;

        return response()->json([
            'status' => 200,
            'message' => 'Ok',
            'employmentList' => $employmentList,
        ]);
    }


    public function employmentStore(Request $request)
    {
        // return $request->all();
        $userId = auth('sanctum')->user()->id;
        // return gettype($userId);

        $educationTypes = UserEmployment::where('user_id', $userId)->first();

        if ($educationTypes) {

            $educationTypes->occupation = $request->position;
            $educationTypes->company = $request->company;
            $educationTypes->salary = $request->salary;
            $educationTypes->save();

            return response()->json([
                'status' => 200,
                'message' => 'Employment Updated Successfully'
            ]);
        } else {
            $newEducation = new UserEmployment();
            $newEducation->user_id = $userId;
            $newEducation->occupation = $request->position;
            $newEducation->company = $request->company;
            $newEducation->salary = $request->salary;
            $newEducation->save();

            return response()->json([
                'status' => 200,
                'message' => 'Employment Added Successfully'
            ]);
        }
    }

    public function userPersonalList()
    {
        $userId = auth('sanctum')->user()->id;

        $employmentList = UserInfo::where('user_id', $userId)->first();
        $userList = User::find($userId);

        // return $employmentList;

        return response()->json([
            'status' => 200,
            'message' => 'Ok',
            'employmentList' => $employmentList,
            'userList' => $userList,
        ]);
    }

    public function personalDataStore(Request $request)
    {
        // return $request->all();
        $userId = auth('sanctum')->user()->id;

        $userInfoTypes = UserInfo::where('user_id', $userId)->first();
        $userList = User::find($userId);
        if ($userInfoTypes) {
            $userList->first_name = $request->first_name;
            $userList->last_name = $request->last_name;
            $userList->save();

            $userInfoTypes->country = $request->country;
            $userInfoTypes->dob = $request->birthday;
            $userInfoTypes->save();

            return response()->json([
                'status' => 200,
                'message' => 'UserInfo Updated Successfully'
            ]);
        } else {
            $userList->first_name = $request->first_name;
            $userList->last_name = $request->last_name;
            $userList->save();

            $newPersonalInfo = new UserInfo();
            $newPersonalInfo->user_id = $userId;
            $newPersonalInfo->country = $request->country;
            $newPersonalInfo->dob = $request->birthday;
            $newPersonalInfo->save();

            return response()->json([
                'status' => 200,
                'message' => 'UserInfo Added Successfully'
            ]);
        }
    }

    public function userPasswordChanges(Request $request)
    {
        // $hashedPassword = Auth::user()->password;
        $userId = auth('sanctum')->user()->id;
        $users = User::find($userId);

        // oldPassword);
        // formData.append("newPassword", newPassword);

        if (Hash::check($request->oldPassword, $users->password)) {


            $users->password = bcrypt($request->newPassword);
            $users->save();

            return response()->json([
                'status' => 200,
                'message' => 'User Updated Password'
            ]);
        } else {
            return response()->json([
                'status' => 204,
                'message' => 'Not Updated Password'
            ]);
        }
    }


    public function registeredLivechat()
    {
        $post = LiveChatRegistration::where('user_id', auth('sanctum')->user()->id)->latest()->get();

        return response()->json([
            'status' => 200,
            'message' => 'Ok',
            'events' => $post,
        ]);
    }
    public function qna_activities()
    {
        $post = QnaRegistration::where('user_id', auth('sanctum')->user()->id)->latest()->get();


        return response()->json([
            'status' => 200,
            'message' => 'Ok',
            'events' => $post,
        ]);
    }

    public function registeredLearningSession()
    {
        $register = LearningSessionRegistration::where('user_id', auth('sanctum')->user()->id)->latest()->get();

        return response()->json([
            'status' => 200,
            'message' => 'Ok',
            'events' => $register,
        ]);
    }

    public function registerGreetings()
    {
        $register = GreetingsRegistration::where('user_id', auth('sanctum')->user()->id)->latest()->get();

        return response()->json([
            'status' => 200,
            'message' => 'Ok',
            'events' => $register,
        ]);
    }

    public function registeredMeetup()
    {
        $post = MeetupEventRegistration::where('user_id', auth('sanctum')->user()->id)->latest()->get();

        return response()->json([
            'status' => 200,
            'message' => 'Ok',
            'events' => $post,
        ]);
    }


    public function getAllLiveChatEvent()
    {
        $livechats = LiveChat::orderBy('id', 'DESC')->get();

        return response()->json([
            'status' => 200,
            'message' => 'Ok',
            'livechats' => $livechats,
        ]);
    }
    public function getQnaAll()
    {
        $livechats = QnA::orderBy('id', 'DESC')->get();

        return response()->json([
            'status' => 200,
            'message' => 'Ok',
            'livechats' => $livechats,
        ]);
    }
    public function getStarQna($id)
    {
        $livechats = Post::orderBy('id', 'DESC')->where('user_id', $id)->where('type', 'qna')->get();
        return response()->json([
            'status' => 200,
            'message' => 'Ok',
            'livechats' => $livechats,
        ]);
    }


    public function getAllLiveChatEventByStar($id)
    {
        $livechats = LiveChat::where('star_id', $id)->orderBy('id', 'DESC')->get();

        return response()->json([
            'status' => 200,
            'message' => 'Ok',
            'livechats' => $livechats,
        ]);
    }
    public function getAllPostWithForSingleStar($star_id)
    {
        $int_value = (int) $star_id;

        $post = Post::where('type', '!=', null)->where('star_id', $star_id)->orWhereJsonContains('star_id', [$int_value])->latest()->get();
        // $post = Post::where('type', '!=', null)->orWhere('star_id', $star_id)->orWhere('user_id', $star_id)->orWhereJsonContains('star_id', $star_id)->latest()->get();

        return response()->json([
            'status' => 200,
            'message' => 'Ok',
            'posts' => $post,
        ]);
    }


    public function getSingleLiveChatEvent($id)
    {
        $livechat = LiveChat::find($id);

        return response()->json([
            'status' => 200,
            'message' => 'Ok',
            'livechat' => $livechat,
        ]);
    }

    public function sinlgeLiveChat($id)
    {
        $liveChat = Livechat::find($id);
        $starInfo = User::find($liveChat->star_id);

        return response()->json([
            'status' => 200,
            'message' => 'Ok',
            'liveChat' => $liveChat,
            'starInfo' =>  $starInfo
        ]);
    }

    public function liveChatDetails($slug)
    {
        $event = LiveChat::where('slug', $slug)->first();

        return response()->json([
            'status' => 200,
            'event' => $event,
        ]);
    }


    public function liveChatRegDetails($id)
    {
        $event = LiveChatRegistration::where([['live_chat_id', $id], ['user_id', auth('sanctum')->user()->id]])->first();
        return response()->json([
            'status' => 200,
            'event' => $event,
        ]);
    }

    public function qnaRegDetails($id)
    {
        $event = QnaRegistration::where([['qna_id', $id], ['user_id', auth('sanctum')->user()->id]])->first();

        return response()->json([
            'status' => 200,
            'event' => $event,

        ]);
    }

    // Question and Answers

    public function qnaDetails($slug)
    {
        $event = QnA::where('slug', $slug)->first();

        return response()->json([
            'status' => 200,
            'event' => $event,
        ]);
    }

    public function getSingleQnaEvent($id)
    {
        $livechat = QnA::find($id);

        return response()->json([
            'status' => 200,
            'message' => 'Ok',
            'livechat' => $livechat,
        ]);
    }

    public function sinlgeQna($id)
    {
        $liveChat = QnA::find($id);
        $starInfo = User::find($liveChat->star_id);

        return response()->json([
            'status' => 200,
            'message' => 'Ok',
            'liveChat' => $liveChat,
            'starInfo' =>  $starInfo
        ]);
    }


    public function meetupDetails($slug)
    {
        $event = MeetupEvent::where('slug', $slug)->first();

        return response()->json([
            'status' => 200,
            'event' => $event,
        ]);
    }


    public function getLiveChatTiemSlot($minute, $id)
    {
        $livechat = LiveChat::find($id);

        $user_start_time = $livechat->available_start_time ? $livechat->available_start_time : $livechat->start_time;
        $user_end_time = Carbon::parse($user_start_time)->addMinutes($minute)->format('H:i:s');

        $start_date = new DateTime($user_start_time);
        $end_date = new DateTime($livechat->end_time);

        $interval = $start_date->diff($end_date);
        $hours   = $interval->format('%h');
        $minutes = $interval->format('%i');

        $available_minutes = ($hours * 60 + $minutes);
        // $available_time = $available_minutes - $taken_minute;

        if ($available_minutes >= $minute) {
            $msg = "Congratulation! Slot is available for You";
            $available_status = true;
        } else {
            $msg = "Sorry! Slot is not available";
            $available_status = false;
        }


        return response()->json([
            'status' => 200,
            'start_time' => $user_start_time,
            'end_time' => $user_end_time,
            'available' => $available_status,
            'message' =>  $msg,
        ]);
    }

    // Q&A

    public function getLiveQnaTiemSlot($minute, $id)
    {
        $qna = QnA::find($id);

        $user_start_time = $qna->available_start_time ? $qna->available_start_time : $qna->start_time;
        $user_end_time = Carbon::parse($user_start_time)->addMinutes($minute)->format('H:i:s');

        $start_date = new DateTime($user_start_time, new DateTimeZone('Asia/Dhaka'));
        $end_date = new DateTime($qna->end_time, new DateTimeZone('Asia/Dhaka'));

        $interval = $start_date->diff($end_date);
        $hours   = $interval->format('%h');
        $minutes = $interval->format('%i');

        $available_minutes = ($hours * 60 + $minutes);
        // $available_time = $available_minutes - $taken_minute;

        if ($available_minutes >= $minute) {
            $msg = "Congratulation! Slot is available for You";
            $available_status = true;
        } else {
            $msg = "Sorry! Slot is not available";
            $available_status = false;
        }

        return response()->json([
            'status' => 200,
            'start_time' => $user_start_time,
            'end_time' => $user_end_time,
            'available' => $available_status,
            'message' =>  $msg,
        ]);
    }



    public function liveChatRigister(Request $request)
    {
        $create_room_id =  createRoomID();

        $liveChat = LiveChat::find($request->event_id);
        $liveChat->slot_counter = $liveChat->slot_counter + $request->minute;
        $start_time = Carbon::parse($liveChat->start_time)->addMinutes($liveChat->slot_counter);
        $end_time = Carbon::parse($start_time)->addMinutes($request->minute);

        $liveChatReg = new LiveChatRegistration();
        $liveChatReg->live_chat_id =  $request->event_id;
        $liveChatReg->user_id =  auth('sanctum')->user()->id;
        $liveChatReg->payment_method =  null;
        $liveChatReg->payment_status =  1;
        $liveChatReg->payment_date =  Carbon::now();
        $liveChatReg->amount =  $liveChat->fee * $request->minute;
        $liveChatReg->card_holder_name =  null;
        $liveChatReg->account_no =  null;
        $liveChatReg->live_chat_start_time = $start_time;
        $liveChatReg->live_chat_end_time =   $end_time;
        $liveChatReg->live_chat_date =  $liveChat->event_date;
        $liveChatReg->video =  null;
        $liveChatReg->comment_count =  null;
        $liveChatReg->publish_status =  1;
        $liveChatReg->save();

        $liveChat->save();

        // New Activity Add for Live Chat Register
        $activity = new Activity();
        $activity->user_id = auth('sanctum')->user()->id;
        $activity->event_id = $request->event_id;
        $activity->event_registration_id = $liveChatReg->id;

        $activity->room_id = $create_room_id;
        $activity->type = 'livechat';
        $activity->save();

        //live chat room create
        $liveChatRoom = new LiveChatRoom();
        $liveChatRoom->live_chat_id = $request->event_id;
        $liveChatRoom->star_id = $request->star_id;
        $liveChatRoom->user_id = auth('sanctum')->user()->id;
        $liveChatRoom->room_id = $create_room_id;
        $liveChatRoom->status = 0;
        $liveChatRoom->save();


        return response()->json([
            'status' => 200,
            'message' => 'Registation done successfully',
        ]);
    }


    /**
     * greetings registations take time
     */
    public function greetingsRegistation(Request $request)
    {
        $greetings = new GreetingsRegistration();

        $greetings->request_time = Carbon::parse($request->input('time'));
        $greetings->purpose = $request->purpose;
        $greetings->user_id = auth('sanctum')->user()->id;
        $greetings->greeting_id = $request->greetings_id;
        $greetings->save();

        // New Activity Add for Greeting Register
        // $activity = new Activity();
        // $activity->user_id = auth('sanctum')->user()->id;
        // $activity->event_id = $request->greetings_id;
        // $activity->event_registration_id = $greetings->id;
        // $activity->type = 'greeting';
        // $activity->save();

        return response()->json([
            'status' => 200,
            'message' => "Your request time is pending,Wating for approval",
            'greeting' => $greetings,
        ]);
    }
    /**
     * greetings reggistaion update
     */
    public function greetingsRegistationUpdate(Request $request)
    {
        // return $request->all();
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:2',
            'greeting_context' => 'required|min:2',
            'additional_message' => 'nullable|min:2',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'validation_errors' => $validator->errors(),
            ]);
        } else {
            $greeting_reg = GreetingsRegistration::find($request->greeting_registration_id);
            $greeting_reg->name = $request->name;
            $greeting_reg->greeting_context = $request->greeting_context;
            $greeting_reg->additional_message = $request->additional_message;
            $greeting_reg->status = 1;
            $greeting_reg->save();

            return response()->json([
                'status' => 200,
                'greeting' => $greeting_reg->greeting,
                'greetingsRegistration' => $greeting_reg,
            ]);
        }
    }
    public function greetingInfoToRegistration($greeting_id)
    {
        $greeting = Greeting::find($greeting_id);
        $greetingsRegistration =  GreetingsRegistration::where([['user_id', auth('sanctum')->user()->id], ['greeting_id', $greeting_id], ['notification_at', '!=', null]])->orderBy('id', 'DESC')->first();



        return response()->json([
            'status' => 200,
            'greeting' => $greeting,
            'greetingsRegistration' => $greetingsRegistration,
        ]);
    }

    /**
     * public function greetings stastus
     */
    public function greetingStatus($star_id)
    {
        $single_greeting = GreetingsRegistration::whereHas('greeting', function ($q) use ($star_id) {
            $q->where([['star_id', $star_id]]);
        })->where([['user_id', auth('sanctum')->user()->id], ['notification_at', null]])->orderBy('id', 'DESC')->first();

        if (isset($single_greeting)) {
            return response()->json([
                'status' => 200,
                'action' => true,
                'greeting' => $single_greeting,
            ]);
        } else {
            return response()->json([
                'status' => 200,
                'action' => false,
                'greeting' => $single_greeting,
            ]);
        }
    }
    public function getPurposeList()
    {
        $greetingTypes = GreetingType::where('status', 1)->orderBy('greeting_type', 'ASC')->get();
        return response()->json([
            'status' => 200,
            'greetingTypes' => $greetingTypes,
        ]);
    }

    /**
     * user greetings Activety check
     */
    public function starGreetingsStatus($star_id)
    {
        $single_greeting = Greeting::where('star_id', $star_id);
        if (isset($single_greeting)) {

            return response()->json([
                'status' => 200,
                'action' => true
            ]);
        } else {
            return response()->json([
                'status' => 200,
                'action' => false
            ]);
        }
    }


    public function submit_react2($id)
    {
        $post = Post::find($id);

        $array = $post->react_provider ? json_decode($post->react_provider) : [];

        if (!in_array(auth('sanctum')->user()->id, $array)) {
            array_push($array,  auth('sanctum')->user()->id);
            $post->react_number = $post->react_number + 1;
            // $array[] = auth('sanctum')->user()->id;
        } else {
            if (($key = array_search(auth('sanctum')->user()->id, $array))) {
                unset($array[$key]);
            }
            $post->react_number = $post->react_number - 1;
        }
        $post->react_provider = $array;
        $post->save();



        return response()->json([
            'status' => 200,
            'message' => 'Ok',
        ]);
    }

    // Store Fan Post Like count for user
    public function submit_react(Request $request, $id)
    {
        $post = Post::find($id);
        $post->user_like_id = $request->showlike;
        $post->save();

        return response()->json([
            'status' => 200,
            // 'liker_id' => $post->user_like_id,
            'message' => 'React Submitted',
        ]);
    }



    public function check_react($id)
    {
        $reacted = React::where([['post_id', $id], ['user_id', auth('sanctum')->user()->id]])->first();

        //$reacted = React::where('post_id',$id)->first();+
        return response()->json([
            'status' => 200,
            'message' => 'Ok',
            'reacted' => $reacted
        ]);
    }

    /**
     * user notification check
     */
    public function checkUserNotifiaction()
    {
        $notification = Notification::where('user_id', auth('sanctum')->user()->id)->orderBy('updated_at', 'ASC')->get();
        $greeting_reg = GreetingsRegistration::where('user_id', auth('sanctum')->user()->id)->first();

        if ($greeting_reg)
            $greeting_info = Greeting::find($greeting_reg->greeting_id);
        else
            $greeting_info = '';

        return response()->json([
            'status' => 200,
            'user_id' => auth('sanctum')->user()->id,
            'notifiction' => $notification,
            'greeting_info' => $greeting_info,
        ]);
    }

    public function auctionProduct()
    {

        $id = auth('sanctum')->user()->id;
        $selectedCategory = ChoiceList::where('user_id', $id)->first();

        $selectedCat = json_decode($selectedCategory->category);
        $selectedSubCat = json_decode($selectedCategory->subcategory);
        $selectedSubSubCat = json_decode($selectedCategory->star_id);

        $cat_post = Auction::with('star')->orderBy('id', 'DESC')->where('status', 1)
            ->whereIn('category_id', $selectedCat)
            ->latest()->get();

        if (isset($sub_cat_post)) {
            $sub_cat_post = Auction::with('star')->orderBy('id', 'DESC')->where('status', 1)
                ->whereIn('sub_category_id', $selectedSubCat)
                ->latest()->get();
        } else {
            $sub_cat_post = [];
        }

        if (isset($sub_sub_cat_post)) {
            $sub_sub_cat_post = Auction::with('star')->orderBy('id', 'DESC')->where('status', 1)
                ->whereIn('user_id', $selectedSubSubCat)
                ->latest()->get();
        } else {
            $sub_sub_cat_post = [];
        }

        $product = $cat_post->concat($sub_cat_post)->concat($sub_sub_cat_post);

        return response()->json([
            'status' => 200,
            'product' => $product
        ]);


        // $product = Auction::with('star')->orderBy('id','DESC')->where('status', 1)->get();
        // return response()->json([
        //     'status' => 200,
        //     'product' => $product
        // ]);

    }
    public function  auctionSingleProduct($id)
    {
        $auctionInfo = Auction::findOrFail($id);
        $instruction = AuctionTerms::first();

        return response()->json([
            'status' => 200,
            'auctionInfo' => $auctionInfo,
            'userInfo' => auth('sanctum')->user(),
            'instruction' => $instruction,
        ]);
    }

    public function starAuction($star_id)
    {

        $product = Auction::with('star', 'bidding', 'bidding.user')->orderBy('id', 'DESC')->where('star_id', $star_id)->where('status', 1)->latest()->get();
        return response()->json([
            'status' => 200,
            'product' => $product,
            'message' => 'okay',
        ]);
    }
    public function starAuctionProduct($product_id)
    {
        $product = Auction::with('star')->where('id', $product_id)->get();
        // $product = Auction::with(['star', 'bidding.user'])->where('id', $product_id)->get();
        return response()->json([
            'status' => 200,
            'product' => $product,
            'message' => 'okay',
        ]);
    }
    public function bidNow(Request $request)
    {
        // return response()->json($request->all());

        $user = User::find(auth()->user()->id);
        if (Hash::check($request->password, $user->password)) {
            $bidding = Bidding::create([

                'user_id' => $user->id,
                'auction_id' => $request->auction_id,
                'name' => $user->first_name,
                'amount' => $request->amount,
            ]);


            if (!Activity::where([['user_id', auth()->user()->id], ['event_id', $bidding->auction_id], ['type', 'auction']])->exists()) {
                Activity::Create([
                    'type'    => 'auction',
                    'user_id'    => $bidding->user_id,
                    'event_id'    => $bidding->auction_id,
                    'event_registration_id'    => $bidding->auction_id,
                ]);
            }

            return response()->json([

                'status' => 200,
                'data' => $bidding,
            ]);
        } else {
            return response()->json([
                'status' => 201,
                'message' => 'Passowrd Not Match'
            ]);
        }
    }

    public function liveBidding($auction_id)
    {
        $bidding = Bidding::with('user')->orderBy('amount', 'DESC')->where('auction_id', $auction_id)->take(6)->get();
        return response()->json([
            'status' => 200,
            'bidding' => $bidding,
        ]);
    }
    public function auctionApply($auction_id)
    {
        $auctionApply = Bidding::with('user', 'auction')->where('auction_id', $auction_id)->where('notify_status', 1)->where('user_id', auth()->user()->id)->first();
        $winner = Bidding::with('user', 'auction')->where('auction_id', $auction_id)->where('win_status', 1)->where('user_id', auth()->user()->id)->first();
        return response()->json([
            'status' => 200,
            'auctionApply' => $auctionApply,
            'winner' => $winner
        ]);
    }
    public function maxBid($id)
    {
        $maxBid = Bidding::orderBy('amount', 'DESC')->where('auction_id', $id)->where('user_id', auth()->user()->id)->first();
        return response()->json([
            'status' => 200,
            'maxBid' => $maxBid,
        ]);
    }



    public function aquiredProduct(Request $request)
    {

        $bidding = Bidding::where('id', $request->bidding_id)->first();

        $validator = Validator::make($request->all(), [

            'name' => 'required',
            'phone' => 'required',
            'card_number' => 'required',
            'ccv' => 'required',
            'expiry_date' => 'required',


        ], [
            'name.required' => 'This Field Is Required',
            'phone.required' => 'This Field Is Required',
            'card_number.required' => 'This Field Is Required',
            'ccv.required' => 'This Field Is Required',
            'expiry_date.required' => 'This Field Is Required',

        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 402,
                'errors' => $validator->errors(),
            ]);
        }

        $aquired = Acquired_app::create([
            'name' => $request->name,
            'bidding_id' => $request->bidding_id,
            'payment_id' => 1,
            'card_number' => $request->card_number,
            'phone' => $request->phone,
            'ccv' => $request->ccv,
            'expiry_date' => $request->expiry_date,
        ]);


        if ($bidding->applied_status == 0) {
            $bidding->applied_status = 1;
            $bidding->update();
        }

        return response()->json([
            'status' => 200,
            'aquired' => $aquired,
            'message' => "Application success"
        ]);
    }

    public function bidHistory($auction_id)
    {
        $bidHistory = Bidding::orderBy('id', 'DESC')->where('user_id', auth()->user()->id)->where('auction_id', $auction_id)->get();
        return response()->json([
            'status' => 200,
            'bidHistory' => $bidHistory,
        ]);
    }
    public function topBidder($auction_id)
    {
        $topBidder = Bidding::orderBy('amount', 'DESC')->where('auction_id', $auction_id)->limit(4);
        return response()->json([
            'status' => 200,
            'topBidder' => $topBidder,
        ]);
    }
    public function auction_activites()
    {
        $post = Activity::where([['user_id', auth('sanctum')->user()->id], ['type', 'auction']])->latest()->get();


        return response()->json([
            'status' => 200,
            'message' => 'Ok',
            'events' => $post,
        ]);
    }
    //=============== Audition Logic By Srabon ===================

    public function audition_list()
    {
        $upcomingAuditions = Audition::where('status', 2)->latest()->get();

        return response()->json([
            'status' => 200,
            'event' => $upcomingAuditions,
        ]);
    }


    public function participateAudition($id)
    {
        $participateAudition = Audition::with('judge.user')->where('id', $id)->get();

        return response()->json([
            'status' => 200,
            'participateAudition' => $participateAudition,
        ]);
    }
    public function participantRegister(Request $request)
    {

        $user = User::find(auth()->user()->id);

        if (Hash::check($request->password, $user->password)) {


            if (AuditionParticipant::where('user_id', $user->id)->exists()) {
                return response()->json([
                    'status' => 201,
                    'message' => 'User already Registered'
                ]);
            } else {

                $participant = AuditionParticipant::create([

                    'audition_id' => $request->audition_id,
                    'user_id' => $user->id,
                    'accept_status' => 0,
                ]);
                return response()->json([

                    'status' => 200,
                    'data' => $participant,
                ]);
            }
        } else {
            return response()->json([
                'status' => 201,
                'message' => 'Passowrd Not Match'
            ]);
        }
    }

    public function roundAppealRegister(Request $request)
    {
        $user = User::find(auth()->user()->id);

        if (AuditionRoundAppealRegistration::where([['user_id', $user->id], ['audition_id', $request->audition_id], ['round_info_id', $request->round_info_id]])->first()) {
            return response()->json([
                'status' => 200,
                'appealedRegistration' => AuditionRoundAppealRegistration::where([['user_id', $user->id], ['audition_id', $request->audition_id], ['round_info_id', $request->round_info_id]])->first(),
                'message' => 'User already Registered for this round'
            ]);
        } else {

            $appealedRegistration = AuditionRoundAppealRegistration::create([
                'audition_id' => $request->audition_id,
                'round_info_id' => $request->round_info_id,
                'user_id' => $user->id,
            ]);
            return response()->json([
                'status' => 200,
                'appealedRegistration' => $appealedRegistration,
            ]);
        }
    }

    public function isAppealForThisRound($audition_id, $round_info_id)
    {
        $user = User::find(auth()->user()->id);
        $appealedRegistration  = AuditionRoundAppealRegistration::where([['user_id', $user->id], ['audition_id', $audition_id], ['round_info_id', $round_info_id]])->first();

        if ($appealedRegistration) {
            $isAppealedForThisRound = true;
        } else {
            $isAppealedForThisRound = false;
        }

        return response()->json([
            'status' => 200,
            'isAppealedForThisRound' => $isAppealedForThisRound,
            'appealedRegistration' => $appealedRegistration,
        ]);
    }

    public function userRoundVideoUpload(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file.*' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'validation_errors' => $validator->errors(),
            ]);
        } else {
            foreach ($request->file as $key => $file) {
                $audition_video = new AuditionUploadVideo();
                $audition_video->audition_id = $request->audition_id;
                $audition_video->round_info_id = $request->round_info_id;
                $audition_video->user_id = auth('sanctum')->user()->id;
                $audition_video->type = $request->type;

                $file_name   = time() . rand('0000', '9999') . $key . '.' . $file->getClientOriginalName();
                $file_path = 'uploads/videos/auditions/';
                $file->move($file_path, $file_name);
                $audition_video->video = $file_path . $file_name;
                $audition_video->save();
            }
            return response()->json([
                'status' => 200,
                'message' => 'Audition Videos Uploaded Successfully!',
            ]);
        }
    }


    public function uploaded_round_videos($audition_id, $round_info_id)
    {
        $videos = AuditionUploadVideo::where([['audition_id', $audition_id], ['round_info_id', $round_info_id], ['user_id', auth()->user()->id], ['type', 'general']])->get();

        $appeal_videos = AuditionUploadVideo::where([['audition_id', $audition_id], ['round_info_id', $round_info_id], ['user_id', auth()->user()->id], ['type', 'appeal']])->get();

        $auditionRoundMarkTracking = AuditionRoundMarkTracking::where([['user_id', auth()->user()->id], ['audition_id', $audition_id],  ['type', 'general'], ['round_info_id', $round_info_id]])->orWhere([['user_id', auth()->user()->id], ['audition_id', $audition_id],  ['type', 'wildcard'], ['round_info_id', $round_info_id]])->orWhere([['user_id', auth()->user()->id], ['audition_id', $audition_id],  ['type', 'rejected'], ['round_info_id', $round_info_id]])->orWhere([['user_id', auth()->user()->id], ['audition_id', $audition_id],  ['type', 'oxygen'], ['round_info_id', $round_info_id]])->first();
        $appealAuditionRoundMarkTracking = AuditionRoundMarkTracking::where([['user_id', auth()->user()->id], ['audition_id', $audition_id], ['type', 'appeal'], ['round_info_id', $round_info_id]])->orWhere([['user_id', auth()->user()->id], ['audition_id', $audition_id],  ['type', 'appeal_rejected'], ['round_info_id', $round_info_id]])->first();

        return response()->json([
            'status' => 200,
            'videos' => $videos,
            'auditionRoundMarkTracking' => $auditionRoundMarkTracking,
            'appealAuditionRoundMarkTracking' => $appealAuditionRoundMarkTracking,
            'appeal_videos' => $appeal_videos,
            'message' => 'Success!',
        ]);
    }
    public function auditionCertificatePayment(Request $request)
    {
        $payment = new Payment();
        $payment->user_id =  auth('sanctum')->user()->id;
        $payment->event_id = $request->event_id;
        $payment->round_id = $request->round_id;
        $payment->event_type = $request->event_type;
        $payment->payment_type = $request->payment_type;
        $payment->card_holder_name = $request->card_holder_name;
        $payment->card_number = $request->card_number;
        $payment->date = $request->date;
        $payment->status = 1;
        $payment->save();
        if ($payment) {
            return response()->json([
                'status' => 200,
                'message' => 'Certificate Payment Successfully'
            ]);
        } else {
            return response()->json([
                'status' => 402,
                'message' => 'Something wrong'
            ]);
        }
    }


    public function getAuditionCertificateData($audition_id, $round_info_id)
    {
        $super = false;
        $auditionRoundMarkTracking = AuditionRoundMarkTracking::where([
            ['user_id', auth()->user()->id],
            ['audition_id', $audition_id], ['round_info_id', $round_info_id], ['wining_status', 1]
        ])->first();

        if ($auditionRoundMarkTracking) {


            $assignedJudges = AuditionAssignJudge::where('audition_id', $audition_id)->get();
            $totalStars = [];
            foreach ($assignedJudges as $judge) {
                if ($judge->super_judge == 1) {
                    $super = true;
                }
                $superstarId = $judge->judge_id;
                $superStar = SuperStar::where('star_id', $superstarId)->first();
                $superstarName = $superStar->superStar->first_name . " " . $superStar->superStar->last_name;
                $starInfo = [
                    'isSuperAdmin' => $super,
                    'signature' => $superStar['signature'],
                    'name' => $superstarName,
                ];
                array_push($totalStars, $starInfo);
            }
            $userInfo = $auditionRoundMarkTracking->user;
            $certificateContent = AuditionCertificationContent::where([['audition_id', $audition_id]])->first();

            // Calculate for rating star
            $round_info = AuditionRoundInfo::where('id', $round_info_id)->first();
            $totalRound = AuditionRoundInfo::where('audition_id', $audition_id)->count();
            $starRating =  (($round_info->round_num * 5) / $totalRound);
            // return $totalRound;


            $PDFInfo = [
                'user' => ($userInfo['first_name'] . ' ' . $userInfo['last_name']),
                'stars' => $totalStars,
                'certificateContent' => $certificateContent,
                'starRating' => $starRating
            ];
            return response()->json([
                'status' => 200,
                'certificateData' => $PDFInfo,
            ]);
        } else {
            return response()->json([
                'status' => 200,
                'message' =>  "Sorry! You are not passed",
            ]);
        }
    }


    public function videoUpload(Request $request)
    {


        $audition = AuditionParticipant::where('audition_id', $request->audition_id)->where('user_id', Auth::user()->id)->first();


        if ($request->hasFile('video_url') && $audition->video_url == null) {


            $file        = $request->file('video_url');
            $path        = 'uploads/videos/auditions';
            $file_name   = time() . rand('0000', '9999') . '.' . $file->getClientOriginalName();
            $file->move($path, $file_name);
            $audition->video_url = $path . '/' . $file_name;
        }

        $audition->filter_status = 0;

        $audition->update();

        return response()->json([
            'status' => 200,
        ]);
    }

    public function videoDetails($id)
    {
        $participateAudition = Audition::with(['judge.user', 'participant' => function ($query) {
            return $query->whereNotIn('user_id', [auth()->user()->id])->whereNotNull('video_url')->get();
        }])->where('id', $id)->get();

        $ownVideo = AuditionParticipant::where('user_id', Auth::user()->id)->where('audition_id', $id)->first();

        return response()->json([
            'status' => 200,
            'participateAudition' => $participateAudition,
            'ownVideo' => $ownVideo,
        ]);
    }

    public function enrolledAuditions()
    {
        $enrolledAuditions = AuditionParticipant::with(['audition'])->where('user_id', auth()->user()->id)->get();

        return response()->json([
            'status' => 200,
            'enrolledAuditions' => $enrolledAuditions,
        ]);
    }


    public function enrolledAuditionsPending()
    {

        $enrolledAuditionsPending = AuditionParticipant::with(['auditions'])->where('user_id', auth()->user()->id)->count();

        return response()->json([
            'status' => 200,
            'enrolledAuditionsPending' => $enrolledAuditionsPending,
        ]);
    }

    //message Controlling
    public function message(Request $request)
    {
        $message = new Message();

        $message->conversation_id = 1;
        $message->sender_id = $request->sender_id;
        $message->receiver_id = $request->receiver_id;
        $message->text = $request->text;
        $message->save();

        return response()->json([
            'status' => 200,
            'message' => $message,
        ]);
    }

    public function get_message($id)
    {
        $message = Message::where('conversation_id', 1)->get();

        return response()->json([
            'status' => 200,
            'message' => $message,
        ]);
    }

    //group message Controlling
    public function group_message(Request $request)
    {
        $message = new FanGroupMessage();

        $message->group_id = $request->group_id;
        $message->sender_id = $request->sender_id;
        $message->sender_name = $request->sender_name;
        $message->sender_image = $request->sender_image;
        $message->position = $request->position;
        $message->text = $request->text;
        $message->save();

        return response()->json([
            'status' => 200,
            'message' => $message,
        ]);
    }

    public function get_group_message($id)
    {
        $message = FanGroupMessage::where('group_id', $id)->get();

        return response()->json([
            'status' => 200,
            'message' => $message,
        ]);
    }

    public function getPromoVideo()
    {
        $id = auth('sanctum')->user()->id;
        $selectedCategory = ChoiceList::where('user_id', $id)->first();

        $selectedCat = json_decode($selectedCategory->category);
        $selectedSubCat = json_decode($selectedCategory->subcategory);
        $selectedSubSubCat = json_decode($selectedCategory->star_id);
        $today = Carbon::now();
        $cat_promo = PromoVideo::select("*")
            ->whereIn('category_id', $selectedCat)
            ->where('status', 2)
            ->whereDate('publish_start_date', '<=', $today)
            ->whereDate('publish_end_date', '>=', $today)
            ->orderBy('updated_at', 'desc')
            ->get();

        if (isset($sub_cat_promo)) {
            $sub_cat_promo = PromoVideo::select("*")
                ->whereIn('sub_category_id', $selectedSubCat)
                ->where('status', 2)
                ->whereDate('publish_start_date', '<=', $today)
                ->whereDate('publish_end_date', '>=', $today)
                ->orderBy('updated_at', 'desc')
                ->get();
        } else {
            $sub_cat_promo = [];
        }

        if (isset($sub_sub_cat_promo)) {
            $sub_sub_cat_promo = PromoVideo::select("*")
                ->where('status', 2)
                ->whereIn('star_id', $selectedSubSubCat)
                ->whereDate('publish_start_date', '<=', $today)
                ->whereDate('publish_end_date', '>=', $today)
                ->orderBy('updated_at', 'desc')
                ->get();
        } else {
            $sub_sub_cat_promo = [];
        }

        $promoVideos = $cat_promo->concat($sub_cat_promo)->concat($sub_sub_cat_promo);
        return response()->json([
            'status' => 200,
            'promoVideos' => $promoVideos,
        ]);
    }

    // User Profile Update

    public function updateCover(Request $request, $id)
    {
        
        
        $validator = Validator::make($request->all(), [
            'cover_photo' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'cover_photo' => $validator->errors(),
            ]);
        } else {
            $user = User::find($id);
            if ($request->hasfile('cover_photo')) {

                $destination = $user->cover_photo;
                if (File::exists($destination)) {
                    File::delete($destination);
                }
                $file = $request->file('cover_photo');
                $extension = $file->getClientOriginalExtension();
                $filename = 'uploads/images/userPhotos/' . time() . 'coverimage.' . $extension;
                Image::make($file)->resize(900, 400)->save($filename, 50);
                $user->cover_photo = $filename;
            }

            $user->save();

            return response()->json([
                'status' => 200,
                'message' =>  'Cover Photo Updated Successfully',
            ]);
        }
    }


    public function updateProfile(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'image' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'image' => $validator->errors(),
            ]);
        } else {
            $user = User::find($id);
            if ($request->hasfile('image')) {

                $destination = $user->image;
                if (File::exists($destination)) {
                    File::delete($destination);
                }
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension();
                $filename = 'uploads/images/userPhotos/' . time() . 'coverimage.' . $extension;
                Image::make($file)->resize(900, 400)->save($filename, 50);
                $user->image = $filename;
            }

            $user->save();

            return response()->json([
                'status' => 200,
                'message' =>  'Cover Photo Updated Successfully',
            ]);
        }
        
    }

    public function userActivites()
    {

        $userActivites = Activity::orderBy('id', 'DESC')->where('user_id', auth()->user()->id)->get();
        $fanGroup = Fan_Group_Join::orderBy('id', 'DESC')->where('user_id', auth()->user()->id)->get();
        return response()->json([
            'status' => 200,
            'userActivites' => $userActivites,
            'fanGroup' => $fanGroup,

        ]);
    }

    public function paginate_userActivites($limit)
    {
        $userActivites = Activity::orderBy('id', 'DESC')->where('user_id', auth()->user()->id)->paginate($limit);


        return response()->json([
            'status' => 200,
            'userActivites' => $userActivites
        ]);
    }

    public function paginate_userActivites_by_id($id, $limit)
    {
        $userActivites = Activity::orderBy('id', 'DESC')->where('user_id', $id)->paginate($limit);

        return response()->json([
            'status' => 200,
            'userActivites' => $userActivites
        ]);
    }

    public function registration_checker($type, $slug)
    {
        if ($type == 'livechat') {
            $event = LiveChat::where('slug', $slug)->first();
            $participant = LiveChatRegistration::where([['user_id', auth('sanctum')->user()->id], ['live_chat_id', $event->id]])->first();
        }
        if ($type == 'learningSession') {
            $event = LearningSession::where('slug', $slug)->first();
            $participant = LearningSessionRegistration::where([['user_id', auth('sanctum')->user()->id], ['learning_session_id', $event->id]])->first();
        }
        if ($type == 'meetup') {
            $event = MeetupEvent::where('slug', $slug)->first();
            $participant = MeetupEventRegistration::where([['user_id', auth('sanctum')->user()->id], ['meetup_event_id', $event->id]])->first();
        }
        if ($type == 'qna') {
            $event = QnA::where('slug', $slug)->first();
            $participant = QnaRegistration::where([['user_id', auth('sanctum')->user()->id], ['qna_id', $event->id]])->first();
        }
        return response()->json([
            'status' => 200,
            'participant' => $participant,
        ]);
    }

    public function UserAuditionDetails($slug)
    {
        $audition = Audition::where('slug', $slug)->first();


        return response()->json([
            'status' => 200,
            'audition' => $audition,
        ]);
    }

    public function current_round_info($event_slug)
    {
        $audition = Audition::where('slug', $event_slug)->first();
        $round_info = AuditionRoundInfo::where('id', $audition->active_round_info_id)->first();
        $totalRound = AuditionRoundInfo::where('audition_id', $audition->id)->count();
        $round_instruction = AuditionRoundInstruction::where('round_info_id', $round_info->id)->first();
        $myWinningRoudInfoId = AuditionRoundMarkTracking::where('user_id', auth()->user()->id)->where('wining_status', 1)->where('audition_id',  $audition->id)->max('round_info_id');
        $myRoud = AuditionRoundInfo::where([['id', $myWinningRoudInfoId], ['audition_id',  $audition->id]])->first();


        return response()->json([
            'status' => 200,
            'audition' => $audition,
            'round_info' => $round_info,
            'round_instruction' => $round_instruction,
            'myRoundPass' => $myRoud ? $myRoud->round_num : 0,
            'totalRound' => $totalRound
        ]);
    }

    public function roundInstruction($audition_id, $round_num)
    {
        $roundInfo = AuditionRoundInfo::where([['audition_id', $audition_id], ['round_num', $round_num]])->first();
        $roundInstruction = AuditionRoundInstruction::where('round_info_id', $roundInfo->id)->first();

        $is_video_uploaded = false;
        // if ($roundInfo->uploadedVideos->where('round_id', $roundInfo->audition_round_rules_id)->where('user_id', auth()->user()->id)->count() > 0) {
        //     $is_video_uploaded  = true;
        // } else {
        //     $is_video_uploaded  = false;
        // }

        return response()->json([
            'status' => 200,
            'roundInfo' => $roundInfo,
            'roundInstruction' => $roundInstruction,
            'is_video_uploaded' => $is_video_uploaded,
        ]);
    }



    public function UserAuditionRegistrationChecker($slug)
    {
        $audition = Audition::where('slug', $slug)->first();
        $participant = AuditionParticipant::where([['user_id', auth('sanctum')->user()->id], ['audition_id', $audition->id]])->first();

        return response()->json([
            'status' => 200,
            'participant' => $participant,
        ]);
    }

    /**
     * laerning session video upload for mobile
     */
    public function lerningSessionAssinmentVideoUplad(Request $request)
    {
        $LearningSessionAssignment = LearningSessionAssignment::where([['event_id', $request->video['learningSessionId']], ['user_id', auth()->user()->id]])->get();




        if ($LearningSessionAssignment->count() <  (int)$request->video['taskNumber']) {
            $evaluation = LearningSessionEvaluation::where([['event_id', $request->video['learningSessionId']], ['user_id', auth()->user()->id]])->first();

            $learning_video = new LearningSessionAssignment();
            $learning_video->event_id = $request->video['learningSessionId'];
            $learning_video->user_id = auth()->user()->id;
            $learning_video->evaluation_id = $evaluation->id;

            $path = "uploads/videos/learnings/" . time() . rand('0000', '9999') . $request->video['name'] . ".mp4";

            $learning_video->video = $path;
            $learning_video->save();
            $LearningSessionAssignment = LearningSessionAssignment::where([['event_id', $request->video['learningSessionId']], ['user_id', auth()->user()->id]])->get();

            try {

                file_put_contents($path, base64_decode($request->video['data'], true));
            } catch (\Exception $exception) {
                return response()->json([
                    'status' => 500,
                    'message' =>  $exception->getMessage(),
                ]);
            }
        } else {
            return response()->json([
                'status' => 300,
                'message' => 'Video Already Submitted',
                'assinmentNumber' => $LearningSessionAssignment->count()
            ]);
        }





        return response()->json([
            'status' => 200,
            'message' => 'Learning Videos Uploaded Successfully!',
            'assinmentNumber' => $LearningSessionAssignment->count()
        ]);
    }

    public function uploadLearningSessionVideo(Request $request)
    {
        // return $request->all();
        $validator = Validator::make($request->all(), [
            'file.*' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'validation_errors' => $validator->errors(),
            ]);
        } else {
            $evaluation = LearningSessionEvaluation::where([['event_id', $request->learning_session_id], ['user_id', auth()->user()->id]])->first();
            foreach ($request->file as $key => $file) {
                $learning_video = new LearningSessionAssignment();
                $learning_video->event_id = $request->learning_session_id;
                $learning_video->user_id = auth()->user()->id;
                $learning_video->evaluation_id = $evaluation->id;

                $file_name   = time() . rand('0000', '9999') . $key . '.' . $file->getClientOriginalName();
                $file_path = 'uploads/videos/learnings/';
                $file->move($file_path, $file_name);
                $learning_video->video = $file_path . $file_name;
                $learning_video->save();
            }

            $learning_session = LearningSession::find($request->learning_session_id);
            return response()->json([
                'status' => 200,
                'message' => 'Learning Videos Uploaded Successfully!',
                'learningSession' => $learning_session,
            ]);
        }
    }

    public function saveCertificateInfo(Request $request)
    {
        // return $request->all();
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'father_name' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'validation_errors' => $validator->errors(),
            ]);
        } else {
            $user = User::find(auth('sanctum')->user()->id);

            if (!$user || !Hash::check($request->password, $user->password)) {
                return response()->json([
                    'status' => 401,
                    'message' => 'Invalid Credantials',
                ]);
            } else {
                $learning_session = LearningSession::find($request->event_id);

                if ($learning_session) {
                    $certificate =  LearningSessionCertificate::where([['event_id', $request->event_id], ['user_id', auth()->user()->id]])->first();
                    if (empty($certificate)) {
                        $certificate = new LearningSessionCertificate();
                    }
                    $certificate->event_id = $request->event_id;
                    $certificate->user_id = auth()->user()->id;
                    $certificate->name = $request->name;
                    $certificate->father_name = $request->father_name;
                    $certificate->save();
                }
                return response()->json([
                    'status' => 200,
                    'message' => 'Certificate Data Upload Successfully!',
                    'learningSession' => $learning_session,
                ]);
            }
        }
    }

    public function getCertificateData($event_id)
    {
        $certificate = LearningSessionCertificate::where([['event_id', $event_id], ['user_id', auth()->user()->id]])->first();
        return response()->json([
            'status' => 200,
            'certificateData' => $certificate,
        ]);
    }

    public function videoFeedVidoes()
    {


        $generalFailedUsers = AuditionRoundMarkTracking::whereHas('roundInfo', function ($q) {
            $q->where('videofeed_status', 1);
        })->where([['wining_status', 0], ['type', 'general']])->pluck('user_id')->toArray();

        $appealFailedUsers = AuditionRoundMarkTracking::whereHas('roundInfo', function ($q) {
            $q->where('videofeed_status', 1);
        })->where([['wining_status', 0], ['type', 'appeal']])->pluck('user_id')->toArray();

        $appealWinnerUsers = AuditionRoundMarkTracking::whereHas('roundInfo', function ($q) {
            $q->where('videofeed_status', 1);
        })->where([['wining_status', 1], ['type', 'appeal']])->pluck('user_id')->toArray();

        $generalFailedVideos = WildCard::whereHas('auditionRoundInfoEnd', function ($q) {
            $q->where('result_publish_start_date', '>', Carbon::now());
        })->with(['auditionRoundInfoStart' => function ($q) use ($generalFailedUsers, $appealWinnerUsers, $appealFailedUsers) {
            $q->with(['videos' => function ($q) use ($generalFailedUsers, $appealWinnerUsers, $appealFailedUsers) {
                $q->where([['approval_status', 1], ['type', 'general']])->whereIn('user_id', $generalFailedUsers)->whereNotIn('user_id', $appealWinnerUsers)->whereNotIn('user_id', $appealFailedUsers)->get();
            }])->where([['wildcard', 1], ['videofeed_status', 1], ['round_type', 0]])->latest()->get();
        }])->where('status', 1)->get()->toArray();


        $appealFailedVideos = WildCard::whereHas('auditionRoundInfoEnd', function ($q) {
            $q->where('result_publish_start_date', '>', Carbon::now());
        })->with(['auditionRoundInfoStart' => function ($q) use ($appealFailedUsers) {
            $q->with(['videos' => function ($q) use ($appealFailedUsers) {
                return $q->where([['approval_status', 1], ['type', 'appeal']])->whereIn('user_id', $appealFailedUsers)->get();
            }])->where([['wildcard', 1], ['videofeed_status', 1], ['round_type', 0]])->latest()->get();
        }])->where('status', 1)->get()->toArray();

        $userVoteVideos = AuditionRoundInfo::with(['videos' => function ($q) {
            $q->where([['approval_status', 1], ['type', 'general']])->get();
        }])->where([['has_user_vote_mark', 1], ['video_feed', 1], ['status', 1]])->latest()->get()->toArray();


        $roundVideos = array_merge($generalFailedVideos, $appealFailedVideos);
        $totalVideos = [];


        foreach ($roundVideos as $infoRound) {
            foreach (array($infoRound['audition_round_info_start']) as  $roundvideos) {
                foreach ($roundvideos['videos'] as $videos) {
                    array_push($totalVideos, $videos);
                }
            }
        }

        foreach ($userVoteVideos as $voteVideos) {
            foreach ($voteVideos['videos'] as $videos) {
                array_push($totalVideos, $videos);
            }
        }




        return response()->json([
            'status' => 200,
            'totalVideos' => $totalVideos,

        ]);
    }
    public function userVideoLoveReact(Request $request)
    {
        $auditionRoundInfo = AuditionUploadVideo::with('roundInfo')->where('id', $request->videoId)->first();


        if (LoveReact::where([['user_id', auth()->user()->id], ['react_num', $request->reactNum], ['video_id', $request->videoId]])->exists()) {

            $freeLoveReact = LoveReact::where([['user_id', auth()->user()->id], ['react_num', $request->reactNum], ['video_id', $request->videoId]])->delete();
        } else {
            $loveReact = LoveReact::create([
                'user_id' => auth()->user()->id,
                'video_id' => $request->videoId,
                'react_num' => $request->reactNum,
                'audition_id' => $auditionRoundInfo->roundInfo->audition_id,
                'round_info_id' => $auditionRoundInfo->roundInfo->id,
                'participant_id' => $auditionRoundInfo->user_id,
                'react_voting_type' => $auditionRoundInfo->roundInfo->has_user_vote_mark == 1 ? 'user_vote' : ($auditionRoundInfo->roundInfo->wildcard == 1 ? 'wildcard' : 'general'),
                'status' => 1,

            ]);
        }

        return response()->json([
            'status' => 200,
        ]);
    }
    public function userVideoLoveReactPayment(Request $request)
    {



        $auditionRoundInfo = AuditionUploadVideo::with('roundInfo')->where('id', $request->videoId)->first();


        if (!LoveReactPayment::where([['user_id', auth()->user()->id], ['react_num', $request->reactNum], ['video_id', $request->videoId]])->exists()) {

            $loveReactPayment = new LoveReactPayment();
            $loveReactPayment->user_id = auth()->user()->id;
            $loveReactPayment->video_id = $request->videoId;
            $loveReactPayment->react_num = $request->reactNum;
            $loveReactPayment->cardHolderName = $request->cardHolderName;
            $loveReactPayment->ccv = $request->ccv;
            $loveReactPayment->expireDate = $request->expireDate;
            $loveReactPayment->audition_id = $auditionRoundInfo->roundInfo->audition_id;
            $loveReactPayment->round_info_id = $auditionRoundInfo->roundInfo->id;
            $loveReactPayment->status = 1;
            $loveReactPayment->type = $request->type;
            $loveReactPayment->save();
            if ($request->type == "wallet") {
                $lovePoints =  Wallet::where('user_id', auth('sanctum')->user()->id)->first('love_points');
                Wallet::where('user_id', auth('sanctum')->user()->id)->update(['love_points' => $lovePoints->love_points - $request->reactNum]);
            }
            if ($loveReactPayment) {
                LoveReact::create([
                    'user_id' => auth()->user()->id,
                    'video_id' => $request->videoId,
                    'react_num' => $request->reactNum,
                    'audition_id' => $auditionRoundInfo->roundInfo->audition_id,
                    'round_info_id' => $auditionRoundInfo->roundInfo->id,
                    'participant_id' => $auditionRoundInfo->user_id,
                    'react_voting_type' => $auditionRoundInfo->roundInfo->has_user_vote_mark == 1 ? 'user_vote' : ($auditionRoundInfo->roundInfo->wildcard == 1 ? 'wildcard' : 'general'),
                    'status' => 1,

                ]);
            }
        }
        $userWallet = Wallet::where('user_id', auth('sanctum')->user()->id)->first();
        return response()->json([
            'status' => 200,
            'waletInfo' => $userWallet
        ]);
    }
    public function getOxygenVideo()
    {
        $oxygenVideos = AuditionOxygenVideo::whereHas('auditionRoundInfo', function ($q) {
            $q->where('status', 1);
        })->get();

        return response()->json([
            'status' => 200,
            'oxygenVideos' => $oxygenVideos
        ]);
    }
    public function oxygenReplyVideo(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'video' => 'required|mimes:mp4,mkv',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'validation_errors' => $validator->errors(),
            ]);
        } else {

            if ($request->hasfile('video')) {
                $file = $request->file('video');
                $extension = $file->getClientOriginalExtension();
                $newFileName = time() . '.' . $extension;
                $file->move('uploads/videos/auditions/post/', $newFileName);
            }

            $oxygenReply = AuditionOxygenReplyVideo::create([
                'audition_id' => $request->oxy_audition_id,
                'round_info_id' => $request->oxy_round_info_id,
                'reply_video' => 'uploads/videos/auditions/post/' . $newFileName,
                'oxygen_video_id' => $request->oxy_video_id,
                'user_id' => auth('sanctum')->user()->id,
                'participant_id' => $request->oxy_user_id,

            ]);
        }

        return response()->json([
            'status' => 200,
            'message' => "Video Comment Sent"
        ]);
    }

    public function allUpCommingEvents()
    {
        $learningSession = LearningSession::where('status', 2)->latest()->get();
        $LiveChat = LiveChat::where('status', 2)->orderBy('id', 'DESC')->get();
        $qna = QnA::where('status', 2)->orderBy('id', 'DESC')->get();
        $audition =  Audition::where('status', 2)->orderBy('id', 'DESC')->get();
        $meetup = MeetupEvent::where('status', 2)->orderBy('id', 'DESC')->get();

        return response()->json([
            'status' => 200,
            'learningSession' => $learningSession,
            'LiveChat' =>  $LiveChat,
            'qna' => $qna,
            'audition' =>  $audition,
            'meetup' =>  $meetup

        ]);
    }

    public function searchPost($valu)
    {
        $postData = Post::where('title', 'like', "%$valu%")->get();

        return response()->json([
            'status' => 200,
            'posts' => $postData
        ]);
    }
}
