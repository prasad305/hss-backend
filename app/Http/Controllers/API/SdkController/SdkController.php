<?php

namespace App\Http\Controllers\API\SdkController;

use App\Http\Controllers\Controller;
use DateTimeImmutable;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SdkController extends Controller
{
    protected $VIDEOSDK_API_KEY = "9af32487-b9c6-4679-a9f1-c5239c35410b";
    protected $VIDEOSDK_SECRET_KEY = "aaf9ba47bc165fdcd5a0f57638efd822cee41261a389c6ce438c314c4b3ef429";
    protected $VIDEOSDK_API_ENDPOINT = "https://api.videosdk.live";

    /**
     * get sdk token user
     */

    public function getTokenUser()
    {



        header("Content-type: application/json; charset=utf-8");

        $issuedAt   = new DateTimeImmutable();
        $expire     = $issuedAt->modify('+24 hours')->getTimestamp();


        $payload = [
            'apikey' => $this->VIDEOSDK_API_KEY,
            'permissions' => array("ask_join"),
            'iat' => $issuedAt->getTimestamp(),
            'exp' => $expire
        ];


        $jwt = JWT::encode($payload, $this->VIDEOSDK_SECRET_KEY, 'HS256');

        return json_encode(array("token" => $jwt));
    }

    /**
     * get sdk token admin
     */
    public function getToken()
    {



        header("Content-type: application/json; charset=utf-8");

        $issuedAt   = new DateTimeImmutable();
        $expire     = $issuedAt->modify('+24 hours')->getTimestamp();


        $payload = [
            'apikey' => $this->VIDEOSDK_API_KEY,
            'permissions' => array("allow_join", "allow_mod"),
            'iat' => $issuedAt->getTimestamp(),
            'exp' => $expire
        ];


        $jwt = JWT::encode($payload, $this->VIDEOSDK_SECRET_KEY, 'HS256');

        return json_encode(array("token" => $jwt));
    }



    public function RemoveParticipantsMeeting(Request $request)
    {
        $getToken = $this->getToken();

        $curl = curl_init();
        $data = array(
            "participantId" => $request->participantId,
            "roomId" => $request->roomId,

        );
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.videosdk.live/v2/sessions/participants/remove",
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_HTTPHEADER => array(
                'Authorization:' . json_decode($getToken)->token,
                'Content-Type: application/json'
            ),
            CURLOPT_POSTFIELDS => json_encode($data),
        ));
        $response = curl_exec($curl);
        curl_close($curl);

        if ($response) {
            return response()->json([
                'status' => 200,
                'message' =>  $response,
            ]);
        }
    }

    /**
     * create meeting id
     */
    public function createMeetingId($token)
    {
        $request = Http::withHeaders([
            'Authorization' => $token,
            'Content-Type' => ' application/json'
        ])->post('https://api.videosdk.live/v2/rooms');


        return $request['roomId'];
    }

    /**
     * Validate a Room
     */
    public function roomValidate(Request $request, $roomId)
    {
        $request = Http::withHeaders([
            'Authorization' => $request->token,
            'Content-Type' => ' application/json'
        ])->get('https://api.videosdk.live/v2/rooms/validate/' . $roomId);


        return $request;
    }
    /**
     * end session
     */
    public function roomRoomEnd($roomId, $token)
    {
        //   sleep(3000);
        $room_id = json_encode(array("roomId" => $roomId));

        $request = Http::withHeaders([
            'Authorization' => $token,
            'Content-Type' => ' application/json'
        ])->post('https://api.videosdk.live/v2/sessions/end', [
            'roomId' => $roomId,
        ]);

        return $request;
    }

    /**
     * fatch session
     */
    public function getSdkAlluser($roomId)
    {

        $getToken = $this->getToken();

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.videosdk.live/v2/sessions/?roomId=" . $roomId,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization:' . json_decode($getToken)->token,
                'Content-Type: application/json'
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        // return response()->json([
        //     'status' => 200,
        //     'data' =>  json_decode,
        // ]);
        if ($response) {
            $allsession = json_decode($response)->data;
            $singleSession = $allsession[0]->participants;

            return response()->json([
                'status' => 200,
                'participants' => $singleSession
            ]);
        }
    }

    /**
     * meeting screen record
     */
    public function meetingRecordStart($roomId)
    {
        $getToken = $this->getToken();

        $curl = curl_init();
        $data = array(
            "roomId" => $roomId,
            "templateUrl" => "",
            "config" => "",
            "webhookUrl" => "",
            "awsDirPath" => "s3path",
        );
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.videosdk.live/v2/recordings/start",
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_HTTPHEADER => array(
                'Authorization:' . json_decode($getToken)->token,
                'Content-Type: application/json'
            ),
            CURLOPT_POSTFIELDS => json_encode($data),
        ));
        $response = curl_exec($curl);
        curl_close($curl);

        return $response;
    }

    /**
     * meeting record stop
     */
    public function meetingRecordStop($roomId)
    {
        $getToken = $this->getToken();
        $curl = curl_init();
        $data = array(
            "roomId" => $roomId,
        );
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.videosdk.live/v2/recordings/end",
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_HTTPHEADER => array(
                'Authorization:' . json_decode($getToken)->token,
                'Content-Type: application/json'
            ),
            CURLOPT_POSTFIELDS => json_encode($data),
        ));
        $response = curl_exec($curl);
        curl_close($curl);

        return  $response;
    }

    /**
     * meeting record download
     */
    public function meetingRecordDownlode($roomId)
    {
        $getToken = $this->getToken();
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.videosdk.live/v2/recordings?roomId=" . $roomId,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization:' . json_decode($getToken)->token,
                'Content-Type: application/json'
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return response()->json([
            'status' => 200,
            'saveVideo' => json_decode($response)->data
        ]);
    }
}
