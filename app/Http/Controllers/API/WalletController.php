<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Package;
use App\Models\WalletHistory;
use App\Models\WalletPayment;
use App\Models\Wallet;
use Illuminate\Support\Facades\Validator;

class WalletController extends Controller
{
    public function package_list(){
        $id = auth('sanctum')->user()->id;
        $allPackages = Package::where('status', 1)->latest()->get();

        return response()->json([
            'status' => 200,
            'allPackages' => $allPackages,
            'userId' => $id,
        ]);
    }
    public function getUserWallet(){
        $id = auth('sanctum')->user()->id;

        $userWallet = Wallet::where('user_id', $id)->first();

  
            return response()->json([
                'status' => 200,
                'userWallet' => $userWallet,
                'userWalletId' => $id,
            ]);

    }

    public function userWalletStore(Request $request){
        //Add walet Payment
        $validator = Validator::make($request->all(),[
            'card_holder_name' => 'required',
            'card_no' => 'required',
            'card_expire_date' => 'required',
            'card_cvv' => 'required',
        ]);

        if($validator->fails())
        {
            return response()->json([
                'validation_errors'=>$validator->errors(),
            ]);
        }else{
            $walletPayment = new WalletPayment();
            $walletPayment->user_id = $request->user_id;
            $walletPayment->packages_id = $request->packages_id;
            $walletPayment->card_holder_name = $request->holder_name;
            $walletPayment->card_no = $request->card_no;
            $walletPayment->card_expire_date = $request->expire_date;
            $walletPayment->card_cvv = $request->cvv;
            $walletPayment->status = 0;
            $walletPayment->save();
    
            $walletHistory = new WalletHistory();
            $walletHistory->packages_id = $request->packages_id;
            $walletHistory->user_id = $request->user_id;
            $walletHistory->wallet_payment_id = $walletPayment->id;
            $walletHistory->status = 0;
            $walletHistory->save();
    
            $userWallet = Wallet::where('user_id', $request->user_id)->first();
    
            $addPackages = Package::where('id', $request->packages_id)->first();
            
            if($userWallet){
                
                $userWallet->club_points += $addPackages->club_points;
                $userWallet->auditions += $addPackages->auditions;
                $userWallet->learning_session += $addPackages->learning_session;
                $userWallet->live_chats += $addPackages->live_chats;
                $userWallet->meetup += $addPackages->meetup;
                $userWallet->greetings += $addPackages->greetings;
                $userWallet->save();
    
                return response()->json([
                    'status' => 200,
                    'message' => 'Payment Added Successfully',
                ]);
            }else{
    
                $wallet = new Wallet();
                $wallet->user_id = $request->user_id;
                $wallet->club_points += $addPackages->club_points;
                $wallet->auditions += $addPackages->auditions;
                $wallet->learning_session += $addPackages->learning_session;
                $wallet->live_chats += $addPackages->live_chats;
                $wallet->meetup += $addPackages->meetup;
                $wallet->greetings += $addPackages->greetings;
                $wallet->status = 0;
                $wallet->save();
    
                return response()->json([
                    'status' => 200,
                    'message' => 'Payment Added Successfully',
                ]);
            } 
        }  
    }

    public function userWalletHistory(){
        $id = auth('sanctum')->user()->id;

        $userWalletHistory = WalletHistory::where('user_id', $id)->latest()->get();
        $userLastWalletHistory = WalletHistory::where('user_id', $id)->latest()->first();

  
            return response()->json([
                'status' => 200,
                'userWalletHistory' => $userWalletHistory,
                'userLastWalletHistory' => $userLastWalletHistory,
            ]);

    }

    public function userFreeWalletStore($packageid, $userId){

        $walletHistory = new WalletHistory();
        $walletHistory->packages_id = $packageid;
        $walletHistory->user_id = $userId;
        $walletHistory->wallet_payment_id = 0;
        $walletHistory->status = 0;
        $walletHistory->save();

        $userWallet = Wallet::where('user_id', $userId)->first();

        $addPackages = Package::where('id', $packageid)->first();
        
        if($userWallet){
            
            $userWallet->club_points += $addPackages->club_points;
            $userWallet->auditions += $addPackages->auditions;
            $userWallet->learning_session += $addPackages->learning_session;
            $userWallet->live_chats += $addPackages->live_chats;
            $userWallet->meetup += $addPackages->meetup;
            $userWallet->greetings += $addPackages->greetings;
            $userWallet->save();

            return response()->json([
                'status' => 200,
                'message' => 'Payment Added Successfully',
            ]);
        }else{

            $wallet = new Wallet();
            $wallet->user_id = $userId;
            $wallet->club_points += $addPackages->club_points;
            $wallet->auditions += $addPackages->auditions;
            $wallet->learning_session += $addPackages->learning_session;
            $wallet->live_chats += $addPackages->live_chats;
            $wallet->meetup += $addPackages->meetup;
            $wallet->greetings += $addPackages->greetings;
            $wallet->status = 0;
            $wallet->save();

            return response()->json([
                'status' => 200,
                'message' => 'Payment Added Successfully',
            ]);
        }   
    }

}
