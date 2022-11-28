<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Virtualtour;

class VirtualtourController extends Controller
{
    public function virtualtourforweb()
    {
        $data = Virtualtour::orderBy('id', 'DESC')->where('type','web')->first();

        return response()->json([
            'status' => 200,
            'data' => $data,
            'message' => 'Virtual Tour Added Successfully',
        ]);
    }
    public function virtualtourforphone()
    {
        $data = Virtualtour::orderBy('id', 'DESC')->where('type','phone')->first();

        return response()->json([
            'status' => 200,
            'data' => $data,
            'message' => 'Virtual Tour Added Successfully',
        ]);
    }
}
