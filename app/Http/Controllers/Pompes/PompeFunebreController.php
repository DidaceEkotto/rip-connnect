<?php

namespace App\Http\Controllers\Pompes;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class PompeFunebreController extends Controller
{

    public function details_pompe_produit(Request $request)
    {
        $produit = Product::where('slug',$request->slug_produit)->first();
        $others = Product::where('slug','!=',$request->slug_produit)->latest()->take(5)->get();
        return view("products.details",compact('produit','others'));
    }

    public function cercueil(Request $request)
    {
        $produits = Product::where('type_product','cerceuil')->get();
        return view('products.cerceuil',compact('produits'));
    }

    public function marbrerie(Request $request)
    {
        $produits = Product::where('type_product','marbrerie')->get();
        return view('products.marbrerie',compact('produits'));
    }

    public function gerbes_fleurs(Request $request)
    {
        $produits = Product::where('type_product','cerceuil')->get();
        return view('products.gerbes_fleurs',compact('produits'));
    }
}
