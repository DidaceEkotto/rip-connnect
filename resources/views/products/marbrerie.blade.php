@extends('layouts.front.template_front')
@php
    $setting = \App\Models\Setting::first();
    $title = "Marbrerie Funéraire". ' :: '. $setting->name_entreprise;
    $title2 = "Marbrerie Funéraire";
@endphp
@push("css")

   <style>
    :root {
      --soft-beige: #f8f1e9;
      --deep-blue: #2c3e50;
    }

    body {
      /* font-family: 'Inter', sans-serif; */
      /* background-color: #f8f1e9; */
      color: #2c3e50;
    }

    /* h1, h2, h3 {
      font-family: 'Playfair Display', serif;
    } */

    .marbrerie-header {
      background: linear-gradient(rgba(0,0,0,0.65), rgba(0,0,0,0.65)),
                  url('https://images.unsplash.com/photo-1582213782179-1f2f0c8e6c8f?ixlib=rb-4.0.3&auto=format&fit=crop&q=80') center/cover;
      height: 60vh;
      min-height: 500px;
      display: flex;
      align-items: center;
      color: white;
      text-align: center;
    }

    .marble-card {
      transition: all 0.4s ease;
      border: none;
      border-radius: 15px;
      overflow: hidden;
      background: white;
      height: 100%;
    }

    .marble-card:hover {
      transform: translateY(-10px);
      box-shadow: 0 15px 35px rgba(0,0,0,0.15);
    }

    .marble-img {
      height: 240px;
      object-fit: cover;
    }

    .btn-contact {
      background-color: #2c3e50;
      color: white;
      border-radius: 50px;
      padding: 12px 35px;
    }
  </style>
@endpush

@section('container')
@include("layouts.front.header",['setting'=>$setting])

  <!-- HEADER -->
  <header class="marbrerie-header">
    <div class="container">
      <h1 class="display-4 fw-bold mb-3">Marbrerie Funéraire</h1>
      <p class="lead fs-4" style="max-width: 750px; margin: 0 auto;">
        Des monuments funéraires réalisés avec soin,<br>
        pour honorer la mémoire de vos proches avec dignité et éternité.
      </p>
      <a href="#realisations" class="btn btn-light btn-lg mt-4">Voir nos réalisations</a>
    </div>
  </header>


  <div class="container py-5">

    <!-- Introduction -->
    <div class="row justify-content-center mb-5">
      <div class="col-lg-10 text-center">
        <p class="lead">
          Nous concevons et réalisons des monuments funéraires sur mesure : pierres tombales, caveaux, stèles, plaques et ornements.
          Chaque création est unique et pensée pour refléter la personnalité et le parcours de votre être cher.
        </p>
        <div class="mt-4">
          <a href="{{ route('contact.index') }}" class="btn btn-contact btn-lg me-3">
            <i class="fab fa-whatsapp"></i> Demander un devis
          </a>
          <a href="#realisations" class="btn btn-outline-dark btn-lg">Découvrir nos modèles</a>
        </div>
      </div>
    </div>

    <hr class="my-5">

    <!-- Réalisations -->
    <section id="realisations">
      <div class="text-center mb-5">
        <h2 class="display-5 fw-bold">Nos Réalisations en Marbrerie</h2>
        <p class="text-muted">Quelques exemples de monuments funéraires que nous avons créés</p>
      </div>

      <div class="row g-4">

        @foreach ($produits as $produit)
            <!-- Monument 1 -->
            <div class="col-lg-4 col-md-6">
            <div class="marble-card shadow-sm">
                <img src="{{ asset($produit->images->first()->path) }}"
                    class="marble-img w-100" alt="Pierre tombale en granit">
                <div class="p-4">
                <h5 class="fw-bold">{{ $produit->name }}</h5>
                <p class="text-muted small">À partir de {{ $produit->prix }}F CFA</p>
                <p class="text-muted">
                    {!! Str::limit($produit->content, '75','...') !!}
                </p>
                <a href="{{ route('pompe.details.produit',['slug_produit'=>$produit->slug]) }}" class="btn btn-outline-dark w-100">Voir les détails</a>
                </div>
            </div>
            </div>
        @endforeach



      </div>
    </section>

    <!-- Services Marbrerie -->
    <div class="mt-6 py-5 bg-white rounded-4 mt-5">
      <div class="container">
        <h3 class="text-center mb-5">Nos Prestations en Marbrerie</h3>
        <div class="row g-4 text-center">
          <div class="col-md-4">
            <div class="p-4">
              <i class="fas fa-chalkboard fa-3x text-muted mb-3"></i>
              <h5>Pierres Tombales</h5>
              <p class="text-muted">Simples, doubles, en forme de livre, cœur, etc.</p>
            </div>
          </div>
          <div class="col-md-4">
            <div class="p-4">
              <i class="fas fa-archway fa-3x text-muted mb-3"></i>
              <h5>Caveaux & Monuments</h5>
              <p class="text-muted">Conception complète de monuments familiaux</p>
            </div>
          </div>
          <div class="col-md-4">
            <div class="p-4">
              <i class="fas fa-tools fa-3x text-muted mb-3"></i>
              <h5>Entretien & Rénovation</h5>
              <p class="text-muted">Nettoyage, gravure supplémentaire, restauration</p>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>

  <!-- CTA Final -->
  <div class="bg-dark text-white py-5 text-center">
    <div class="container">
      <h3>Vous souhaitez un monument personnalisé ?</h3>
      <p class="lead mb-4">Nos artisans marbriers vous accompagnent pour créer un hommage unique.</p>
      <a href="https://wa.me/237{{ $setting->telephone_whatsapp }}?text=Bonjour,%20je%20souhaite%20un%20devis%20pour%20une%20pierre%20tombale"
         target="_blank"
         class="btn btn-success btn-lg">
        <i class="fab fa-whatsapp"></i> Demander un devis gratuit
      </a>
    </div>
  </div>
@endsection

