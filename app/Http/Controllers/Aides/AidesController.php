<?php

namespace App\Http\Controllers\Aides;

use App\Http\Controllers\Controller;
use App\Models\Aide;
use Illuminate\Http\Request;

class AidesController extends Controller
{
    public function index(Request $request)
    {
        $aides = Aide::all();
        return view('aides.index',compact('aides'));
    }
}
