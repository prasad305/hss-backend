<?php

namespace App\Http\Controllers\API;

use App\Models\Wallet;
use App\Models\Package;
use Illuminate\Http\Request;
use App\Models\WalletHistory;
use App\Models\WalletPayment;
use App\Models\LoveReactPrice;
use App\Http\Controllers\Controller;
use App\Models\LoveReact;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use function PHPSTORM_META\type;

class WalletController extends Controller
{
    public function package_list()
    {
        $id = auth('sanctum')->user()->id;
        $allPackages = Package::where('status', 1)->latest()->get();
        $loveReactBundel = LoveReactPrice::latest()->get();

        return response()->json([
            'status' => 200,
            'allPackages' => $allPackages,
            'userId' => $id,
            'reactBundel' => $loveReactBundel,
        ]);
    }
    public function love_list()
    {
        $id = auth('sanctum')->user()->id;
        $alllove = LoveReactPrice::latest()->get();


        return response()->json([
            'status' => 200,
            'alllove' => $alllove,
            'userId' => $id,
        ]);
    }

    public function getUserWallet()
    {
        $id = auth('sanctum')->user()->id;

        $userWallet = Wallet::where('user_id', $id)->first();


        return response()->json([
            'status' => 200,
            'userWallet' => $userWallet,
            'userWalletId' => $id,
        ]);
    }

