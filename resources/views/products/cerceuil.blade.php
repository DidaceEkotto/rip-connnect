@extends('layouts.front.template_front')
@php
    $setting = \App\Models\Setting::first();
    $title = "Cercueil". ' :: '. $setting->name_entreprise;
    $title2 = "Cercueil";
@endphp
@push("css")

  <style>
    :root {
      --soft-beige: #f8f1e9;
      --deep-blue: #2c3e50;
    }

    body {
      /* font-family: 'Inter', sans-serif; */
      background-color: #f8f1e9;
      color: #2c3e50;
    }

    /* h1, h2, h3 {
      font-family: 'Playfair Display', serif;
    } */

    .shop-header {
      background: linear-gradient(rgba(0,0,0,0.65), rgba(0,0,0,0.65)),
                  url('https://images.unsplash.com/photo-1518199266791-5375a563f8a8?ixlib=rb-4.0.3&auto=format&fit=crop&q=80') center/cover;
      height: 55vh;
      min-height: 450px;
      display: flex;
      align-items: center;
      color: white;
      text-align: center;
    }

    .product-card {
      transition: all 0.4s ease;
      border: none;
      border-radius: 15px;
      overflow: hidden;
      background: white;
      height: 100%;
    }

    .product-card:hover {
      transform: translateY(-12px);
      box-shadow: 0 15px 35px rgba(0,0,0,0.15);
    }

    .product-img {
      height: 260px;
      object-fit: cover;
      transition: transform 0.4s ease;
    }

    .product-card:hover .product-img {
      transform: scale(1.08);
    }

    .price {
      font-size: 1.5rem;
      font-weight: 700;
      color: #2c3e50;
    }

    .btn-details {
      border-radius: 50px;
      padding: 10px 28px;
    }
  </style>
@endpush

@section('container')
@include("layouts.front.header",['setting'=>$setting])

  <!-- JOLI HEADER -->
  <header class="shop-header">
    <div class="container">
      <h1 class="display-4 fw-bold mb-3">Notre Boutique Funéraire</h1>
      <p class="lead fs-4" style="max-width: 700px; margin: 0 auto;">
        Des cercueils et urnes choisis avec soin,<br>
        pour un dernier hommage empreint de dignité et de beauté.
      </p>
      <a href="#products" class="btn btn-light btn-lg mt-4">
        Découvrir nos produits
      </a>
    </div>
  </header>

  <div class="container py-5" id="products">

    <div class="text-center mb-5">
      <h2 class="display-5 fw-bold">Nos Cercueils & Urnes</h2>
      <p class="lead text-muted">Sélection de produits de qualité, disponibles immédiatement</p>
    </div>

    <div class="row g-4">

    @foreach ($produits as $produit)
      <!-- Produit 1 -->
      <div class="col-lg-4 col-md-6">
        <div class="product-card shadow-sm">
          <img src="{{ asset($produit->images->first()->path) }}"
               class="product-img w-100" alt="{{ $produit->name }}">
          <div class="p-4">
            <div class="d-flex justify-content-between align-items-start">
              <h4 class="fw-bold">{{ $produit->name }}</h4>
            </div>
            <span class="price">{{ $produit->prix }}F CFA</span>
            <span class="badge bg-secondary mb-3">{{ $produit->type_product }}</span>
            <p class="text-muted">
                {!! Str::limit($produit->content, '80', '...') !!}
            </p>
            <a href="{{ route('pompe.details.produit',['slug_produit'=>$produit->slug]) }}" class="btn btn-outline-dark btn-details w-100">
              En savoir plus →
            </a>
          </div>
        </div>
      </div>
      <!-- Tu peux ajouter d'autres produits ici -->
    @endforeach

    </div>
  </div>
@endsection

