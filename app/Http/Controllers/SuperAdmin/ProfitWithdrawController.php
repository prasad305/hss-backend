<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\ProfitWalletWithdrawHistory;
use Illuminate\Http\Request;

class ProfitWithdrawController extends Controller
{
    public function index()
    {
        $withdrawHistory = ProfitWalletWithdrawHistory::with('users')->get();

        return view('SuperAdmin.ProfitWithdraw.index', compact('withdrawHistory'));
    }
    public function store(Request $request, $id)
    {

        $withdrawHistory = ProfitWalletWithdrawHistory::find($id)->update(['bank_txn_id' => $request->bank_txn_id]);

        return redirect()->back();
    }
}
