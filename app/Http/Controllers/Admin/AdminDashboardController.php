<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\About;
use App\Models\Aide;
use App\Models\Dece;
use App\Models\Entreprise;
use App\Models\Morgue;
use App\Models\MotPresident;
use App\Models\Photo;
use App\Models\Product;
use App\Models\Service;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{

    public function index(Request $request)
    {
        return view('admin.dashboard');
    }
    public function banniere(Request $request)
    {
        return view('admin.banniere');
    }

    public function dece_liste(Request $request)
    {
        $deces = Dece::all();
        return view('admin.liste_deces',compact('deces'));
    }

    public function dece_add(Request $request)
    {
        return view('admin.add_dece');
    }

    public function dece_edition(Request $request)
    {
        $dece = Dece::find($request->id);
        return view('admin.edite_deces',compact('dece'));
    }

    public function dece_photos (Request $request)
    {
        $dece = Dece::find($request->id);
        $allPhotos = Photo::where('dece_id',$dece->id)->get();
        return view('admin.dece_photos',compact('dece','allPhotos'));
    }

    public function dece_programme (Request $request)
    {
        $dece = Dece::find($request->id);
        return view('admin.dece_programme',compact('dece'));
    }

    public function services()
    {
        $services = Service::all();
        return view('admin.services', compact('services'));
    }
    public function services_ajouter(Request $request)
    {
        return view('admin.services_ajouter');
    }
    public function services_modifier(Request $request)
    {
        $service = Service::find($request->id);
        return view('admin.services_modifier',compact('service'));
    }

    public function partenaire_liste()
    {
        $entreprises = Entreprise::all();
        return view('admin.partenaire_liste', compact('entreprises'));
    }

    public function partenaire_ajouter()
    {
        return view('admin.partenaire_ajouter');
    }

    public function produits_liste(Request $request)
    {
        $produits = Product::all();
        return view('admin.produits_liste',compact('produits'));
    }

    public function produits_ajouter(Request $request)
    {
        return view('admin.produits_ajouter');
    }

    public function produits_modifier(Request $request)
    {
        $produit = Product::find($request->id);
        return view('admin.produits_modifier',compact('produit'));
    }

    public function faqs (Request $request)
    {
        return view('admin.faqs');
    }

    public function aides_list()
    {
        $aides = Aide::all();
        return view('admin.aides_list',compact('aides'));
    }

    public function aides_create()
    {
        return view('admin.aides_create');
    }

    public function aides_edite(Request $request)
    {
        $aide = Aide::find($request->id);
        return view('admin.aides_edite',compact('aide'));
    }

    public function a_propos()
    {
        $about = About::first();
        return view('admin.a_propos',compact('about'));
    }

    public function morgues()
    {
        $morgues = Morgue::all();
        return view('admin.morgues',compact('morgues'));
    }
    public function morgues_create()
    {
        return view('admin.morgues_create');
    }
    public function morgues_edite(Request $request)
    {
        $morgue = Morgue::find($request->id);
        return view('admin.morgues_edite',compact('morgue'));
    }
    public function mot_du_president()
    {
        $mots = MotPresident::first();
        return view('admin.mot_du_president',compact('mots'));
    }
}
