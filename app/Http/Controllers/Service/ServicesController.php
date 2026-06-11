<?php

namespace App\Http\Controllers\Service;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServicesController extends Controller
{
    public function index(Request $request)
    {
        $services = Service::all();
        return view('services.index',compact('services'));
    }

    public function details_services(Request $request)
    {
        $service = Service::where('slug',$request->slug)->first();
        $other_services = Service::where("slug",'!=',$request->slug)->get();
        return view('services.details_services',compact('service','other_services'));
    }
}
