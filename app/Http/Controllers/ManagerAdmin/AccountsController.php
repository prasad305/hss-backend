<?php

namespace App\Http\Controllers\ManagerAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AccountsController extends Controller
{
    public function index()
    {
        return view('ManagerAdmin.Accounts.index');
    }
}
