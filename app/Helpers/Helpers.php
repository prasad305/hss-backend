<?php

use App\Models\Audition\AuditionParticipant;
use App\Models\Audition\AuditionRoundInfo;
use App\Models\Audition\AuditionUploadVideo;
use App\Models\AuditionCertification;
use App\Models\GeneralPostPayment;
use App\Models\GreetingsRegistration;
use App\Models\JuryGroup;
use App\Models\LearningSessionRegistration;
use App\Models\LiveChatRegistration;
use App\Models\LoveReact;
use App\Models\LoveReactPayment;
use App\Models\LoveReactPrice;
use App\Models\MarketplaceOrder;
use App\Models\MeetupEventRegistration;
use App\Models\Package;
use App\Models\QnaRegistration;
use App\Models\SouvenirApply;
use App\Models\SouvenirPayment;
use App\Models\StaticOption;
use App\Models\User;
use App\Models\Wallet;
use App\Models\WalletHistory;
use App\Models\WalletPayment;
use App\Models\Activity;
use App\Models\Audition\AuditionRoundAppealRegistration;
use App\Models\Bidding;
use App\Models\LearningSessionCertificate;
use App\Models\PaidLoveReactPrice;
use App\Models\SimplePost;
use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;

// use Illuminate\Support\Facades\Cache;
// use Illuminate\Support\Facades\Mail;
// use GuzzleHttp\Client;



