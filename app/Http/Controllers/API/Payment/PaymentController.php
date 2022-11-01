<?php

namespace App\Http\Controllers\API\Payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Audition\AuditionParticipant;
use App\Models\Audition\AuditionUploadVideo;
use App\Models\GeneralPostPayment;
use App\Models\GreetingsRegistration;
use App\Models\LearningSession;
use App\Models\LearningSessionRegistration;
use App\Models\LiveChatRegistration;
use App\Models\LoveReact;
use App\Models\LoveReactPayment;
use App\Models\MarketplaceOrder;
use App\Models\MeetupEventRegistration;
use App\Models\QnaRegistration;
use App\Models\SouvenirApply;
use App\Models\SouvenirPayment;
use App\Models\Transaction;
use App\Models\Wallet;
use Error;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use paytm\paytmchecksum\PaytmChecksum;
use Stripe\Stripe;
use Stripe\PaymentIntent;

class PaymentController extends Controller
{
    //---------------------paytm start--------------------------
    //get paytm token
    public function paymentNow(Request $request)
    {

        $user = auth()->user();

        // set Extra parameters
        switch ($request->type) {
            case ('loveReact'):

                $value = $request->reactNum;

                break;

            default:
                $value = 0;
        }



        $paytmParams = array();
        $paytmParams["MID"] = "iELVJt50414347554560";
        $paytmParams["ORDER_ID"] = Str::orderedUuid();
        $paytmParams['CUST_ID'] = "CUST_001";
        $paytmParams['WEBSITE'] = 'WEBSTAGING';
        $paytmParams['CHANNEL_ID'] = 'WEB';
        $paytmParams['INDUSTRY_TYPE_ID'] = 'Retail';
        $paytmParams['TXN_AMOUNT'] = $request->amount;
        $paytmParams['CALLBACK_URL'] = 'http://localhost:8000/api/paytm-callback/' . $request->redirectTo . "/" . $user->id . "/" . $request->type . "/" . $request->event_id . "/" . $value;
        $paytmParams['EMAIL'] = $user->email;


        $paytmParams['CHECKSUMHASH'] = PaytmChecksum::generateSignature($paytmParams, 'zXhNYVPF4RKIsIIz');

        return response()->json($paytmParams);
    }

    //payment success function
    public function paytmCallback(Request $request, $redirectTo, $user_id, $type, $event_id, $value)
    {

        // return  $redirectTo . "-------" . $user_id . "---------" . $type . "-------" . $event_id;
        $isVerifySignature = PaytmChecksum::verifySignature($request->all(), 'zXhNYVPF4RKIsIIz', $request->CHECKSUMHASH);
        if ($isVerifySignature) {


            $paytmParams = array();

            $paytmParams["body"] = array(
                "mid" => "iELVJt50414347554560",
                "orderId" => $request->ORDERID,
            );

            $checksum = PaytmChecksum::generateSignature(json_encode($paytmParams["body"]), "zXhNYVPF4RKIsIIz");


            $paytmParams["head"] = array(
                "signature"    => $checksum
            );


            $post_data = json_encode($paytmParams);

            /* for Staging */
            $url = "https://securegw-stage.paytm.in/v3/order/status";

            /* for Production */
            // $url = "https://securegw.paytm.in/v3/order/status";

            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
            $response = curl_exec($ch);
            $result = json_decode($response);
            if ($result->body->resultInfo->resultStatus == 'TXN_SUCCESS') {
                Transaction::create([
                    'user_id' => $user_id,
                    'order_id' => $result->body->orderId,
                    'event' => $request->type,
                    'event_id' => $request->event_id,
                    'txn_id' => $result->body->txnId,
                    'txn_amount' => $result->body->txnAmount,
                    'currency' => "INR",
                    'bank_name' => $result->body->bankName,
                    'resp_msg' => $result->body->resultInfo->resultMsg,
                    'status' => $result->body->resultInfo->resultStatus,

                ]);

                // //live chat regupdate
                // if ($type == 'livechat') {
                //     $this->LiveChatRegUpdate($user_id, $event_id, "PayTm");
                // }
                // // audition regupdate
                // if ($type == 'audition') {
                //     $this->AuditionRegUpdate($user_id, $event_id, "PayTm");
                // }
                // if ($type == 'qna') {
                //     $this->qnaRegUpdate($user_id, $event_id, "PayTm");
                // }
                // if ($type == 'learningSession') {
                //     $this->learningSessionRegUpdate($user_id, $event_id, "PayTm");
                // }
                // if ($type == 'meetup') {
                //     $this->meetSessionRegUpdate($user_id, $event_id, "PayTm");
                // }
                // if ($type == 'souvenir') {
                //     $this->souvenirUpdate($user_id, $event_id, "PayTm");
                // }
                // if ($type == 'marketplace') {
                //     $this->marketplaceUpdate($user_id, $event_id, "PayTm");
                // }
                // if ($type == 'package') {
                //     $this->packageUpdate($type, $event_id, $user_id);
                // }
                // if ($type == 'lovebundel') {
                //     $this->packageUpdate($type, $event_id, $user_id);
                // }
                // if ($type == 'greeting') {
                //     $this->greetingUpdate($user_id, $event_id, "PayTm");
                // }

                resgistationSuccessUpdate($user_id, $type, $event_id, "paytm", $result->body->txnAmount, $value);
            }
            $orderId = $result->body->orderId;
            $url = "http://localhost:3000/";
            return  redirect()->away($url . $redirectTo);
        } else {
            return "Checksum Mismatched";
        }
    }