    public function userWalletStore(Request $request)
    {
        // return $request->all();
        //Add walet Payment
        $validator = Validator::make($request->all(), [
            'card_holder_name' => 'required',
            'card_no' => 'required',
            'card_expire_date' => 'required',
            'card_cvv' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'validation_errors' => $validator->errors(),
            ]);
        } else {
            $walletPayment = new WalletPayment();
            $walletPayment->user_id = auth('sanctum')->user()->id;
            if ($request->type == "lovebundel") {
                $walletPayment->love_bundel_id = $request->packages_id;
            } else {
                $walletPayment->packages_id = $request->packages_id;
            }

            $walletPayment->card_holder_name = $request->card_holder_name;
            $walletPayment->card_no = $request->card_no;
            $walletPayment->card_expire_date = $request->card_expire_date;
            $walletPayment->card_cvv = $request->card_cvv;
            $walletPayment->status = 0;
            $walletPayment->save();

            $walletHistory = new WalletHistory();
            if ($request->type == "lovebundel") {
                $walletHistory->love_bundel_id = $request->packages_id;
            } else {
                $walletHistory->packages_id = $request->packages_id;
            }
            $walletHistory->user_id = auth('sanctum')->user()->id;
            $walletHistory->wallet_payment_id = $walletPayment->id;
            $walletHistory->status = 0;
            $walletHistory->save();

            $userWallet = Wallet::where('user_id', auth('sanctum')->user()->id)->first();

            if ($request->type == "lovebundel") {
                $loveBundel = LoveReactPrice::where('id', $request->packages_id)->first();

                if ($userWallet) {

                    $userWallet->love_points += $loveBundel->love_points;
                    $userWallet->price = $loveBundel->price;

                    $userWallet->save();

                    return response()->json([
                        'status' => 200,
                        'message' => 'Payment Added Successfully ',
                        'waletInfo' => $userWallet

                    ]);
                } else {

                    $wallet = new Wallet();
                    $wallet->user_id = auth('sanctum')->user()->id;
                    $wallet->love_points += $loveBundel->love_points;
                    $wallet->type = "Basic";
                    $wallet->price = $loveBundel->price;
                    $wallet->status = 0;
                    $wallet->save();

                    return response()->json([
                        'status' => 200,
                        'message' => 'Payment Added Successfully ',
                        'waletInfo' => $wallet
                    ]);
                }
            } else {

                $addPackages = Package::where('id', $request->packages_id)->first();
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

                    return response()->json([
                        'status' => 200,
                        'message' => 'Payment Added Successfully ',
                        'waletInfo' => $userWallet

                    ]);
                } else {

                    $wallet = new Wallet();
                    $wallet->user_id = auth('sanctum')->user()->id;
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

                    return response()->json([
                        'status' => 200,
                        'message' => 'Payment Added Successfully ',
                        'waletInfo' => $wallet
                    ]);
                }
            }
        }
    }
    public function userWalletLoveStore(Request $request)
    {
        // return $request->all();
        //Add walet Payment
        $validator = Validator::make($request->all(), [
            'card_holder_name' => 'required',
            'card_no' => 'required',
            'card_expire_date' => 'required',
            'card_cvv' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'validation_errors' => $validator->errors(),
            ]);
        } else {
            $walletPayment = new WalletPayment();
            $walletPayment->user_id = auth('sanctum')->user()->id;
            $walletPayment->love_points = $request->loveId;
            $walletPayment->card_holder_name = $request->card_holder_name;
            $walletPayment->card_no = $request->card_no;
            $walletPayment->card_expire_date = $request->card_expire_date;
            $walletPayment->card_cvv = $request->card_cvv;
            $walletPayment->status = 0;
            $walletPayment->save();

            $walletHistory = new WalletHistory();
            $walletHistory->love_points = $request->loveId;
            $walletHistory->user_id = auth('sanctum')->user()->id;
            $walletHistory->wallet_payment_id = $walletPayment->id;
            $walletHistory->status = 0;
            $walletHistory->save();

            $userWallet = Wallet::where('user_id', auth('sanctum')->user()->id)->first();
            $addLove = LoveReactPrice::where('id', $request->loveid)->first();

            if ($userWallet) {

                $userWallet->club_points += $addLove->love_points;
                $userWallet->type = $addLove->title;
                $userWallet->price = $addLove->price;
                $userWallet->save();

                return response()->json([
                    'status' => 200,
                    'message' => 'Payment Added Successfully ',
                    'waletInfo' => $userWallet

                ]);
            } else {

                $wallet = new Wallet();
                $wallet->user_id = auth('sanctum')->user()->id;
                $wallet->club_points += $addLove->love_points;
                $wallet->type = $addLove->title;
                $userWallet->price = $addLove->price;
                $wallet->status = 0;
                $wallet->save();

                return response()->json([
                    'status' => 200,
                    'message' => 'Payment Added Successfully ',
                    'waletInfo' => $wallet
                ]);
            }
        }
    }


    public function userWalletHistory()
    {
        $id = auth('sanctum')->user()->id;

        $userWalletHistory = WalletHistory::where('user_id', $id)->latest()->get();
        $userLastWalletHistory = WalletHistory::where('user_id', $id)->latest()->first();


        return response()->json([
            'status' => 200,
            'userWalletHistory' => $userWalletHistory,
            'userLastWalletHistory' => $userLastWalletHistory,
        ]);
    }

    public function userFreeWalletStore($packageid, $userId)
    {

        $walletHistory = new WalletHistory();
        $walletHistory->packages_id = $packageid;
        $walletHistory->user_id = auth('sanctum')->user()->id;
        $walletHistory->wallet_payment_id = 0;
        $walletHistory->status = 0;
        $walletHistory->save();

        $userWallet = Wallet::where('user_id', $userId)->first();

        $addPackages = Package::where('id', $packageid)->first();

        if ($userWallet) {

            $userWallet->club_points += $addPackages->club_points;
            $userWallet->love_points += $addPackages->love_points;
            $userWallet->auditions += $addPackages->auditions;
            $userWallet->learning_session += $addPackages->learning_session;
            $userWallet->live_chats += $addPackages->live_chats;
            $userWallet->meetup += $addPackages->meetup;
            $userWallet->greetings += $addPackages->greetings;
            $userWallet->qna += $addPackages->qna;
            $userWallet->save();

            return response()->json([
                'status' => 200,
                'message' => 'Payment Added Successfully',
            ]);
        } else {

            $wallet = new Wallet();
            $wallet->user_id = auth('sanctum')->user()->id;
            $wallet->club_points += $addPackages->club_points;
            $wallet->love_points += $addPackages->love_points;
            $wallet->auditions += $addPackages->auditions;
            $wallet->learning_session += $addPackages->learning_session;
            $wallet->live_chats += $addPackages->live_chats;
            $wallet->meetup += $addPackages->meetup;
            $wallet->greetings += $addPackages->greetings;
            $wallet->qna += $addPackages->qna;
            $wallet->status = 0;
            $wallet->save();

            return response()->json([
                'status' => 200,
                'message' => 'Payment Added Successfully',
            ]);
        }
    }
    public function userFreeWalleLovetStore($loveId, $userId)
    {

        $walletHistory = new WalletHistory();
        $walletHistory->love_points = $loveId;
        $walletHistory->user_id = auth('sanctum')->user()->id;
        $walletHistory->wallet_payment_id = 0;
        $walletHistory->status = 0;
        $walletHistory->save();

        $userWallet = Wallet::where('user_id', $userId)->first();

        $addLove = LoveReactPrice::where('id', $loveId)->first();

        if ($userWallet) {

            $userWallet->title = $addLove->title;
            $userWallet->love_points += $addLove->love_points;
            $userWallet->price = $addLove->price;
            $userWallet->save();

            return response()->json([
                'status' => 200,
                'message' => 'Payment Added Successfully',
            ]);
        } else {

            $wallet = new Wallet();
            $wallet->user_id = auth('sanctum')->user()->id;
            $wallet->title = $addLove->title;
            $wallet->love_points += $addLove->love_points;
            $wallet->price = $addLove->price;
            $wallet->status = 0;
            $wallet->save();

            return response()->json([
                'status' => 200,
                'message' => 'Payment Added Successfully',
            ]);
        }
    }
}
