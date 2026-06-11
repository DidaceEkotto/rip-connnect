@extends("layouts.front.template_front")
@php
    $setting = \App\Models\Setting::first();
    $title = "Aides :: ". $setting->name_entreprise;
    $title2 = "Aides" ;
@endphp
@push("css")
  <style>
    :root {
      --soft-beige: #f8f1e9;
      --deep-blue: #2c3e50;
      --warm-gray: #5f6b7a;
    }

    body {
      font-family: 'Inter', sans-serif;
      background-color: #f8f1e9;
      color: #2c3e50;
    }

    h1, h2, h3 {
      font-family: 'Playfair Display', serif;
    }

    .header {
      background: linear-gradient(rgba(0,0,0,0.65), rgba(0,0,0,0.65)), url('https://images.unsplash.com/photo-1518199266791-5375a563f8a8?ixlib=rb-4.0.3&auto=format&fit=crop&q=80') center/cover no-repeat;
      height: 60vh;
      min-height: 500px;
      display: flex;
      align-items: center;
      color: white;
    }

    .service-card {
      transition: all 0.3s ease;
      border: none;
      border-radius: 15px;
      overflow: hidden;
      box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    }

    .service-card:hover {
      transform: translateY(-10px);
      box-shadow: 0 15px 30px rgba(0,0,0,0.15);
    }

    .service-img {
      width: 100px;
      height: 100px;
      object-fit: cover;
      border-radius: 50%;
      border: 4px solid #f8f1e9;
    }

    .btn-lire-plus {
      background-color: #2c3e50;
      color: white;
      border-radius: 30px;
      padding: 8px 25px;
      transition: all 0.3s;
    }

    .btn-lire-plus:hover {
      background-color: #34495e;
      transform: scale(1.05);
    }
  </style>
@endpush
@section("container")
@include("layouts.front.header",['setting'=>$setting])
 <!-- HEADER -->
  <header class="header text-center">
    <div class="container">
      <h1 class="display-4 fw-bold mb-3">Dans l’ombre de la perte,<br>une lumière d’accompagnement</h1>
      <p class="lead fs-4 mb-4" style="max-width: 700px; margin: 0 auto;">
        Nous vous offrons un espace de respect, d’écoute et de douceur<br>
        pour traverser cette épreuve avec dignité et humanité.
      </p>
      <a href="#services" class="btn btn-light btn-lg mt-3">Découvrir nos services</a>
    </div>
  </header>

  <!-- SERVICES SECTION -->
  <section id="services" class="py-5">
    <div class="container">
      <div class="text-center mb-5">
        <h2 class="display-5 fw-bold">Nos Services d'Accompagnement</h2>
        <p class="lead text-muted">Une présence bienveillante à chaque étape de votre chemin</p>
      </div>

      <div class="row g-4">

        <!-- Service 1 -->
        <div class="col-lg-4 col-md-6">
          <div class="service-card bg-white h-100 p-4 text-start">
            <div class="d-flex align-items-center gap-3 mb-3">
              <img src="https://images.unsplash.com/photo-1582213782179-1f2f0c8e6c8f?ixlib=rb-4.0.3"
                   class="service-img" alt="Accompagnement funéraire">
              <h4 class="mb-0">Accompagnement Funéraire</h4>
            </div>
            <p class="text-muted">Organisation complète et personnalisée des obsèques avec respect et dignité.</p>
            <a href="#" class="btn btn-lire-plus">Lire plus →</a>
          </div>
        </div>

        <!-- Service 2 -->
        <div class="col-lg-4 col-md-6">
          <div class="service-card bg-white h-100 p-4 text-start">
            <div class="d-flex align-items-center gap-3 mb-3">
              <img src="https://images.unsplash.com/photo-1555252333-9f8e92e65df9?ixlib=rb-4.0.3"
                   class="service-img" alt="Soutien psychologique">
              <h4 class="mb-0">Soutien Psychologique</h4>
            </div>
            <p class="text-muted">Écoute active et accompagnement par des professionnels formés au deuil.</p>
            <a href="#" class="btn btn-lire-plus">Lire plus →</a>
          </div>
        </div>

        <!-- Service 3 -->
        <div class="col-lg-4 col-md-6">
          <div class="service-card bg-white h-100 p-4 text-start">
            <div class="d-flex align-items-center gap-3 mb-3">
              <img src="https://images.unsplash.com/photo-1516534775068-ba3e7458b0c6?ixlib=rb-4.0.3"
                   class="service-img" alt="Cérémonies">
              <h4 class="mb-0">Cérémonies Personnalisées</h4>
            </div>
            <p class="text-muted">Création de rituels uniques pour honorer la mémoire de votre proche.</p>
            <a href="#" class="btn btn-lire-plus">Lire plus →</a>
          </div>
        </div>

        <!-- Service 4 -->
        <div class="col-lg-4 col-md-6">
          <div class="service-card bg-white h-100 p-4 text-start">
            <div class="d-flex align-items-center gap-3 mb-3">
              <img src="https://images.unsplash.com/photo-1583243777803-7b5b5d8c8c5e?ixlib=rb-4.0.3"
                   class="service-img" alt="Conseils administratifs">
              <h4 class="mb-0">Conseils Administratifs</h4>
            </div>
            <p class="text-muted">Aide dans toutes les démarches administratives et juridiques post-décès.</p>
            <a href="#" class="btn btn-lire-plus">Lire plus →</a>
          </div>
        </div>

        <!-- Service 5 -->
        <div class="col-lg-4 col-md-6">
          <div class="service-card bg-white h-100 p-4 text-start">
            <div class="d-flex align-items-center gap-3 mb-3">
              <img src="https://images.unsplash.com/photo-1600880292203-757bb62b4baf?ixlib=rb-4.0.3"
                   class="service-img" alt="Groupes de parole">
              <h4 class="mb-0">Groupes de Parole</h4>
            </div>
            <p class="text-muted">Espaces d’échange sécurisants avec d’autres personnes en deuil.</p>
            <a href="#" class="btn btn-lire-plus">Lire plus →</a>
          </div>
        </div>

      </div>
    </div>
  </section>
@endsection
