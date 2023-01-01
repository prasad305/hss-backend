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
use App\Models\Activity;
use App\Models\AuditionCertification;
use App\Models\Audition\AuditionRoundInfo;
use App\Models\Audition\AuditionRoundAppealRegistration;
use App\Models\LearningSessionCertificate;
use App\Models\Bidding;
use Error;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use paytm\paytmchecksum\PaytmChecksum;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use shurjopayv2\ShurjopayLaravelPackage8\Http\Controllers\ShurjopayController;

class PaymentController extends Controller
{
    /**
     * paytm info
     */
    protected $PAYTM_MERCHENT_ID = "iELVJt50414347554560";
    protected $PAYTM_MERCHENT_KEY = "zXhNYVPF4RKIsIIz";
    protected $PAYTM_STAGING_MODE = true;
    protected $PAYTM_WEBSITE_NAME = "WEBSTAGING";
    protected $PAYTM_CALLBACK_URL_WEB = "http://localhost:8000/api/paytm-callback/";
    protected $PAYTM_CALLBACK_URL_MOBILE = "https://securegw-stage.paytm.in/theia/paytmCallback?ORDER_ID=";
    protected $PAYTM_URL_MOBILE = "https://securegw-stage.paytm.in/theia/api/v1/initiateTransaction?mid=";
    protected $PAYTM_URL_WEB = "https://securegw-stage.paytm.in/v3/order/status";


    /**
     * stripe info
     */
    protected $STRIPE_API_KEY = "sk_test_51LtqaHHGaW7JdcX6mntQAvXUaEyc4YYWOHZiH4gVo6VgvQ8gnEMnrX9mtmFboei1LTP0zJ1a6TlNl9v6W0H5mlDI00fPclqtRX";
    protected $STRIPE_PUBLIC_KEY = "pk_test_51LtqaHHGaW7JdcX6i8dovZ884aYW9wHVjPgw214lNBN19ndCHovhZa2A62UzACaTfavZYOzW1nf3uw2FHyf3U6C600GXAjc3Wh";


    /**
     * ipay88 info
     */
    protected $iPAY88_MERCHANT_CODE = "M35354";
    protected $iPAY88_MERCHANT_KEY = "YlZpMYxtcv";
    protected $iPAY88_COUNTRY_CODE = "MYR";
    protected $iPAY88_ENG_URL = "https://payment.ipay88.com.my/epayment/testing/testsignature_256.asp";
    protected $iPAY88_RESPONSE_URL = "http://10.10.10.151:3000/";
    protected $iPAY88_BACKEND_URL = "https://www.tfpbackend.hellosuperstars.com/api/ipay88-success";


    //---------------------paytm start----------
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
        $paytmParams["MID"] = $this->PAYTM_MERCHENT_ID;
        $paytmParams["ORDER_ID"] = Str::orderedUuid();
        $paytmParams['CUST_ID'] = "CUST_001";
        $paytmParams['WEBSITE'] = 'WEBSTAGING';
        $paytmParams['CHANNEL_ID'] = 'WEB';
        $paytmParams['INDUSTRY_TYPE_ID'] = 'Retail';
        $paytmParams['TXN_AMOUNT'] = $request->amount;
        $paytmParams['CALLBACK_URL'] = $this->PAYTM_CALLBACK_URL_WEB . $request->redirectTo . "/" . $user->id . "/" . $request->type . "/" . $request->event_id . "/" . $value;
        $paytmParams['EMAIL'] = $user->email;


        $paytmParams['CHECKSUMHASH'] = PaytmChecksum::generateSignature($paytmParams, $this->PAYTM_MERCHENT_KEY);