    //paytem for mobile start

    public function txnTokenGenerate($amount)
    {
        $mid = "iELVJt50414347554560";
        $websiteName = "WEBSTAGING";
        $mkey = "zXhNYVPF4RKIsIIz";

        //for Staging Environment
        $callBackUrl = "https://securegw-stage.paytm.in/theia/paytmCallback?ORDER_ID=";

        //for Production Environment
        // $callBackUrl = "https://securegw.paytm.in/theia/paytmCallback?ORDER_ID=";


        $paytmParams = array();
        $orderId = Str::orderedUuid();

        $paytmParams["body"] = array(
            "requestType"   => "Payment",
            "mid"           =>  $mid,
            "websiteName"   =>  $websiteName,
            "orderId"       => $orderId,
            "callbackUrl"   => "https://securegw-stage.paytm.in/theia/paytmCallback?ORDER_ID=" . $orderId,
            "txnAmount"     => array(
                "value"     =>  $amount . ".00",
                "currency"  => "INR",
            ),
            "userInfo"      => array(
                "custId"    => "CUST_001",
            ),
        );

        $checksum = PaytmChecksum::generateSignature(json_encode($paytmParams["body"]), $mkey);


        $paytmParams["head"] = array(
            "signature"    => $checksum
        );

        $post_data = json_encode($paytmParams);

        /* for Staging */
        $url = "https://securegw-stage.paytm.in/theia/api/v1/initiateTransaction?mid=" .  $mid  . "&orderId=" . $orderId;

        /* for Production */
        // $url = "https://securegw.paytm.in/theia/api/v1/initiateTransaction?mid=YOUR_MID_HERE&orderId=ORDERID_98765";

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        $response = curl_exec($ch);
        return response()->json([
            "Token_data" => json_decode($response),
            "orderId" => $orderId,
            "mid" =>  $mid,
            "amount" => $amount . ".00",
            "callBackUrl" => $callBackUrl
        ]);
    }