if (!function_exists('random_code')) {

    function set_static_option($key, $value)
    {
        if (!StaticOption::where('option_name', $key)->first()) {
            StaticOption::create([
                'option_name' => $key,
                'option_value' => $value
            ]);
            return true;
        }
        return false;
    }

    function get_static_option($key)
    {
        if (StaticOption::where('option_name', $key)->first()) {
            $return_val = StaticOption::where('option_name', $key)->first();
            return $return_val->option_value;
        }
        return null;
    }

    function update_static_option($key, $value)
    {
        if (!StaticOption::where('option_name', $key)->first()) {
            StaticOption::create([
                'option_name' => $key,
                'option_value' => $value
            ]);
            return true;
        } else {
            StaticOption::where('option_name', $key)->update([
                'option_name' => $key,
                'option_value' => $value
            ]);
            return true;
        }
        return false;
    }

    function set_env_value(array $values)
    {
        $envFile = app()->environmentFilePath();
        $str = file_get_contents($envFile);
        if (count($values) > 0) {
            foreach ($values as $envKey => $envValue) {
                $str .= "\n"; // In case the searched variable is in the last line without \n
                $keyPosition = strpos($str, "{$envKey}=");
                $endOfLinePosition = strpos($str, "\n", $keyPosition);
                $oldLine = substr($str, $keyPosition, $endOfLinePosition - $keyPosition);
                // If key does not exist, add it
                if (!$keyPosition || !$endOfLinePosition || !$oldLine) {
                    $str .= "{$envKey}={$envValue}\n";
                } else {
                    $str = str_replace($oldLine, "{$envKey}={$envValue}", $str);
                }
            }
        }

        $str = substr($str, 0, -1);
        if (!file_put_contents($envFile, $str)) return false;
        return true;
    }

    function get_total_volenteers()
    {
        return User::where('user_type', 'volunteer')->where('center_id', Auth::user()->center_id)->count();
    }

    function get_max_service_per_day($totalDayMinutes, $per_precess_minute, $number_of_volunteers)
    {
        $man_power_minute_for_precess = $number_of_volunteers * $totalDayMinutes;
        return $man_power_minute_for_precess / $per_precess_minute;
    }

    //sending Message ///

    function send_sms($message, $phone)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.sms.net.bd/sendsms',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
                'api_key' => 'l2Phx0d2M8Pd8OLKuuM1K3XZVY3Ln78jUWzoz7xO',
                'msg' => $message,
                'to' => $phone
            ),
        ));
        $response = curl_exec($curl);

        curl_close($curl);

        // send sms via helper function
        // send_sms('Welcome to Visa Covid, your otp is : ' . $user->otp, $user->phone);
    }

    function success($message = 'Your operation has been done successfully')
    {
        session()->flash('success', $message);
    }

    function whoops($message = 'Whoops! Something went Wrong!')
    {
        session()->flash('danger', $message);
    }

    function is_save($object, $message)
    {
        if ($object) {
            success($message);
            return redirect()->back();
        }

        whoops();
        return redirect()->back();
    }

    function fileInfo($file)
    {
        if (isset($file)) {
            return $image = array(
                'name' => $file->getClientOriginalName(),
                'type' => $file->getClientMimeType(),
                'size' => $file->getClientSize(),
                'width' => getimagesize($file)[0],
                'height' => getimagesize($file)[1],
                'extension' => $file->getClientOriginalExtension(),
            );
        } else {
            return $image = array(
                'name' => '0',
                'type' => '0',
                'size' => '0',
                'width' => '0',
                'height' => '0',
                'extension' => '0',
            );
        }
    }

    function fileUpload($file, $destination, $name)
    {
        $upload = $file->move(public_path('/' . $destination), $name);
        return $upload;
    }

    function fileMove($oldPath, $newPath)
    {
        $move = File::move($oldPath, $newPath);
        return $move;
    }

    function fileDelete($path)
    {
        if (!empty($path) && file_exists(public_path('/' . $path))) {
            $delete = unlink(public_path('/' . $path));
            return $delete;
        }
        return false;
    }

    function createdBy()
    {
        return auth()->user()->id;
    }

    function updatedBy()
    {
        return auth()->user()->id;
    }

    function juryGroup($id)
    {
        return JuryGroup::find($id)->name;
    }



    /**
     * video sdk create room id
     */


    /**
     * get sdk token
     */
    function createRoomID()
    {
        return 'a3en-kih1-ls2r'; //for local
        $VIDEOSDK_API_KEY = "9af32487-b9c6-4679-a9f1-c5239c35410b";
        $VIDEOSDK_SECRET_KEY = "aaf9ba47bc165fdcd5a0f57638efd822cee41261a389c6ce438c314c4b3ef429";

        header("Content-type: application/json; charset=utf-8");

        $issuedAt   = new DateTimeImmutable();
        $expire     = $issuedAt->modify('+24 hours')->getTimestamp();

        $payload = [
            'apikey' => $VIDEOSDK_API_KEY,
            'permissions' => array(
                "allow_join", "allow_mod"
            ),
            'iat' => $issuedAt->getTimestamp(),
            'exp' => $expire
        ];


        $jwt = JWT::encode($payload, $VIDEOSDK_SECRET_KEY, 'HS256');

        $request = Http::withHeaders([
            'Authorization' =>  $jwt,
            'Content-Type' => ' application/json'
        ])->post('https://api.videosdk.live/v2/rooms');


        // return $request['roomId']; //for live

    }



    function userPackageWalletStore($type, $event_id, $user_id)
    {

        $walletPayment = new WalletPayment();
        $walletPayment->user_id = $user_id;
        if ($type == "lovebundel") {
            $walletPayment->love_bundel_id = $event_id;
        } else {
            $walletPayment->packages_id = $event_id;
        }
        $walletPayment->save();

        $walletHistory = new WalletHistory();
        if ($type == "lovebundel") {
            $walletHistory->love_bundel_id = $event_id;
        } else {
            $walletHistory->packages_id = $event_id;
        }
        $walletHistory->user_id = $user_id;
        $walletHistory->wallet_payment_id = $walletPayment->id;
        $walletHistory->status = 0;
        $walletHistory->save();

        $userWallet = Wallet::where('user_id', $user_id)->first();

        if ($type == "lovebundel") {
            $loveBundel = LoveReactPrice::where('id', $event_id)->first();

            if ($userWallet) {

                $userWallet->love_points =  $userWallet->love_points + $loveBundel->love_points;
                $userWallet->price = $loveBundel->price;

                $userWallet->save();
            } else {

                $wallet = new Wallet();
                $wallet->user_id = $user_id;
                $wallet->love_points = $loveBundel->love_points;
                $wallet->type = "Basic";
                $wallet->price = $loveBundel->price;
                $wallet->status = 0;
                $wallet->save();
            }
        } else {

            $addPackages = Package::where('id', $event_id)->first();
            if ($userWallet) {

                $userWallet->club_points += $addPackages->club_points;
                $userWallet->love_points += $addPackages->love_points;
                $userWallet->auditions += $addPackages->auditions;
                $userWallet->learning_session += $addPackages->learning_session;
                $userWallet->live_chats += $addPackages->live_chats;
                $userWallet->meetup += $addPackages->meetup;
                $userWallet->greetings += $addPackages->greetings;
                $userWallet->qna += $addPackages->qna;
                $userWallet->type = $addPackages->title;
                $userWallet->price = $addPackages->price;
                $userWallet->save();
            } else {

                $wallet = new Wallet();
                $wallet->user_id = $user_id;
                $wallet->club_points += $addPackages->club_points;
                $wallet->love_points += $addPackages->love_points;
                $wallet->auditions += $addPackages->auditions;
                $wallet->learning_session += $addPackages->learning_session;
                $wallet->live_chats += $addPackages->live_chats;
                $wallet->meetup += $addPackages->meetup;
                $wallet->greetings += $addPackages->greetings;
                $wallet->qna += $addPackages->qna;
                $wallet->type = $addPackages->title;
                $wallet->price = $addPackages->price;
                $wallet->status = 0;
                $wallet->save();
            }
        }
    }

    /**
     * after payment table update
     */

    function resgistationSuccessUpdate($user_id, $type, $event_id, $paymentMethod, $amount = null, $value)
    {
        //live chat regupdate
        if ($type == 'livechat') {
            LiveChatRegUpdate($user_id, $event_id, $paymentMethod);
        }
        // audition regupdate
        if ($type == 'audition') {
            auditionRegUpdate($user_id, $event_id, $paymentMethod);
        }
        //qna
        if ($type == 'qna') {
            qnaRegUpdate($user_id, $event_id, $paymentMethod);
        }
        //learning session
        if ($type == 'learningSession') {
            learningSessionRegUpdate($user_id, $event_id, $paymentMethod);
        }
        //meetup
        if ($type == 'meetup') {
            meetSessionRegUpdate($user_id, $event_id, $paymentMethod);
        }
        //souvenir
        if ($type == 'souvenir') {
            souvenirUpdate($user_id, $event_id, $paymentMethod);
        }
        //marketplace
        if ($type == 'marketplace') {
            marketplaceUpdate($user_id, $event_id, $paymentMethod);
        }
        //package
        if ($type == 'package') {
            packageUpdate($type, $event_id, $user_id);
        }
        //lovebundel
        if ($type == 'lovebundel') {
            packageUpdate($type, $event_id, $user_id);
        }
        //greeting
        if ($type == 'greeting') {
            greetingUpdate($user_id, $event_id, $paymentMethod);
        }
        //generalpost
        if ($type == 'generalpost') {
            generalPostUpdate($event_id, $user_id, $paymentMethod, $amount);
        }
        if ($type == 'auditionCertificate') {
            auditionCertificateUpdate($user_id, $event_id, "PayTm", $amount);
        }
        if ($type == 'loveReact') {
            loveReactPayment($user_id, $event_id, $paymentMethod, $value, $amount);
        }
        if ($type == 'auction') {
            auctionPayment($user_id, $event_id, $paymentMethod);
        }
        if ($type == 'auditionAppeal') {
            auditionAppealPayment($user_id, $event_id, $paymentMethod, $amount);
        }
        if ($type == 'learningCertificate') {
            learningSessionCertificate($user_id, $event_id, $paymentMethod, $amount);
        }
    }



    // Auditions
    function auditionRegUpdate($user_id, $event_id, $method)
    {
        // try {
        $registerEvent = AuditionParticipant::where([['audition_id', $event_id], ['user_id', $user_id]])->first();
        $registerEvent->payment_status = 1;

        $registerEvent->payment_method =  $method;

        $registerEvent->update();
        // } catch (\Throwable $th) {
        //     //throw $th;
        // }
    }

    //auditionCertificateUpdate
    function auditionCertificateUpdate($user_id, $round_info_id, $method, $fee)
    {

        $auditionRoundInfo = AuditionRoundInfo::find($round_info_id);
        try {
            AuditionCertification::create([
                'participant_id' =>  $user_id,
                'audition_id' =>  $auditionRoundInfo->audition_id,
                'round_info_id' =>  $round_info_id,
                'fee' =>  $fee,
                'payment_status' =>  1,
                'payment_method' => $method
            ]);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
    function auditionAppealPayment($user_id, $round_info_id, $method, $fee)
    {

        $auditionRoundInfo = AuditionRoundInfo::find($round_info_id);


        if (AuditionRoundAppealRegistration::where([['user_id', $user_id], ['audition_id',  $auditionRoundInfo->audition_id], ['round_info_id', $round_info_id]])->first()) {
            return response()->json([
                'status' => 200,
                'appealedRegistration' => AuditionRoundAppealRegistration::where([['user_id', $user_id], ['audition_id',  $auditionRoundInfo->audition_id], ['round_info_id', $round_info_id]])->first(),
                'message' => 'User already Registered for this round'
            ]);
        } else {

            $appealedRegistration = AuditionRoundAppealRegistration::create([
                'audition_id' =>  $auditionRoundInfo->audition_id,
                'round_info_id' => $round_info_id,
                'user_id' => $user_id,
                'payment_status' => 1,
                'amount' => $fee,
            ]);
            return response()->json([
                'status' => 200,
                'appealedRegistration' => $appealedRegistration,
            ]);
        }
    }

    //   <================================Love React Payment start==================================>

    function loveReactPayment($user_id, $videoId, $paymentMethod, $reactNum, $amount)
    {
        $auditionRoundInfo = AuditionUploadVideo::with('roundInfo')->where('id', $videoId)->first();

        if (!LoveReactPayment::where([['user_id', $user_id], ['react_num', $reactNum], ['video_id', $videoId]])->exists()) {
            $reactFee = PaidLoveReactPrice::where('loveReact', $reactNum)->first();
            $loveReactPayment = new LoveReactPayment();
            $loveReactPayment->user_id = $user_id;
            $loveReactPayment->video_id = $videoId;
            $loveReactPayment->react_num = $reactNum;
            $loveReactPayment->fee = $reactFee->fee;
            $loveReactPayment->audition_id = $auditionRoundInfo->roundInfo->audition_id;
            $loveReactPayment->round_info_id = $auditionRoundInfo->roundInfo->id;
            $loveReactPayment->status = 1;
            $loveReactPayment->type = $paymentMethod;
            $loveReactPayment->save();
            if ($paymentMethod == "wallet") {
                $lovePoints =  Wallet::where('user_id', auth('sanctum')->user()->id)->first('love_points');
                Wallet::where('user_id', auth('sanctum')->user()->id)->update(['love_points' => $lovePoints->love_points - $reactNum]);
            }
            if ($loveReactPayment) {
                LoveReact::create([
                    'user_id' => $user_id,
                    'video_id' => $videoId,
                    'react_num' => $reactNum,
                    'audition_id' => $auditionRoundInfo->roundInfo->audition_id,
                    'round_info_id' => $auditionRoundInfo->roundInfo->id,
                    'participant_id' => $auditionRoundInfo->user_id,
                    'react_voting_type' => $auditionRoundInfo->roundInfo->has_user_vote_mark == 1 ? 'user_vote' : ($auditionRoundInfo->roundInfo->wildcard == 1 ? 'wildcard' : 'general'),
                    'status' => 1,

                ]);
            }
        }
    }

    function auctionPayment($user_id, $event_id, $method)
    {
        $biddingInfo = Bidding::where([['auction_id', $event_id], ['user_id', $user_id], ['notify_status', 1]])->update([
            'payment_status' => 1,
            'applied_status' => 1
        ]);
    }


    //for live chat
    function LiveChatRegUpdate($user_id, $event_id, $method)
    {
        try {
            $registerEvent = LiveChatRegistration::where([['live_chat_id', $event_id], ['user_id', $user_id]])->first();
            $registerEvent->publish_status = 1;
            $registerEvent->payment_status = 1;
            $registerEvent->payment_method = $method;
            $registerEvent->update();
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    //for qna
    function qnaRegUpdate($user_id, $event_id, $method)
    {
        try {
            $registerEvent = QnaRegistration::where([['qna_id', $event_id], ['user_id', $user_id]])->first();
            $registerEvent->publish_status = 1;
            $registerEvent->payment_status = 1;
            $registerEvent->payment_method = $method;
            $registerEvent->update();
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
    //for learning session
    function learningSessionRegUpdate($user_id, $event_id, $method)
    {
        try {
            $registerEvent = LearningSessionRegistration::where([['learning_session_id', $event_id], ['user_id', $user_id]])->first();
            $registerEvent->publish_status = 1;
            $registerEvent->payment_status = 1;
            $registerEvent->payment_method = $method;
            $registerEvent->update();
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
    //for learning session
    function learningSessionCertificate($user_id, $event_id, $method)
    {

        $registerEvent = LearningSessionCertificate::where([['event_id', $event_id], ['user_id', $user_id]])->first();
        $registerEvent->payment_status = 1;
        $registerEvent->payment_method = $method;
        $registerEvent->update();
    }

    //for meetup
    function meetSessionRegUpdate($user_id, $event_id, $method)
    {
        try {
            $registerEvent = MeetupEventRegistration::where([['meetup_event_id', $event_id], ['user_id', $user_id]])->first();
            $registerEvent->payment_status = 1;
            $registerEvent->payment_method = $method;
            $registerEvent->update();
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
    // Marketplace
    function marketplaceUpdate($user_id, $event_id, $method)
    {
        $registerEvent = MarketplaceOrder::where([['marketplace_id', $event_id], ['user_id', $user_id]])->first();
        $registerEvent->payment_status = 1;
        $registerEvent->payment_method = $method;
        $registerEvent->update();

        $activity = new Activity();
        $activity->user_id = $user_id;
        $activity->event_id = $event_id;
        $activity->event_registration_id = $registerEvent->id;
        $activity->type = 'marketplace';
        $activity->save();
    }

    //for souvenir for mobile
    function souvenirRegUpdate($souvenir_apply_id, $souvenir_create_id, $total_amount, $payment_method)
    {
        try {
            $statusChangeSouvenir = SouvenirApply::find($souvenir_apply_id);
            $statusChangeSouvenir->status = 2;
            $statusChangeSouvenir->save();

            $souvenir = new SouvenirPayment();

            $souvenir->souvenir_create_id = $souvenir_create_id;
            $souvenir->souvenir_apply_id = $souvenir_apply_id;
            $souvenir->user_id = auth('sanctum')->user()->id;
            $souvenir->payment_method = $payment_method;
            $souvenir->payment_status = 1;
            $souvenir->total_amount = $total_amount;
            $souvenir->status = 1;
            $souvenir->save();
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    //for souvenir for web
    function souvenirUpdate($user_id, $event_id, $method)
    {
        try {
            $statusChangeSouvenir = SouvenirApply::find($event_id);
            $statusChangeSouvenir->status = 2;
            $statusChangeSouvenir->save();

            $registerEvent = SouvenirPayment::where([['souvenir_apply_id', $event_id], ['user_id', $user_id]])->first();
            $registerEvent->payment_status = 1;
            $registerEvent->payment_method = $method;
            $registerEvent->update();
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    // Package
    function packageUpdate($type, $event_id, $user_id)
    {
        userPackageWalletStore($type, $event_id, $user_id);
    }

    //greeting update
    function greetingUpdate($user_id, $event_id, $method)
    {
        try {
            $registerEvent = GreetingsRegistration::where([['greeting_id', $event_id], ['user_id', $user_id], ['status',0]])->first();
            $registerEvent->payment_status = 1;
            $registerEvent->status = 1;
            $registerEvent->payment_method = $method;
            $registerEvent->update();

            $activity = new Activity();
            $activity->type = 'greeting';
            $activity->user_id = $user_id;
            $activity->event_id = $event_id;
            $activity->event_registration_id = $registerEvent->id;
            $activity->save();
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    // General post
    function generalPostUpdateMobile($event_id, $user_id, $method, $fee)
    {
        // return 'hit inside update';
        try {

            $generalPostPayment = new GeneralPostPayment();
            $generalPostPayment->post_id = $event_id;
            $generalPostPayment->user_id = auth('sanctum')->user()->id;
            $generalPostPayment->payment_method = $method;
            $generalPostPayment->amount = $fee;
            $generalPostPayment->status = 1;
            $generalPostPayment->save();
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
    function generalPostUpdate($event_id, $user_id, $method, $fee)
    {
        $post = SimplePost::find($event_id);
        GeneralPostPayment::create([
            'post_id' => $event_id,
            'user_id' => $user_id,
            'payment_method' => $method,
            'amount' => $post->fee,
            'status' => 1,
        ]);
    }
    function createSeederActivity($type, $event_registration_id, $user_id, $event_id)
    {
        Activity::create([
            'type' => $type,
            'event_registration_id' => $event_registration_id,
            'user_id' => $user_id,
            'event_id' => $event_id,
        ]);
    }
}
