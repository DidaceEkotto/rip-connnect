@extends('layouts.front.template_front')
@php
    $setting = \App\Models\Setting::first();
    $title = "Morgues". ' :: '. $setting->name_entreprise;
    $title2 = "Morgues";
@endphp
@push("css")
 <!-- Leaflet CSS & JS pour la carte -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

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

    /* h1, h2, h3 {
      font-family: 'Playfair Display', serif;
    } */

    .page-header {
      background: linear-gradient(rgba(0,0,0,0.65), rgba(0,0,0,0.65)),
                  url('https://images.unsplash.com/photo-1582213782179-1f2f0c8e6c8f?ixlib=rb-4.0.3&auto=format&fit=crop&q=80') center/cover;
      height: 40vh;
      min-height: 320px;
      display: flex;
      align-items: center;
      color: white;
      text-align: center;
    }

    .morgue-card {
      transition: all 0.3s ease;
      border: none;
      border-radius: 15px;
      overflow: hidden;
      background: white;
    }

    .morgue-card:hover {
      transform: translateY(-8px);
      box-shadow: 0 15px 30px rgba(0,0,0,0.15);
    }

    .morgue-banner {
      height: 180px;
      object-fit: cover;
    }

    #map {
      height: 650px;
      border-radius: 15px;
      box-shadow: 0 10px 25px rgba(0,0,0,0.1);
      z-index: -999999 !important;
    }

    .search-input {
      border-radius: 50px;
      padding: 14px 20px;
    }
  </style>
@endpush

@section('container')
@include("layouts.front.header",['setting'=>$setting])
@livewire('morgue.listing-des-morgues',['morgues'=>$morgues, 'page'=>request()->fullUrl()])


@endsection

