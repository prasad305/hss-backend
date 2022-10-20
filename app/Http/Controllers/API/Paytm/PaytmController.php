<?php

namespace App\Http\Controllers\API\Paytm;

use App\Http\Controllers\Controller;
use App\Models\Audition\AuditionParticipant;
use Illuminate\Http\Request;
use App\Models\LearningSession;
use App\Models\LearningSessionRegistration;
use App\Models\LiveChatRegistration;
use App\Models\MeetupEventRegistration;
use App\Models\QnaRegistration;
use App\Models\SouvenirApply;
use App\Models\SouvenirPayment;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use paytm\paytmchecksum\PaytmChecksum;

class PaytmController extends Controller
{
    //get paytm token
    public function paymentNow(Request $request)
    {

        $user = auth()->user();

        $paytmParams = array();
        $paytmParams["MID"] = "iELVJt50414347554560";
        $paytmParams["ORDER_ID"] = Str::orderedUuid();
        $paytmParams['CUST_ID'] = "CUST_001";
        $paytmParams['WEBSITE'] = 'WEBSTAGING';
        $paytmParams['CHANNEL_ID'] = 'WEB';
        $paytmParams['INDUSTRY_TYPE_ID'] = 'Retail';
        $paytmParams['TXN_AMOUNT'] = $request->amount;
        $paytmParams['CALLBACK_URL'] = 'http://localhost:8000/api/paytm-callback/' . $request->redirectTo . "/" . $user->id . "/" . $request->type . "/" . $request->event_id;
        $paytmParams['EMAIL'] = $user->email;


        $paytmParams['CHECKSUMHASH'] = PaytmChecksum::generateSignature($paytmParams, 'zXhNYVPF4RKIsIIz');

        return response()->json($paytmParams);
    }

    //payment success function
    public function paytmCallback(Request $request, $redirectTo, $user_id, $type, $event_id)
    {
        // return $request->all();
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

                //live chat regupdate
                if ($type == 'livechat') {
                    $this->LiveChatRegUpdate($user_id, $event_id, "PayTm");
                }
                // audition regupdate
                if ($type == 'audition') {
                    $this->AuditionRegUpdate($user_id, $event_id, "PayTm");
                }
                if ($type == 'qna') {
                    $this->qnaRegUpdate($user_id, $event_id, "PayTm");
                }
                if ($type == 'learningSession') {
                    $this->learningSessionRegUpdate($user_id, $event_id, "PayTm");
                }
                if ($type == 'meetup') {
                    $this->meetSessionRegUpdate($user_id, $event_id, "PayTm");
                }
            }
            $orderId = $result->body->orderId;
            $url = "http://localhost:3000/";
            return  redirect()->away($url . $redirectTo);
        } else {
            return "Checksum Mismatched";
        }
    }

    // for mobile app

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


            return "success data recived" . "__" . $request->modelName;
        }
    }




    // mobile payment end


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

    //for souvenir
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
}
