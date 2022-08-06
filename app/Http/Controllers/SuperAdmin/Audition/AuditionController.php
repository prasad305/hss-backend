<?php

namespace App\Http\Controllers\SuperAdmin\Audition;

use App\Http\Controllers\Controller;
use App\Models\Audition\Audition;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AuditionController extends Controller
{

    public function auditionList()
    {
        $auditions = Audition::orderBy('id', 'DESC')->get();

        return view('SuperAdmin.audition.index', compact('auditions'));
    }
}
