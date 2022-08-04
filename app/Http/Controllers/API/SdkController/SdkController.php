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
     * get sdk token
     */
    public function getToken()
    {

        header("Content-type: application/json; charset=utf-8");

        $issuedAt   = new DateTimeImmutable();
        $expire     = $issuedAt->modify('+24 hours')->getTimestamp();

        $payload = [
            'apikey' => $this->VIDEOSDK_API_KEY,
            'permissions' => array(
                "allow_join", "allow_mod"
            ),
            'iat' => $issuedAt->getTimestamp(),
            'exp' => $expire
        ];


        $jwt = JWT::encode($payload, $this->VIDEOSDK_SECRET_KEY, 'HS256');

        return json_encode(array("token" => $jwt));
    }

    /**
     * create meeting id
     */
    public function createMeetingId(Request $request)
    {
        $request = Http::withHeaders([
            'Authorization' => $request->token,
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
}
