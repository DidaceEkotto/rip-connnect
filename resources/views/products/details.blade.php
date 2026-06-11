@extends('layouts.front.template_front')
@php
    $setting = \App\Models\Setting::first();
    $title = $produit->name. ' :: '. $setting->name_entreprise;
    $title2 = $produit->name;
@endphp

@push("css")
 <style>
    :root {
      --soft-beige: #f8f1e9;
      --deep-blue: #2c3e50;
    }

    body {
      font-family: 'Inter', sans-serif;
      background-color: #f8f1e9;
      color: #2c3e50;
    }

    h1, h2, h3 {
      font-family: 'Playfair Display', serif;
    }

    .main-image {
      border-radius: 15px;
      box-shadow: 0 10px 30px rgba(0,0,0,0.15);
      width: 100%;
      height: 480px;
      object-fit: cover;
    }

    .thumbnail {
      width: 90px;
      height: 90px;
      object-fit: cover;
      border-radius: 10px;
      border: 3px solid transparent;
      cursor: pointer;
      transition: all 0.3s ease;
    }

    .thumbnail:hover {
      border-color: #2c3e50;
      transform: scale(1.05);
    }

    .thumbnail.active {
      border-color: #2c3e50;
      box-shadow: 0 0 0 3px rgba(44, 62, 80, 0.3);
    }

    .product-card {
      transition: all 0.3s ease;
      border: none;
      border-radius: 12px;
    }

    .product-card:hover {
      transform: translateY(-8px);
      box-shadow: 0 15px 30px rgba(0,0,0,0.12);
    }

    .btn-whatsapp {
      background-color: #25D366;
      color: white;
      border-radius: 50px;
      padding: 12px 35px;
      font-weight: 600;
    }

    .btn-whatsapp:hover {
      background-color: #20ba5c;
      transform: scale(1.05);
    }

    .btn-return {
      color: #2c3e50;
      border: 2px solid #2c3e50;
      border-radius: 50px;
    }
  </style>
@endpush
@section('container')
@include("layouts.front.header",['setting'=>$setting])
<div class="container py-5">

    <!-- Bouton Retour -->
    <div class="mb-4">
      <a href="index.html" class="btn btn-return btn-lg">
        ← Retour aux services
      </a>
    </div>

    <div class="row">

      <!-- Colonne principale -->
      <div class="col-lg-8">

        <!-- Image principale -->
        <img id="mainImage" src="{{ asset($produit->images->first()->path) }}"
             class="main-image mb-3" alt="{{ $produit->name }}">

        <!-- Miniatures -->
        <div class="d-flex gap-3 justify-content-center flex-wrap mb-4" id="thumbnails">
        @foreach ($produit->images as $image)
          <img src="{{ asset($image->path) }}" class="thumbnail active m-r-5" onclick="changeImage(this)" alt="{{ $produit->name }}">
        @endforeach

        </div>
{{--
        <p class="text-center text-muted small mb-4">
          <em>Signature : Cercueil en bois d'ébène massif avec finitions satinées et poignées en laiton</em>
        </p> --}}

        <!-- Titre + Prix + Catégorie -->
        <div class="d-flex justify-content-between align-items-start mb-3">
          <div>
            <h1 class="display-5 fw-bold">{{ $produit->name }}</h1>
            <span class="badge bg-secondary fs-6">Catégorie : {{ $produit->type_product }}</span>
          </div>
          <div class="text-end">
            <h2 class="text-success fw-bold">{{ $produit->prix }}F CFA</h2>
          </div>
        </div>

        <!-- Bouton WhatsApp -->
        <div class="mb-5">
          <a href="https://wa.me/{{ $setting->telephone_whatsapp }}?text=Bonjour,%20je%20souhaite%20avoir%20plus%20d'informations%20sur%20le%20cercueil%20%C3%89b%C3%A8ne"
             target="_blank"
             class="btn btn-whatsapp btn-lg w-100">
            <i class="fab fa-whatsapp"></i> Commander via WhatsApp
          </a>
        </div>

        <!-- Description -->
        <h3 class="mb-4">Description</h3>
        <p class="lead">
            {!! $produit->content !!}
        </p>

        {{-- <div class="row g-4 mt-4">
          <div class="col-md-6">
            <ul class="list-unstyled">
              <li><strong>Matériau :</strong> Bois d'ébène massif</li>
              <li><strong>Intérieur :</strong> Tissu satin crème</li>
              <li><strong>Poignées :</strong> Laiton poli</li>
              <li><strong>Dimensions :</strong> 200 x 70 x 60 cm</li>
            </ul>
          </div>
          <div class="col-md-6">
            <ul class="list-unstyled">
              <li><strong>Personnalisation :</strong> Possible (plaque, gravure)</li>
              <li><strong>Disponibilité :</strong> En stock</li>
              <li><strong>Livraison :</strong> Sous 48h</li>
            </ul>
          </div>
        </div>

        <div class="mt-5 p-4 bg-white rounded-3">
          <p><strong>Note :</strong> Nous vous accompagnons personnellement dans le choix de ce cercueil afin qu’il corresponde parfaitement à l’hommage que vous souhaitez rendre.</p>
        </div> --}}
      </div>

      <!-- Sidebar - Autres produits -->
      <div class="col-lg-4">
        <h4 class="mb-4">Autres cercueils</h4>
        @foreach ($others as $other)
            <div class="product-card bg-white p-3 mb-3" style="height: 170px !important;">
            <div class="d-flex gap-3">
                <img src="{{ asset($other->images->first()->path) }}"
                    class="rounded" width="90" height="90" style="object-fit:cover;" alt="{{ $other->name }}">
                <div>
                <h5 class="mb-1">&nbsp;{{ $other->name }}</h5>
                <p class="text-success fw-bold">&nbsp;{{ $other->prix }}F CFA</p>
                <small class="text-muted">Catégorie : {{ $other->type_product }}</small>
                <a href="{{ route('pompe.details.produit',['slug_produit'=>$other->slug]) }}" class="d-block mt-2 text-decoration-none">Voir le détail →</a>
                </div>
            </div>
            </div>
        @endforeach


      </div>
    </div>
  </div>
@endsection
@push("scripts")
      <!-- Script pour changer l'image principale -->
  <script>
    function changeImage(thumbnail) {
      const mainImage = document.getElementById('mainImage');
      mainImage.src = thumbnail.src;

      // Retirer la classe active de toutes les miniatures
      document.querySelectorAll('.thumbnail').forEach(img => {
        img.classList.remove('active');
      });

      // Ajouter la classe active à celle cliquée
      thumbnail.classList.add('active');
    }
  </script>
@endpush
