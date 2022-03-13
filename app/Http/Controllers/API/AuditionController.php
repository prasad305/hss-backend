<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Audition\Audition;
use Illuminate\Http\Request;

class AuditionController extends Controller
{
    
    public function index()
    {
        //
    }

    public function adminStatus(){
        $live = Audition::where([['admin_id', auth('sanctum')->user()->id], ['status', 1]])->count();
        $pending = Audition::where([['admin_id', auth('sanctum')->user()->id], ['status', 0]])->count();
        return response()->json([
            'status' => 200,
            'live' => $live,
            'pending' => $pending,
        ]);
    }


    public function adminPendings(){
        $pendings = Audition::where([['admin_id', auth('sanctum')->user()->id], ['status', 0]])->get();
        return response()->json([
            'status' => 200,
            'pendings' => $pendings,
        ]);
    }

    
    public function create()
    {
        //
    }

 
    public function store(Request $request)
    {
        //
    }

  
    public function show($id)
    {
        //
    }

    
    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }

  
    public function destroy($id)
    {
        //
    }
}
