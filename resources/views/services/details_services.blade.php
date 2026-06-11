@extends("layouts.front.template_front")
@php
    $setting = \App\Models\Setting::first();
    $title = $service->titre. " :: ". $setting->name_entreprise;
    $title2 = $service->titre. " Nos services" ;
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

    .detail-header {
      background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('https://images.unsplash.com/photo-1582213782179-1f2f0c8e6c8f?ixlib=rb-4.0.3&auto=format&fit=crop&q=80') center/cover;
      padding: 120px 0 80px;
      color: white;
    }

    .circle-img {
      width: 140px;
      height: 140px;
      border-radius: 50%;
      border: 6px solid white;
      object-fit: cover;
      box-shadow: 0 8px 20px rgba(0,0,0,0.2);
    }

    .service-card {
      transition: all 0.3s ease;
      border: none;
      border-radius: 12px;
    }

    .service-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 25px rgba(0,0,0,0.12);
    }

    .btn-contact {
      background-color: #2c3e50;
      color: white;
      border-radius: 50px;
      padding: 14px 40px;
      font-size: 1.1rem;
      font-weight: 500;
    }

    .btn-contact:hover {
      background-color: #34495e;
      transform: scale(1.05);
    }
  </style>
@endpush
@section("container")
@include("layouts.front.header",['setting'=>$setting])
 <!-- HEADER DE LA PAGE DÉTAIL -->
  <header class="detail-header text-center">
    <div class="container">
      <div class="d-flex flex-column flex-md-row align-items-center justify-content-center gap-4">
        <img src="{{ asset($service->image) }}"
             class="circle-img" alt="{{ $service->titre }}">
        <div>
          <h1 class="display-4 fw-bold">{{ $service->titre }}</h1>
          <p class="lead">Un accompagnement digne et respectueux pour dire au revoir à votre proche</p>
        </div>
      </div>
    </div>
  </header>

  <div class="container py-5">
    <div class="row">
 @php
                        $dateDeces = !empty($service->created_at)
                            ? \Carbon\Carbon::parse($service->created_at)
                            : null;
                        $dateFr = $dateDeces ? $dateDeces->translatedFormat('l d F Y') : 'Date non précisée';
                    @endphp
      <!-- PARTIE PRINCIPALE (Description) - 70% -->
      <div class="col-lg-8">
        <div class="mb-4">
          <small class="text-muted">Publié le <strong>{{ $dateFr }}</strong> • Par <strong>{{ $setting->name_entreprise }}</strong></small>
        </div>

        <div class="content">
            {!! $service->description !!}
        </div>

        <!-- Bouton d'appel à l'action -->
        <div class="text-center my-5">
          <a href="{{ route('contact.index') }}" class="btn btn-contact btn-lg">
            Nous contacter pour un accompagnement
          </a>
        </div>
      </div>

      <!-- SIDEBAR - Autres services (30%) -->
      <div class="col-lg-4">
        <h4 class="mb-4">Autres services</h4>
        @foreach ($other_services as $serv)
            <!-- Autre service 1 -->
            <div class="service-card bg-white p-3 mb-3" style="height: 180px !important;">
            <div class="d-flex gap-3">
                <img src="{{ asset($serv->image) }}"
                    class="rounded-circle" width="70" height="70" alt="">
                <div>
                <h5 class="mb-1">{{ Str::limit($serv->titre, 40, '...') }}</h5>
                <p class="small text-muted">{{ Str::limit($serv->titre, 55, '...') }}</p>
                <a href="{{ route('services.details',['slug'=>$serv->slug]) }}" class="text-decoration-none">En savoir plus →</a>
                </div>
            </div>
            </div>
            <br>
        @endforeach

      </div>
    </div>
  </div>
@endsection
