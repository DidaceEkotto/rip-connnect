@extends('layouts.front.template_front')
@php
    $setting = \App\Models\Setting::first();
    $title = $morgue->nom. " :: ". $setting->name_entreprise;
    $title2 = $morgue->nom
@endphp
@push("css")
    <style>
        /* ===== HERO ===== */
        .morgue-hero {
            min-height: 500px;
            position: relative;
            overflow: hidden;
        }
        .hero-bg {
            position: absolute;
            inset: 0;
            background-size: cover;
            background-position: center;
            filter: brightness(0.6);
            z-index: 0;
        }
        .hero-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(15,23,42,0.3) 0%, rgba(15,23,42,0.8) 100%);
            z-index: 1;
        }
        .min-vh-50 { min-height: 50vh; }
        .hero-wave {
            position: absolute;
            bottom: -1px;
            left: 0;
            right: 0;
            z-index: 2;
            line-height: 0;
        }
        .hero-wave svg {
            width: 100%;
            height: auto;
        }
        .morgue-logo {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border: 3px solid rgba(255,255,255,0.3);
        }
        .badge-rating { backdrop-filter: blur(10px); }
        .text-white-75 { color: rgba(255,255,255,0.75) !important; }
        .text-white-25 { color: rgba(255,255,255,0.25) !important; }
        .breadcrumb-dark .breadcrumb-item + .breadcrumb-item::before {
            color: rgba(255,255,255,0.5);
        }

        /* ===== ICONES ===== */
        .icon-circle {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
        }
        .icon-circle-sm {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 0.9rem;
        }

        /* ===== GALERIE ===== */
        .gallery-item {
            cursor: pointer;
            transition: transform 0.3s ease;
        }
        .gallery-item:hover {
            transform: scale(1.03);
        }
        .gallery-item img {
            transition: transform 0.5s ease;
        }
        .gallery-item:hover img {
            transform: scale(1.1);
        }
        .gallery-overlay {
            position: absolute;
            inset: 0;
            background: rgba(0,0,0,0.4);
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        .gallery-item:hover .gallery-overlay {
            opacity: 1;
        }

        /* ===== AVATAR ===== */
        .avatar-circle {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
        }

        /* ===== STARS ===== */
        .star-rating button {
            background: none;
            border: none;
            cursor: pointer;
            transition: transform 0.2s;
        }
        .star-rating button:hover {
            transform: scale(1.2);
        }

        /* ===== SOCIAL ===== */
        .social-btn {
            width: 44px;
            height: 44px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0;
            transition: all 0.3s ease;
        }
        .social-btn:hover {
            transform: translateY(-3px);
        }

        /* ===== LIGHTBOX ===== */
        .lightbox {
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.95);
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s ease;
        }
        .lightbox.active {
            opacity: 1;
            pointer-events: all;
        }
        .lightbox img {
            max-width: 90%;
            max-height: 90vh;
            border-radius: 8px;
            box-shadow: 0 25px 50px rgba(0,0,0,0.5);
        }
        .lightbox-close {
            position: absolute;
            top: 20px;
            right: 20px;
            background: rgba(255,255,255,0.1);
            border: none;
            color: white;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            font-size: 1.5rem;
            cursor: pointer;
            transition: background 0.3s;
        }
        .lightbox-close:hover {
            background: rgba(255,255,255,0.2);
        }

        /* ===== UTILITAIRES ===== */
        .hover-lift:hover {
            transform: translateY(-3px);
            box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.08) !important;
        }
        .transition-all {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .object-fit-cover { object-fit: cover; }
        .cursor-pointer { cursor: pointer; }
        .backdrop-blur { backdrop-filter: blur(10px); }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 991.98px) {
            .morgue-hero { min-height: 400px; }
            .sticky-top { position: relative !important; top: 0 !important; }
            .display-5 { font-size: 1.8rem; }
        }
    </style>

@endpush

@section('container')
@include("layouts.front.header",['setting'=>$setting])
@livewire("morgue.morgue-details",['morgue'=>$morgue])
@endsection
@push("scripts")
        <!-- Scripts & Styles -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>



@endpush

