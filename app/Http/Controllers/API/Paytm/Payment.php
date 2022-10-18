<?php

namespace App\Http\Controllers\API\Paytm;

use App\Http\Controllers\Controller;
use App\Models\LiveChatRegistration;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use paytm\paytmchecksum\PaytmChecksum;

class Payment extends Controller
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
            }
            $orderId = $result->body->orderId;
            $url = "http://localhost:3001/";
            return  redirect()->away($url . $redirectTo);
        } else {
            return "Checksum Mismatched";
        }
    }

    //form live chat
    public function LiveChatRegUpdate($user_id, $event_id, $method)
    {

        $registerEvent = LiveChatRegistration::where([['live_chat_id', $event_id], ['user_id', $user_id]])->first();
        $registerEvent->publish_status = 1;
        $registerEvent->payment_method = $method;
        $registerEvent->update();
    }
}
