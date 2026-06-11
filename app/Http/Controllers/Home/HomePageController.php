<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Banniere;
use App\Models\Dece;
use App\Models\MotPresident;
use App\Models\Temoignage;
use App\Models\About;
use App\Models\Faq;
use App\Models\Product;
use App\Models\Service;
use Illuminate\Http\Request;

class HomePageController extends Controller
{
    public function index(Request $request)
    {
        $bannieres = Banniere::latest()->get();
        $temoignages = Temoignage::latest()->take(10)->get();
        $dece = Dece::where('promotion','1')->first();
        $temoignages = Temoignage::where('dece_id',$dece->id)->latest()->get();
        $mots = MotPresident::first();
        $about = About::first();
        $services = Service::all();
        $produits = Product::take(3)->get();
        $faqs = Faq::all();
        $morts  = Dece::latest()->get();
        return view('home.index',compact('bannieres','temoignages','dece','temoignages','mots','about','services','produits','faqs','morts'));
    }
}
