<?php

namespace App\Http\Controllers\Deces;

use App\Http\Controllers\Controller;
use App\Models\Dece;
use Illuminate\Http\Request;

class DeceController extends Controller
{
    public function index(Request $request)
    {
        $deces = Dece::latest()->get();
        return view("deces.index",compact("deces"));
    }

    public function details_dece ()
    {
        $dece = Dece::where('identifiant',request('identifiant'))->first();
        return view('deces.details_dece',compact('dece'));
    }
}