        return response()->json($paytmParams);
    }

    //payment success function
    public function paytmCallback(Request $request, $redirectTo, $user_id, $type, $event_id, $value)
    {

        // return  $redirectTo . "-------" . $user_id . "---------" . $type . "-------" . $event_id;
        $isVerifySignature = PaytmChecksum::verifySignature($request->all(), $this->PAYTM_MERCHENT_KEY, $request->CHECKSUMHASH);
        if ($isVerifySignature) {


            $paytmParams = array();

            $paytmParams["body"] = array(
                "mid" => $this->PAYTM_MERCHENT_ID,
                "orderId" => $request->ORDERID,
            );

            $checksum = PaytmChecksum::generateSignature(json_encode($paytmParams["body"]), $this->PAYTM_MERCHENT_KEY);


            $paytmParams["head"] = array(
                "signature"    => $checksum
            );


            $post_data = json_encode($paytmParams);

            /* for Staging */
            // $url = "https://securegw-stage.paytm.in/v3/order/status";

            /* for Production */
            // $url = "https://securegw.paytm.in/v3/order/status";

            $ch = curl_init($this->PAYTM_URL_WEB);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
            $response = curl_exec($ch);
            $result = json_decode($response);
            if ($result->body->resultInfo->resultStatus == 'TXN_SUCCESS') {


                switch ($request->type) {
                    case 'greeting':
                        $greetingRegistration = GreetingsRegistration::find($request->event_id);
                        $event_id = $greetingRegistration->greeting_id;
                        $value = $request->event_id;
                        break;
                    case 'marketplace':
                        $order = MarketplaceOrder::find($request->event_id);
                        $event_id = $order->marketplace_id;
                        $value = $request->event_id;
                        break;

                    default:
                        $event_id =  $request->event_id;
                        break;
                }

                Transaction::create([
                    'user_id' => $user_id,
                    'order_id' => $result->body->orderId,
                    'event' => $request->type,
                    'event_id' => $event_id,
                    'txn_id' => $result->body->txnId,
                    'txn_amount' => $result->body->txnAmount,
                    'currency' => "INR",
                    'bank_name' => $result->body->bankName,
                    'resp_msg' => $result->body->resultInfo->resultMsg,
                    'status' => $result->body->resultInfo->resultStatus,

                ]);


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

        $paytmParams = array();
        $orderId = Str::orderedUuid();

        $paytmParams["body"] = array(
            "requestType"   => "Payment",
            "mid"           =>   $this->PAYTM_MERCHENT_ID,
            "websiteName"   =>  $this->PAYTM_WEBSITE_NAME,
            "orderId"       => $orderId,
            "callbackUrl"   => $this->PAYTM_CALLBACK_URL_MOBILE . $orderId,
            "txnAmount"     => array(
                "value"     =>  $amount . ".00",
                "currency"  => "INR",
            ),
            "userInfo"      => array(
                "custId"    => "CUST_001",
            ),
        );

        $checksum = PaytmChecksum::generateSignature(json_encode($paytmParams["body"]), $this->PAYTM_MERCHENT_KEY);


        $paytmParams["head"] = array(
            "signature"    => $checksum
        );

        $post_data = json_encode($paytmParams);

        /* for Staging */
        $url = $this->PAYTM_URL_MOBILE .   $this->PAYTM_MERCHENT_ID  . "&orderId=" . $orderId;

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
            "mid" =>   $this->PAYTM_MERCHENT_ID,
            "amount" => $amount . ".00",
            "callBackUrl" => $this->PAYTM_CALLBACK_URL_MOBILE,
            "takePaymentMode" => $this->PAYTM_STAGING_MODE
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



            if ($request->modelName == 'audition') {
                return $this->AuditionRegUpdate($user->id, $request->eventId, "PayTm-mobile");
            }

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
            if ($request->modelName == 'greeting') {
                return $this->greetingUpdate($user->id, $request->eventId, "PayTm-mobile");
            }
            if ($request->modelName == 'auditionCertificate') {
                return $this->auditionCertificateUpdate($user->id, $request->eventId, "PayTm-mobile", $request->TXNAMOUNT);
                // $user_id, $round_info_id, $method, $fee
            }

            if ($request->modelName == 'auditionAppeal') {
                // return $request->eventId();

                return $this->auditionAppealPayment($user->id, $request->eventId, "PayTm-mobile", $request->TXNAMOUNT);
                // $user_id, $round_info_id, $method, $fee
            }

            if ($request->modelName == 'auction') {
                return $this->auctionPayment($user->id, $request->eventId, "PayTm-mobile");
            }

            if ($request->modelName == 'learningSessionCertificate') {
                return $this->learningSessionCertificate($user->id, $request->eventId, "PayTm-mobile");
            }





            return "success data received" . "__" . $request->modelName;
        }
    }


    //paytem moble end
    //---------------------paytm end-------------------

    //-------------------stripe start------------------
    public function stripePaymentMake(Request $request)
    {

        Stripe::setApiKey($this->STRIPE_API_KEY);


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
                'public_key' => $this->STRIPE_PUBLIC_KEY
            ];

            return response()->json($output);
        } catch (Error $e) {

            return response()->json(['error' => $e->getMessage()]);
        }
    }

    //stripe mobile
    public function stripePaymentMobile(Request $request)
    {
        \Stripe\Stripe::setApiKey($this->STRIPE_API_KEY);
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
            'description' => $user->id . "_" . $request->event_type . '_' . $request->event_id . "_value_0",
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
            'publishableKey' => $this->STRIPE_PUBLIC_KEY
        ]);
    }

    /**
     * video feed reeact buy
     */
    public function videoFeedReactBuy(Request $request)
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
    //--------------------stripe end------------------------


    //--------------------shurjo pay start------------------------
    public function initiataShurjoPayment(Request $request)
    {
        // return $request->all();

        switch ($request->event_type) {
            case ('loveReact'):

                $value4 = $request->reactNum;

                break;
            case 'greeting':
                $greetingRegistration = GreetingsRegistration::find($request->event_id);
                $value3 = $greetingRegistration->greeting_id;
                $value4 = $greetingRegistration->id;
                break;
            case 'marketplace':
                $order = MarketplaceOrder::find($request->event_id);
                $value3 = $order->marketplace_id;
                $value4 = $order->id;
                break;

            default:
                $value3 = 5;
                $value4 = 0;
        }

        return $request->type;


        $user = auth()->user();
        $shurjopay_service = new ShurjopayController();


        $info = array(
            'currency' => "BDT",
            'amount' => $request->amount,
            'order_id' => Str::orderedUuid(),
            'discsount_amount' => 0,
            'disc_percent' => 0,
            'client_ip' => "192.168.0.1",
            'customer_name' => $user->first_name,
            'customer_phone' => "04545674654",
            'email' => $user->email,
            'customer_address' => "dhaka",
            'customer_city' => "dhaka",
            'customer_state' => "dhaka",
            'customer_postcode' => "1230",
            'customer_country' => "bangladesh",
            'value1' =>  $user->id,
            'value2' => $request->event_type,
            'value3' =>   $value3,
            'value4' => $value4,
        );


        // return 'hello';
        return $shurjopay_service->checkout($info);
    }



    public function successShurjoPayment(Request $request)
    {

        $shurjopay_service = new ShurjopayController();

        $data = json_decode($shurjopay_service->verify($request->order_id));
        $paymentData = $data[0];


        Transaction::create([
            'user_id' => $paymentData->value1,
            'order_id' => $paymentData->order_id,
            'event' => $paymentData->value2,
            'event_id' => $paymentData->value3,
            'txn_id' => $paymentData->order_id,
            'txn_amount' => $paymentData->payable_amount,
            'currency' => "BDT",
            'bank_name' => $paymentData->method,
            'resp_msg' => "shurjo-Payment",
            'status' => $paymentData->transaction_status,

        ]);


        resgistationSuccessUpdate(
            $paymentData->value1,
            $paymentData->value2,
            $paymentData->value3,
            "shurjo-Payment",
            $paymentData->amount,
            $paymentData->value4
        );

        return view("Others.Payment.shurjoPaymentSuccess", compact('paymentData'));

        return $paymentData;
    }

    public function shurjoPaymentStatus($order_id)
    {

        $shurjopay_service = new ShurjopayController();

        $data = json_decode($shurjopay_service->verify($order_id));
        $paymentData = $data[0];



        return $paymentData;
    }


    //--------------------shurjo pay end------------------------

    //-------------------ipay88 start--------------------------
    //ipay88 payment success backend responce
    public function ipay88PaymentSuccess(Request $request)
    {

        $extraData = explode('_', $request->Xfield1);
        $userId = $extraData[0];
        $event_type = $extraData[1];
        $event_id = $extraData[2];
        $extra_value = $extraData[3];

        Transaction::create([
            'user_id' => $userId,
            'order_id' => $request->RefNo,
            'txn_id' => $request->TransId,
            'currency' => $request->Currency,
            'txn_amount' => $request->Amount,
            'status' => $request->Status,
            'event' => $event_type,
            'event_id' =>  $event_id,
            'bank_name' => $request->S_bankname,
            'resp_msg' => $request->Xfield1,

        ]);


        return resgistationSuccessUpdate($userId, $event_type, $event_id, "ipay88", $request->Amount, $extra_value);
    }


    //payment initiate
    public function ipayInitiate($userId, $amount, $eventName, $eventId, $valu, $for = null)
    {



        $refNo =  rand(1000, 999999);
        $amount_str = round(1.00) . "00";
        $amount = round(1.00) . "." . "00";
        $merchantCode =  $this->iPAY88_MERCHANT_CODE;
        $countryCode = $this->iPAY88_COUNTRY_CODE;
        $resUrl = $this->iPAY88_RESPONSE_URL;
        $resUrlBackend = $this->iPAY88_BACKEND_URL;
        $paymentFor = $userId . "_" . $eventName . "_" . $eventId . "_" . $valu;

        $hashString = $this->iPAY88_MERCHANT_KEY . $this->iPAY88_MERCHANT_CODE . $refNo . $amount_str . $this->iPAY88_COUNTRY_CODE . $paymentFor;


        $signature = $this->ipayMakeSignatur($hashString);

        return view('Ipay88.paymentInitiata', compact('refNo', 'amount', 'merchantCode', 'signature', 'countryCode', 'resUrl', 'resUrlBackend', 'paymentFor', 'eventName'));
    }


    //signature make
    public function ipayMakeSignatur($string)
    {
        return hash('sha256', $string);
    }

    //payment success view
    public function iPayPaymentSuccess($order_id)
    {
        $paymentData = Transaction::where('order_id', $order_id)->first();

        return view('Ipay88.iPaymentSuccess', compact('paymentData'));
    }
    //-------------------ipay88 end----------------------------

    public function pocketToken()
    {


        $paytmParams = array();
        $orderId = Str::orderedUuid();

        $paytmParams = array(
            "userId" => env('POCKET_USER_ID'),
            "password" => env('POCKET_PASSWORD'),
            "requestId" =>  $orderId,
            "requestDateTime" => "1625928048482",
            "clientToken" => env('POCKET_CLIENT_TOKEN')
        );


        $post_data = json_encode($paytmParams);


        $ch = curl_init(env('POCKET_ENGINE_URL') . "token");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        $response = curl_exec($ch);

        return  json_decode($response);
    }


    public function getPocketSignature()
    {



        $message = "fasfafaf";
        $privet_key_fil = file_get_contents(public_path('/paymentSecurity/private.pem'));




        $privet_key = openssl_get_privatekey($privet_key_fil, "");

        return $privet_key;

        $signature;
        openssl_free_key($privet_key);
        $result = openssl_sign($message, $signature, $privet_key);

        if (!$result) {
            return "error";
        } else {

            return base64_encode($signature);
        }
    }


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
            $registerEvent->payment_status = 1;
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


        // $registerEvent = LearningSessionRegistration::where([['learning_session_id', $event_id], ['user_id', $user_id]])->first();
        //     $registerEvent->publish_status = 1;
        //     $registerEvent->payment_status = 1;
        //     $registerEvent->payment_method = $method;
        //     $registerEvent->update();



        $registerEvent = LearningSessionRegistration::where([['learning_session_id', $event_id], ['user_id', $user_id]])->first();
        $registerEvent->publish_status = 1;
        $registerEvent->payment_status = 1;
        $registerEvent->payment_method = $method;
        $registerEvent->update();
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

        $registerEvent = MarketplaceOrder::where([['id', $event_id], ['user_id', $user_id]])->first();

        $registerEvent->payment_status = 1;
        $registerEvent->payment_method = $method;
        $registerEvent->status = 1;
        $registerEvent->update();



        $activity = new Activity();
        $activity->user_id = $user_id;
        $activity->event_id = $event_id;
        $activity->event_registration_id = $registerEvent->id;
        $activity->type = 'marketplace';
        $activity->save();
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
            // $registerEvent = GreetingsRegistration::where([['greeting_id', $event_id], ['user_id', $user_id]])->first();
            $registerEvent = GreetingsRegistration::where([['greeting_id', $event_id], ['user_id', $user_id], ['status', 0]])->first();
            // $eventRegistration = GreetingsRegistration::where('user_id', Auth::user()->id)->where('id', $request->greetingId)->first();
            $registerEvent->payment_status = 1;
            $registerEvent->status = 1;
            $registerEvent->payment_method = $method;
            $registerEvent->update();

            $activity = new Activity();
            $activity->type = 'greeting';
            $activity->user_id = $user_id;
            $activity->event_id = $registerEvent->greeting_id;
            $activity->event_registration_id = $registerEvent->id;
            $activity->save();
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

    //auditionCertificateUpdate
    function auditionCertificateUpdate($user_id, $round_info_id, $method, $fee)
    {

        $auditionRoundInfo = AuditionRoundInfo::find($round_info_id);

        AuditionCertification::create([
            'participant_id' =>  $user_id,
            'audition_id' =>  $auditionRoundInfo->audition_id,
            'round_info_id' =>  $round_info_id,
            'fee' =>  $fee,
            'payment_status' =>  1,
            'payment_method' => $method
        ]);
    }

    function auditionAppealPayment($user_id, $round_info_id, $method, $fee)
    {
        // return response()->json([
        //     'status' => 200,
        //     'round_info_id' => $round_info_id,
        //     'fee' => $fee,
        // ]);

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

    function auctionPayment($user_id, $event_id, $method)
    {



        $biddingInfo = Bidding::where([['auction_id', $event_id], ['user_id', $user_id], ['notify_status', 1]])->first();



        $biddingInfo->payment_status = 1;
        $biddingInfo->applied_status = 1;
        $biddingInfo->update();


        // ->update([
        //     'payment_status' => 1,
        //     'applied_status' => 1
        // ]);
        return response()->json([
            'status' => 200,
            'biddingInfo' => $biddingInfo,
        ]);
    }

    function learningSessionCertificate($user_id, $event_id, $method)
    {
        $registerEvent = LearningSessionCertificate::where([['event_id', $event_id], ['user_id', $user_id]])->first();
        $registerEvent->payment_status = 1;
        $registerEvent->payment_method = $method;
        $registerEvent->update();

        return response()->json([
            'status' => 200,
            'LearningSessionCertificate' => $registerEvent,
        ]);
    }

    //   <================================Love React Payment end ==================================>
}
