<?php

namespace App\Http\Controllers\Morgue;

use App\Http\Controllers\Controller;
use App\Models\Morgue;
use Illuminate\Http\Request;

class MorqueController extends Controller
{
    public function index(Request $request)
    {
        $morgues = Morgue::all();
        return view('morgue.index',compact('morgues'));
    }
    public function morgue_details(Request $request)
    {
        $morgue = Morgue::where('slug',$request->slug)->first();
        return view('morgue.details',compact('morgue'));
    }
}
