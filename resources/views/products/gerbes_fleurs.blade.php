@extends('layouts.front.template_front')
@php
    $setting = \App\Models\Setting::first();
    $title = "Gerbes & Fleurs Funéraires". ' :: '. $setting->name_entreprise;
    $title2 = "Gerbes & Fleurs Funéraires";
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

    .fleurs-header {
      background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)),
                  url('https://images.unsplash.com/photo-1587814213271-2c0c2f5f9f0e?ixlib=rb-4.0.3&auto=format&fit=crop&q=80') center/cover;
      height: 58vh;
      min-height: 480px;
      display: flex;
      align-items: center;
      color: white;
      text-align: center;
    }

    .flower-card {
      transition: all 0.4s ease;
      border: none;
      border-radius: 15px;
      overflow: hidden;
      background: white;
      height: 100%;
    }

    .flower-card:hover {
      transform: translateY(-12px);
      box-shadow: 0 15px 35px rgba(0,0,0,0.15);
    }

    .flower-img {
      height: 260px;
      object-fit: cover;
      transition: transform 0.4s ease;
    }

    .flower-card:hover .flower-img {
      transform: scale(1.08);
    }

    .price {
      font-size: 1.45rem;
      font-weight: 700;
      color: #2c3e50;
    }

    .btn-whatsapp {
      background-color: #25D366;
      color: white;
      border-radius: 50px;
    }
  </style>
@endpush

@section('container')
@include("layouts.front.header",['setting'=>$setting])

 <!-- HEADER -->
  <header class="fleurs-header">
    <div class="container">
      <h1 class="display-4 fw-bold mb-3">Gerbes & Fleurs Funéraires</h1>
      <p class="lead fs-4" style="max-width: 720px; margin: 0 auto;">
        Des compositions florales délicates et élégantes<br>
        pour rendre un dernier hommage plein de beauté et de symbolisme.
      </p>
      <a href="#fleurs" class="btn btn-light btn-lg mt-4">Découvrir nos compositions</a>
    </div>
  </header>

  <div class="container py-5" id="fleurs">

    <div class="text-center mb-5">
      <h2 class="display-5 fw-bold">Nos Gerbes et Bouquets</h2>
      <p class="lead text-muted">Fleurs fraîches sélectionnées avec soin pour un hommage digne</p>
    </div>

    <div class="row g-4">

      <!-- Gerbe 1 -->
      @foreach ($produits as $produit)
        <div class="col-lg-4 col-md-6">
            <div class="flower-card shadow-sm">
            <img src="{{ asset($produit->images->first()->path) }}"
                class="flower-img w-100" alt="{{ $produit->name }}">
            <div class="p-4">
                <div class="d-flex justify-content-between align-items-start">
                <h4 class="fw-bold">{{ $produit->name }}</h4>
                <span class="price">{{ $produit->prix }}F CFA</span>
                </div>
                <span class="badge bg-secondary mb-3">{{ $produit->type_product }}</span>
                <p class="text-muted">
                    {!! Str::limit($produit->content, "65", '...') !!}
                </p>
                <a href="{{ route('pompe.details.produit',['slug_produit'=>$produit->slug]) }}" class="btn btn-outline-dark w-100 mb-2">En savoir plus</a>
                <a href="https://wa.me/33612345678?text=Bonjour,%20je%20souhaite%20commander%20la%20Gerbe%20Royale%20de%20Lys"
                target="_blank"
                class="btn btn-whatsapp w-100">
                <i class="fab fa-whatsapp"></i> Commander
                </a>
            </div>
            </div>
        </div>
      @endforeach


    </div>

    <!-- CTA Personnalisation -->
    <div class="text-center mt-5 py-5 bg-white rounded-4">
      <h3 class="mb-3">Vous souhaitez une composition personnalisée ?</h3>
      <p class="lead text-muted mb-4">Nous créons des gerbes sur mesure selon vos souhaits et le message que vous voulez transmettre.</p>
      <a href="https://wa.me/33612345678?text=Bonjour,%20je%20souhaite%20une%20gerbe%20personnalisée"
         target="_blank"
         class="btn btn-success btn-lg">
        <i class="fab fa-whatsapp"></i> Demander une création sur mesure
      </a>
    </div>

  </div>
@endsection