    public function paytmPaymentSuccessForMobile(Request $request)
    {
        // return $request->all();
        $user = auth()->user();
        if ($request->STATUS == 'TXN_SUCCESS') {
            Transaction::create([
                'user_id' => $user->id,
                'order_id' => $request->ORDERID,
                'txn_id' => $request->TXNID,
                'event' => $request->modelName,
                'event_id' => $request->eventId,
                'txn_amount' => $request->TXNAMOUNT,
                'currency' => "INR",
                'bank_name' => $request->BANKNAME,
                'resp_msg' => "mobile-payment",
                'status' => $request->STATUS,

            ]);




            //live chat regupdate
            if ($request->modelName == 'livechat') {
                return $this->LiveChatRegUpdate($user->id, $request->eventId, "PayTm-mobile");
            }
            if ($request->modelName == 'qna') {
                return $this->qnaRegUpdate($user->id, $request->eventId, "PayTm-mobile");
            }
            if ($request->modelName == 'learningSession') {
                return $this->learningSessionRegUpdate($user->id, $request->eventId, "PayTm-mobile");
            }

            if ($request->modelName == 'meetup') {
                return $this->meetSessionRegUpdate($user->id, $request->eventId, "PayTm-mobile");
            }

            if ($request->modelName == 'souvenir') {
                return $this->souvenirRegUpdate($request->souvenir_apply_id, $request->souvenir_create_id, $request->TXNAMOUNT, "PayTm-mobile");
            }
            if ($request->modelName == 'generalpost') {
                return $this->generalPostUpdateMobile($request->eventId, $user->id, "PayTm-mobile", $request->TXNAMOUNT);
            }
            if ($request->modelName == 'videoFeed') {
                return $this->loveReactPaymentMobile($user->id, $request->videoId, $request->reactNum, $request->modelName, $request->TXNAMOUNT);
            }
            if ($request->modelName == 'marketplace') {
                return $this->marketplaceUpdate($user->id, $request->eventId, "PayTm-mobile");
            }


            return "success data received" . "__" . $request->modelName;
        }
    }

    /**
     * video feed reeact buy
     */
    public function videoFeedReactStripe(Request $request)
    {
        $user = auth()->user();
        // return loveReactPaymentMobile($user->id, $request->videoId, $request->reactNum, $request->modelName, $request->TXNAMOUNT);
        return $this->loveReactPaymentMobile(
            $user->id,
            $request->videoId,
            $request->reactNum,
            $request->modelName,
            $request->amount
        );
    }



    //paytem moble end
    //---------------------paytm end--------------------------


