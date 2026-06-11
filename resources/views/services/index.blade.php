@extends("layouts.front.template_front")
@php
    $setting = \App\Models\Setting::first();
    $title = "Nos services :: ". $setting->name_entreprise;
    $title2 = "Nos services" ;
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
        @foreach ($services as $service)
            <!-- Service 1 -->
            <div class="col-lg-4 col-md-6 mb-2">
                <div class="service-card bg-white h-100 p-4 text-start">
                    <div class="d-flex align-items-center gap-3 mb-3">
                    <img src="{{ asset($service->image) }}"
                        class="service-img" alt="{{ $service->titre }}">
                    <h4 class="mb-0">{{ $service->titre }}</h4>
                    </div>
                    <p class="text-muted">{!! Str::limit($service->description, 78, '...') !!}</p>
                    <a href="{{ route('services.details',['slug'=>$service->slug]) }}" class="btn btn-lire-plus">Lire plus →</a>
                </div>
            </div>
        @endforeach

      </div>
    </div>
  </section>
@endsection