    //-------------------stripe start------------------------
    public function stripePaymentMake(Request $request)
    {
        $public_key = env('STRIPE_PUBLIC_KEY');
        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));


        $user = auth()->user();

        // set Extra parameters
        switch ($request->event_type) {
            case ('loveReact'):

                $value = $request->reactNum;

                break;

            default:
                $value = 0;
        }

        // Use an existing Customer ID if this is a returning customer.
        $customer = \Stripe\Customer::create();

        try {
            $paymentIntent = PaymentIntent::create([
                'amount' =>  $request->amount * 100,
                'customer' => $customer->id,
                'currency' => 'usd',
                'description' =>  $user->id . "_" . $request->event_type . '_' . $request->event_id . '_' . "value" .  '_' . $value,
                'receipt_email' => $user->email,
                'automatic_payment_methods' => [
                    'enabled' => true,
                ],
            ]);

            $output = [
                'clientSecret' => $paymentIntent->client_secret,
                'public_key' => $public_key
            ];

            return response()->json($output);
        } catch (Error $e) {

            return response()->json(['error' => $e->getMessage()]);
        }
    }

    //stripe mobile
    public function stripePaymentMobile(Request $request)
    {
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
        // Use an existing Customer ID if this is a returning customer.
        $user = auth()->user();
        $customer = \Stripe\Customer::create();
        $ephemeralKey = \Stripe\EphemeralKey::create(
            [
                'customer' => $customer->id,
            ],
            [
                'stripe_version' => '2022-08-01',
            ]
        );
        $paymentIntent = \Stripe\PaymentIntent::create([
            'amount' => $request->amount * 100,
            'currency' => 'usd',
            'description' => $user->id . "_" . $request->event_type . '_' . $request->event_id,
            'customer' => $customer->id,
            'automatic_payment_methods' => [
                'enabled' => 'true',
            ],
        ]);

        return response()->json([
            'paymentIntent' => $paymentIntent->client_secret,
            'ephemeralKey' => $ephemeralKey->secret,
            'customer' => $customer->id,
            'status' => 200,
            'publishableKey' => env('STRIPE_PUBLIC_KEY')
        ]);
    }

    public function stripePaymentSuccess($event_id, $event_type)
    {
        Transaction::create([
            'user_id' => auth()->user()->id,
            'resp_msg' => "stripe-payment",
            'status' => "paid",
        ]);
    }


    //--------------------stripe end---------------------------
    // Auditions
    public function AuditionRegUpdate($user_id, $event_id, $method)
    {
        try {
            $registerEvent = AuditionParticipant::where([['audition_id', $event_id], ['user_id', $user_id]])->first();
            $registerEvent->payment_status = 1;
            $registerEvent->payment_method = $method;
            $registerEvent->update();
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    //for live chat
    public function LiveChatRegUpdate($user_id, $event_id, $method)
    {
        try {
            $registerEvent = LiveChatRegistration::where([['live_chat_id', $event_id], ['user_id', $user_id]])->first();
            $registerEvent->publish_status = 1;
            $registerEvent->payment_method = $method;
            $registerEvent->update();
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    //for qna
    public function qnaRegUpdate($user_id, $event_id, $method)
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
    public function learningSessionRegUpdate($user_id, $event_id, $method)
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

    //for meetup
    public function meetSessionRegUpdate($user_id, $event_id, $method)
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
    public function marketplaceUpdate($user_id, $event_id, $method)
    {
        try {
            $registerEvent = MarketplaceOrder::where([['marketplace_id', $event_id], ['user_id', $user_id]])->first();
            $registerEvent->payment_status = 1;
            $registerEvent->payment_method = $method;
            $registerEvent->update();
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    //for souvenir for mobile
    public function souvenirRegUpdate($souvenir_apply_id, $souvenir_create_id, $total_amount, $payment_method)
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
    public function souvenirUpdate($user_id, $event_id, $method)
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
    public function packageUpdate($type, $event_id, $user_id)
    {
        userPackageWalletStore($type, $event_id, $user_id);
    }

    //greeting update
    public function greetingUpdate($user_id, $event_id, $method)
    {
        try {
            $registerEvent = GreetingsRegistration::where([['greeting_id', $event_id], ['user_id', $user_id]])->first();
            $registerEvent->payment_status = 1;
            $registerEvent->status = 2;
            $registerEvent->payment_method = $method;
            $registerEvent->update();
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    // General post
    public function generalPostUpdateMobile($event_id, $user_id, $method, $fee)
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

    public function loveReactPaymentMobile($user_id, $videoId, $reactNum, $type, $fee)
    {
        $auditionRoundInfo = AuditionUploadVideo::with('roundInfo')->where('id', $videoId)->first();

        if (!LoveReactPayment::where([['user_id', $user_id], ['react_num', $reactNum], ['video_id', $videoId]])->exists()) {

            try {
                $loveReactPayment = new LoveReactPayment();
                $loveReactPayment->user_id = $user_id;
                $loveReactPayment->video_id = $videoId;
                $loveReactPayment->react_num = $reactNum;
                $loveReactPayment->status = 1;

                $loveReactPayment->audition_id = $auditionRoundInfo->roundInfo->audition_id;
                $loveReactPayment->round_info_id = $auditionRoundInfo->roundInfo->id;
                $loveReactPayment->type = $type;
                $loveReactPayment->save();
                if ($loveReactPayment) {
                    $loveReact = new LoveReact();
                    $loveReact->user_id = $user_id;
                    $loveReact->video_id = $videoId;
                    $loveReact->react_num = $reactNum;
                    $loveReact->status = 1;
                    $loveReact->audition_id = $auditionRoundInfo->roundInfo->audition_id;
                    $loveReact->round_info_id = $auditionRoundInfo->roundInfo->id;
                    $loveReact->participant_id = $auditionRoundInfo->user_id;
                    $loveReact->react_voting_type = $auditionRoundInfo->roundInfo->has_user_vote_mark == 1 ? 'user_vote' : ($auditionRoundInfo->roundInfo->wildcard == 1 ? 'wildcard' : 'general');
                    $loveReact->save();
                }
            } catch (\Throwable $th) {
                return $th;
            }
        }
    }

    //   <================================Love React Payment end ==================================>
}
