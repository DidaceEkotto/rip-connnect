<!DOCTYPE html>
<html lang="fr">
    @php
        $setting = \App\Models\Setting::first();
    @endphp
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="author" content="{{ $setting->name_entreprise }}" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="robots" content="index, follow" />
    <meta name="robots" content="max-snippet:-1, max-image-preview:large, max-video-preview:-1"/>
    <link rel="canonical" href="{{ request()->fullUrl() }}" />
    <meta property="og:locale" content="fr_FR" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ request()->fullUrl() }}" />
    <meta property="og:site_name" content="{{ $setting->name_entreprise }}" />
    <meta name="description" content="{{ isset($description) ? $description : $setting->description }}" />
    <meta name="twitter:site" content="{{ request()->fullUrl() }}" />
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:description" content="{{ isset($description) ? $description : $setting->description }}" />
    <meta name="twitter:title" content="{{ isset($title) ? $title : '' }}" />
    <meta name="twitter:image" content="img/ms-icon-310x310.png" />
    <meta property="og:title" content="{{ isset($title) ? $title : '' }}" />
    <meta property="og:image" content="img/ms-icon-310x310.png" />
    <meta property="og:image:secure_url" content="img/ms-icon-310x310.png" />
    <meta property="og:image:width" content="310" />
    <meta property="og:image:height" content="310" />
    <meta property="og:description" content="{{ isset($description) ? $description : $setting->description }}" />
    <title>{{ isset($title) ? $title : '' }}</title>


    <!-- Stylesheets & Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link rel="preload" href="{{ asset('assets/css/plugins.css') }}" as="style" onload="this.rel='stylesheet'">
    <link rel="preload" href="{{ asset('assets/css/style.css') }}" as="style" onload="this.rel='stylesheet'">
    <link rel="preload" href="{{ asset('assets/css/theme.css') }}" as="style" onload="this.rel='stylesheet'">
    <link rel="preload" href="{{ asset('assets/css/owl.carousel.min.css') }}" as="style" onload="this.rel='stylesheet'">
    <link rel="preload" href="{{ asset('assets/css/owl.theme.default.min.css') }}" as="style" onload="this.rel='stylesheet'">
    <link rel="preload" href="{{ asset('assets/css/leaflet.bundle.css') }}" as="style" onload="this.rel='stylesheet'">
    <link rel="preload" href="{{ asset('assets/plugins/bootstrap-switch/bootstrap-switch.css') }}" as="style" onload="this.rel='stylesheet'">

    <!-- CDNs -->
    <link rel="preload" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" as="style" onload="this.rel='stylesheet'">
    <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.css" as="style" onload="this.rel='stylesheet'">
    <link rel="preload" href="https://unicons.iconscout.com/release/v2.1.9/css/unicons.css" as="style" onload="this.rel='stylesheet'">
    <link rel="preload" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" as="style" onload="this.rel='stylesheet'">

    <!-- fallback -->
    {{-- <noscript>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/plugins.css">
    <link rel="stylesheet" href="css/theme.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <link rel="stylesheet" href="css/leaflet.bundle.css">
    <link rel="stylesheet" href="plugins/bootstrap-switch/bootstrap-switch.css">
    </noscript> --}}

    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link rel="preconnect" href="https://cdn.jsdelivr.net/">
    <link rel="preconnect" href="https://cdnjs.cloudflare.com/">

    <link rel="preload" href="https://fonts.googleapis.com/css?family=Open+Sans%3A300%2C300italic%2Cregular%2Citalic%2C600%2C600italic%2C700%2C700italic%2C800%2C800italic%7CComfortaa%3A300%2Cregular%2C700%7CComfortaa:400,700&amp;subset=latin%2Clatin-ext" as="style" onload="this.rel='stylesheet'" />
    <noscript>
    <link rel="stylesheet" id="ao_optimized_gfonts" href="https://fonts.googleapis.com/css?family=Open+Sans%3A300%2C300italic%2Cregular%2Citalic%2C600%2C600italic%2C700%2C700italic%2C800%2C800italic%7CComfortaa%3A300%2Cregular%2C700%7CComfortaa:400,700&amp;subset=latin%2Clatin-ext" />
    </noscript>


    <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet" type="text/css" />

   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <style>

        /* ================= SECTION MÉMORIALE ================= */
        .memorial-section {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            padding: 60px 0;
            color: white;
            position: relative;
            overflow: hidden;
        }
        .memorial-section::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 500px;
            height: 500px;
            background: rgba(255,215,0,0.03);
            border-radius: 50%;
        }

        /* Partie Photo du défunt */
        .memorial-card {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 215, 0, 0.3);
            position: relative;
            transition: all 0.4s ease;
        }
        .memorial-card:hover {
            border-color: rgba(255, 215, 0, 0.6);
            box-shadow: 0 25px 70px rgba(0, 0, 0, 0.4);
        }
        .memorial-image {
            position: relative;
            height: 520px;
            overflow: hidden;
        }
        .memorial-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.6s ease;
            display: block;
        }
        .memorial-card:hover .memorial-image img {
            transform: scale(1.08);
        }
        .memorial-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(to top, rgba(0,0,0,0.95) 0%, rgba(0,0,0,0.6) 50%, transparent 100%);
            padding: 50px 25px 30px;
            text-align: center;
        }
        .memorial-overlay h2 {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 10px;
            color: #fff;
            text-transform: uppercase;
            letter-spacing: 2px;
            text-shadow: 0 2px 10px rgba(0,0,0,0.5);
        }
        .memorial-overlay .dates {
            color: #ffd700;
            font-size: 17px;
            font-weight: 600;
            letter-spacing: 1px;
        }
        .memorial-overlay .dates i {
            margin-right: 8px;
        }
        .memorial-badge {
            position: absolute;
            top: 25px;
            right: 25px;
            background: linear-gradient(135deg, #ffd700 0%, #ffed4e 100%);
            color: #1e3c72;
            padding: 10px 25px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 2px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.3);
            z-index: 5;
        }

        /* Partie Témoignages défilants */
        .testimonials-wrapper {
            padding: 10px;
        }
        .testimonials-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .testimonials-header h3 {
            font-size: 26px;
            margin: 0;
            display: inline-flex;
            align-items: center;
            gap: 12px;
            color: #fff;
            font-weight: 600;
        }
        .testimonials-header i {
            color: #ffd700;
            animation: pulseHeart 2s infinite;
        }
        @keyframes pulseHeart {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.25); }
        }
        .testimonials-container {
            height: 500px;
            overflow: hidden;
            position: relative;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 16px;
            padding: 20px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        .testimonials-container::before,
        .testimonials-container::after {
            content: '';
            position: absolute;
            left: 0;
            right: 0;
            height: 60px;
            z-index: 10;
            pointer-events: none;
        }
        .testimonials-container::before {
            top: 0;
            background: linear-gradient(to bottom, rgba(30,60,114,0.9), transparent);
        }
        .testimonials-container::after {
            bottom: 0;
            background: linear-gradient(to top, rgba(30,60,114,0.9), transparent);
        }
        .testimonials-scroll {
            display: flex;
            flex-direction: column;
            gap: 20px;
            animation: scrollUp 30s linear infinite;
        }
        .testimonials-scroll:hover {
            animation-play-state: paused;
        }
        @keyframes scrollUp {
            0% { transform: translateY(0); }
            100% { transform: translateY(-50%); }
        }
        .testimonial-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 14px;
            padding: 22px;
            border-left: 5px solid #ffd700;
            box-shadow: 0 8px 25px rgba(0,0,0,0.12);
            flex-shrink: 0;
            transition: all 0.3s ease;
        }
        .testimonial-card:hover {
            transform: translateX(10px);
            box-shadow: 0 12px 35px rgba(0,0,0,0.18);
        }
        .testimonial-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 14px;
        }
        .testimonial-avatar {
            width: 55px;
            height: 55px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #ffd700;
            flex-shrink: 0;
            box-shadow: 0 4px 10px rgba(0,0,0,0.15);
        }
        .testimonial-meta h4 {
            margin: 0;
            font-size: 17px;
            color: #1e3c72;
            font-weight: 700;
        }
        .testimonial-meta .stars {
            color: #ffd700;
            font-size: 13px;
            margin-top: 5px;
            letter-spacing: 2px;
        }
        .testimonial-card p {
            color: #555;
            font-size: 15px;
            line-height: 1.8;
            margin: 0;
            font-style: italic;
        }

        /* Responsive Mémoriale */
        @media (max-width: 991px) {
            .memorial-image { height: 450px; }
            .testimonials-container { height: 450px; }
            .memorial-overlay h2 { font-size: 26px; }
        }
        @media (max-width: 768px) {
            .memorial-section { padding: 40px 0; }
            .memorial-image { height: 380px; }
            .memorial-overlay { padding: 35px 20px 25px; }
            .memorial-overlay h2 { font-size: 22px; }
            .testimonials-container { height: 380px; margin-top: 30px; }
            .testimonial-card p { font-size: 14px; }
        }

        /* PAGE LOADER */
        #page-loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            z-index: 99999;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: opacity 0.6s ease, visibility 0.6s ease;
        }
        #page-loader.hidden {
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
        }
        .loader-content {
            text-align: center;
            color: white;
        }
        .loader-coffin {
            width: 90px;
            height: 110px;
            margin: 0 auto 25px;
            position: relative;
        }
        .loader-coffin svg {
            width: 100%;
            height: 100%;
            filter: drop-shadow(0 0 15px rgba(255, 215, 0, 0.4));
            animation: pulse-coffin 1.5s ease-in-out infinite;
        }
        @keyframes pulse-coffin {
            0%, 100% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.08); opacity: 0.85; }
        }
        .loader-content p {
            font-size: 18px;
            letter-spacing: 3px;
            text-transform: uppercase;
            margin-top: 15px;
            font-weight: 300;
        }
        .loader-dots::after {
            content: '';
            animation: dots 1.5s infinite;
        }
        @keyframes dots {
            0% { content: '.'; }
            33% { content: '..'; }
            66% { content: '...'; }
        }

        /* ================= MENU DROPDOWN CORRIGÉ - AU CLIC ================= */
        .menu_principal .has-submenu {
            position: relative;
        }
        .menu_principal .has-submenu .submenu-list {
            display: none;
            position: absolute;
            left: 0;
            top: 100%;
            background: #fff;
            min-width: 280px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.15);
            border-radius: 12px;
            padding: 8px 0;
            margin-top: 8px;
            z-index: 9999;
            list-style: none;
            border: 1px solid rgba(0,0,0,0.06);
            opacity: 0;
            transform: translateY(-10px);
            transition: opacity 0.25s ease, transform 0.25s ease;
        }
        .menu_principal .has-submenu.open .submenu-list {
            display: block;
            opacity: 1;
            transform: translateY(0);
        }
        /* Désactiver le hover - uniquement au clic */
        .menu_principal .has-submenu:hover > .submenu-list {
            display: none !important;
        }
        .menu_principal .has-submenu.open > .submenu-list {
            display: block !important;
        }
        .menu_principal .submenu-list li a {
            display: block;
            padding: 12px 25px;
            color: #444;
            text-decoration: none;
            font-size: 14px;
            transition: all 0.2s;
            border-left: 3px solid transparent;
        }
        .menu_principal .submenu-list li a:hover {
            background: #f8f9fa;
            color: #1e3c72;
            border-left-color: #ffd700;
            padding-left: 28px;
        }
        .menu_principal .has-submenu > a .chevron {
            transition: transform 0.3s;
            display: inline-block;
            margin-left: 5px;
            font-size: 12px;
        }
        .menu_principal .has-submenu.open > a .chevron {
            transform: rotate(180deg);
        }

        /* LANGUAGE SWITCHER */
        .lang-switcher {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-left: 20px;
            padding-left: 15px;
            border-left: 1px solid rgba(255,255,255,0.2);
        }
        .lang-switcher a {
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            padding: 4px 10px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 700;
            transition: all 0.3s;
            letter-spacing: 1px;
            border: 1px solid transparent;
        }
        .lang-switcher a.active {
            background: #ffd700;
            color: #1e3c72;
            border-color: #ffd700;
        }
        .lang-switcher a:not(.active):hover {
            border-color: rgba(255,255,255,0.4);
            color: #fff;
        }

        /* SCROLL TO TOP BUTTON */
        #scrollTop {
            position: fixed !important;
            bottom: 90px;
            right: 25px;
            width: 50px;
            height: 50px;
            background: #1e3c72;
            color: white;
            border-radius: 50%;
            display: flex !important;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 9999;
            box-shadow: 0 4px 15px rgba(0,0,0,0.3);
            transition: all 0.3s ease;
            opacity: 0;
            visibility: hidden;
            transform: translateY(20px);
            text-decoration: none;
        }
        #scrollTop.visible {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }
        #scrollTop:hover {
            background: #ffd700;
            color: #1e3c72;
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.4);
        }
        #scrollTop i {
            font-size: 20px;
            line-height: 1;
        }

        /* FAQ SECTION */
        .faq-section {
            background: #f8f9fa;
            padding: 80px 0;
        }
        .faq-item {
            background: #fff;
            border-radius: 10px;
            margin-bottom: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.04);
            overflow: hidden;
            border: 1px solid #e9ecef;
        }
        .faq-question {
            padding: 22px 25px;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-weight: 600;
            color: #1e3c72;
            transition: all 0.3s;
            font-size: 16px;
        }
        .faq-question:hover {
            background: rgba(30,60,114,0.03);
        }
        .faq-question i {
            transition: transform 0.3s;
            color: #ffd700;
            font-size: 14px;
        }
        .faq-item.active .faq-question i {
            transform: rotate(180deg);
        }
        .faq-answer {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.4s ease, padding 0.4s ease;
            padding: 0 25px;
            color: #555;
            line-height: 1.7;
            font-size: 15px;
        }
        .faq-item.active .faq-answer {
            max-height: 400px;
            padding: 0 25px 25px;
        }

        /* NEWSLETTER SECTION */
        .newsletter-section {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            padding: 70px 0;
            color: white;
            position: relative;
            overflow: hidden;
        }
        .newsletter-section::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 400px;
            height: 400px;
            background: rgba(255,255,255,0.03);
            border-radius: 50%;
        }
        .newsletter-section h3 {
            font-size: 28px;
            margin-bottom: 10px;
            font-weight: 600;
        }
        .newsletter-section p {
            opacity: 0.9;
            margin-bottom: 30px;
            font-size: 16px;
        }
        .newsletter-form {
            display: flex;
            gap: 12px;
            max-width: 550px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
        }
        .newsletter-form input {
            flex: 1;
            padding: 14px 25px;
            border: none;
            border-radius: 50px;
            outline: none;
            font-size: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }
        .newsletter-form button {
            padding: 14px 35px;
            background: #ffd700;
            color: #1e3c72;
            border: none;
            border-radius: 50px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 14px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }
        .newsletter-form button:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 20px rgba(0,0,0,0.3);
        }

        /* YOUTUBE SECTION */
        .youtube-section {
            padding: 80px 0;
            background: #fff;
        }
        .main-video-wrapper {
            position: relative;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 15px 40px rgba(0,0,0,0.15);
            background: #000;
        }
        .main-video {
            position: relative;
            padding-bottom: 56.25%;
            height: 0;
            overflow: hidden;
        }
        .main-video iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: none;
        }
        .video-thumbnails {
            display: flex;
            flex-direction: column;
            gap: 15px;
            height: 100%;
            max-height: 450px;
            overflow-y: auto;
            padding-right: 5px;
        }
        .video-thumbnails::-webkit-scrollbar {
            width: 6px;
        }
        .video-thumbnails::-webkit-scrollbar-thumb {
            background: #1e3c72;
            border-radius: 3px;
        }
        .thumb-item {
            display: flex;
            gap: 12px;
            padding: 12px;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s;
            border: 2px solid #e9ecef;
            background: #fff;
            align-items: center;
        }
        .thumb-item:hover, .thumb-item.active {
            background: #f8f9fa;
            border-color: #1e3c72;
            box-shadow: 0 4px 12px rgba(30,60,114,0.1);
            transform: translateX(5px);
        }
        .thumb-item.active {
            background: #1e3c72;
            border-color: #1e3c72;
        }
        .thumb-item.active .thumb-info h5,
        .thumb-item.active .thumb-info span {
            color: #fff;
        }
        .thumb-item img {
            width: 100px;
            height: 70px;
            object-fit: cover;
            border-radius: 8px;
            flex-shrink: 0;
        }
        .thumb-info h5 {
            font-size: 14px;
            margin: 0 0 6px;
            color: #1e3c72;
            line-height: 1.3;
            font-weight: 600;
        }
        .thumb-info span {
            font-size: 12px;
            color: #777;
            display: flex;
            align-items: center;
            gap: 5px;
        }
        .play-icon {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 50px;
            height: 50px;
            background: rgba(255,215,0,0.9);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #1e3c72;
            font-size: 20px;
            opacity: 0;
            transition: all 0.3s;
        }
        .thumb-item:hover .play-icon {
            opacity: 1;
        }

        /* ================= NOS SERVICES ================= */
        .services-section {
            padding: 80px 0;
            background: #ffffff;
        }
        .services-section .heading-text h2 {
            color: #1e3c72;
            font-weight: 700;
            margin-bottom: 15px;
        }
        .services-section .heading-text p {
            color: #666;
            font-size: 16px;
            margin-bottom: 50px;
        }
        .service-card {
            background: #fff;
            border-radius: 16px;
            padding: 40px 30px;
            text-align: center;
            box-shadow: 0 5px 25px rgba(30, 60, 114, 0.08);
            border: 1px solid #f0f2f5;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            height: 100%;
            position: relative;
            overflow: hidden;
        }
        .service-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, #ffd700, #ffed4e);
            transform: scaleX(0);
            transition: transform 0.4s ease;
        }
        .service-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(30, 60, 114, 0.15);
            border-color: rgba(255, 215, 0, 0.3);
        }
        .service-card:hover::before {
            transform: scaleX(1);
        }
        .service-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 25px;
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffd700;
            font-size: 32px;
            box-shadow: 0 8px 20px rgba(30, 60, 114, 0.25);
            transition: all 0.3s ease;
        }
        .service-card:hover .service-icon {
            transform: scale(1.1) rotate(5deg);
            background: linear-gradient(135deg, #ffd700 0%, #ffed4e 100%);
            color: #1e3c72;
        }
        .service-card h3 {
            font-size: 20px;
            color: #1e3c72;
            margin-bottom: 15px;
            font-weight: 700;
        }
        .service-card p {
            color: #666;
            font-size: 14px;
            line-height: 1.7;
            margin-bottom: 25px;
        }
        .service-card .btn-service {
            display: inline-block;
            padding: 10px 28px;
            background: transparent;
            color: #1e3c72;
            border: 2px solid #1e3c72;
            border-radius: 50px;
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        .service-card:hover .btn-service {
            background: #1e3c72;
            color: #fff;
            border-color: #1e3c72;
        }
        .service-card:hover .btn-service:hover {
            background: #ffd700;
            border-color: #ffd700;
            color: #1e3c72;
        }

        /* ================= CTA SECTIONS REDESIGN ================= */
        .cta-devis-section {
            background: #f8f9fa;
            padding: 70px 0;
            border-top: 1px solid #e9ecef;
            border-bottom: 1px solid #e9ecef;
        }
        .cta-devis-section h2 {
            color: #1e3c72;
            font-weight: 600;
            font-size: 28px;
            margin-bottom: 15px;
        }
        .cta-devis-section p {
            color: #555;
            font-size: 16px;
            line-height: 1.7;
        }
        .cta-devis-section .btn-cta {
            display: inline-block;
            padding: 16px 40px;
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            color: #fff;
            border-radius: 50px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 8px 25px rgba(30, 60, 114, 0.3);
            border: 2px solid transparent;
        }
        .cta-devis-section .btn-cta:hover {
            background: #fff;
            color: #1e3c72;
            border-color: #1e3c72;
            transform: translateY(-3px);
            box-shadow: 0 12px 30px rgba(30, 60, 114, 0.2);
        }

        .cta-reseau-section {
            background: linear-gradient(135deg, #0f1b3d 0%, #1e3c72 100%);
            padding: 70px 0;
            color: white;
            position: relative;
            overflow: hidden;
        }
        .cta-reseau-section::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 500px;
            height: 500px;
            background: rgba(255,215,0,0.03);
            border-radius: 50%;
        }
        .cta-reseau-section h3 {
            color: #ffd700;
            font-weight: 600;
            font-size: 24px;
            margin-bottom: 15px;
        }
        .cta-reseau-section p {
            color: rgba(255,255,255,0.85);
            font-size: 16px;
            line-height: 1.7;
        }
        .cta-reseau-section strong {
            color: #fff;
        }
        .cta-reseau-section .btn-cta-reseau {
            display: inline-block;
            padding: 16px 40px;
            background: #ffd700;
            color: #1e3c72;
            border-radius: 50px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 8px 25px rgba(0,0,0,0.2);
        }
        .cta-reseau-section .btn-cta-reseau:hover {
            background: #fff;
            color: #1e3c72;
            transform: translateY(-3px);
            box-shadow: 0 12px 30px rgba(0,0,0,0.3);
        }

        @media (max-width: 768px) {
            .lang-switcher {
                margin-left: 10px;
                padding-left: 10px;
            }
            .newsletter-form {
                flex-direction: column;
            }
            .video-thumbnails {
                max-height: 300px;
                margin-top: 20px;
            }
            .thumb-item img {
                width: 80px;
                height: 55px;
            }
            .service-card {
                margin-bottom: 20px;
            }
            .cta-devis-section, .cta-reseau-section {
                text-align: center;
            }
            .cta-devis-section .text-lg-right,
            .cta-reseau-section .text-lg-right {
                text-align: center !important;
                margin-top: 30px;
            }
        }

        /* ================= MOBILE MENU - CORRIGÉ ================= */
        .mobile-menu-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 9998;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        .mobile-menu-overlay.active {
            display: block;
            opacity: 1;
        }
        .mobile-menu-panel {
            position: fixed;
            top: 0;
            right: -320px;
            width: 320px;
            height: 100%;
            background: #fff;
            z-index: 9999;
            box-shadow: -5px 0 30px rgba(0,0,0,0.2);
            transition: right 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            overflow-y: auto;
        }
        .mobile-menu-panel.open {
            right: 0;
        }
        .mobile-menu-header {
            padding: 25px;
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .mobile-menu-header h3 {
            margin: 0;
            font-size: 18px;
            font-weight: 600;
        }
        .mobile-menu-close {
            background: none;
            border: none;
            color: white;
            font-size: 24px;
            cursor: pointer;
            padding: 5px;
        }
        .mobile-menu-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .mobile-menu-list li {
            border-bottom: 1px solid #f0f0f0;
        }
        .mobile-menu-list li a {
            display: block;
            padding: 18px 25px;
            color: #333;
            text-decoration: none;
            font-size: 15px;
            font-weight: 500;
            transition: all 0.2s;
        }
        .mobile-menu-list li a:hover {
            background: #f8f9fa;
            color: #1e3c72;
            padding-left: 30px;
        }
        .mobile-submenu-toggle {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 18px 25px;
            cursor: pointer;
            color: #333;
            font-size: 15px;
            font-weight: 500;
            border-bottom: 1px solid #f0f0f0;
            transition: all 0.2s;
        }
        .mobile-submenu-toggle:hover {
            background: #f8f9fa;
            color: #1e3c72;
        }
        .mobile-submenu-toggle i {
            transition: transform 0.3s;
        }
        .mobile-submenu-toggle.open i {
            transform: rotate(180deg);
        }
        .mobile-submenu {
            display: none;
            background: #f8f9fa;
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .mobile-submenu.open {
            display: block;
            animation: slideDown 0.3s ease;
        }
        @keyframes slideDown {
            from { opacity: 0; max-height: 0; }
            to { opacity: 1; max-height: 500px; }
        }
        .mobile-submenu li a {
            padding: 14px 25px 14px 40px;
            font-size: 14px;
            color: #666;
        }
        .mobile-submenu li a:hover {
            color: #1e3c72;
        }

        /* ================= HAMBURGER BUTTON - CORRIGÉ ================= */
        .hamburger-btn {
            display: none;
            background: none;
            border: none;
            cursor: pointer;
            padding: 10px;
            z-index: 100;
            position: relative;
        }
        .hamburger-btn .hamburger-line {
            display: block;
            width: 25px;
            height: 3px;
            background: #1e3c72;
            margin: 5px 0;
            transition: all 0.3s ease;
            border-radius: 2px;
        }
        .hamburger-btn.active .hamburger-line:nth-child(1) {
            transform: rotate(45deg) translate(5px, 6px);
        }
        .hamburger-btn.active .hamburger-line:nth-child(2) {
            opacity: 0;
        }
        .hamburger-btn.active .hamburger-line:nth-child(3) {
            transform: rotate(-45deg) translate(6px, -6px);
        }

        @media (max-width: 991px) {
            .hamburger-btn {
                display: block !important;
            }
        }

        /* ================= MOT DU FONDATEUR ================= */
        .founder-section {
            padding: 100px 0;
            background: #f8f9fa;
            position: relative;
            overflow: hidden;
        }
        .founder-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="50" cy="50" r="40" fill="none" stroke="%23ffd700" stroke-width="0.5" opacity="0.05"/></svg>');
            background-size: 200px;
            opacity: 0.3;
        }
        .founder-content {
            position: relative;
            z-index: 1;
        }
        .founder-quote-icon {
            font-size: 60px;
            color: #ffd700;
            opacity: 0.3;
            line-height: 1;
            margin-bottom: 20px;
        }
        .founder-text h2 {
            font-size: 32px;
            color: #1e3c72;
            font-weight: 700;
            margin-bottom: 10px;
        }
        .founder-text .subtitle {
            color: #ffd700;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 3px;
            font-weight: 600;
            margin-bottom: 30px;
            display: block;
        }
        .founder-text .message {
            color: #555;
            font-size: 16px;
            line-height: 1.9;
            margin-bottom: 25px;
            font-style: italic;
        }
        .founder-text .signature {
            color: #1e3c72;
            font-weight: 700;
            font-size: 18px;
            margin-top: 30px;
        }
        .founder-text .role {
            color: #888;
            font-size: 14px;
            margin-top: 5px;
        }
        .founder-image-wrapper {
            position: relative;
            text-align: center;
        }
        .founder-image {
            width: 350px;
            height: 450px;
            object-fit: cover;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(30, 60, 114, 0.2);
            position: relative;
            z-index: 2;
        }
        .founder-image-bg {
            position: absolute;
            top: 30px;
            right: 30px;
            width: 350px;
            height: 450px;
            border: 3px solid #ffd700;
            border-radius: 20px;
            z-index: 1;
        }
        .founder-badge {
            position: absolute;
            bottom: -20px;
            left: 50%;
            transform: translateX(-50%);
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            color: #ffd700;
            padding: 15px 35px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 2px;
            box-shadow: 0 10px 30px rgba(30, 60, 114, 0.3);
            z-index: 3;
            white-space: nowrap;
        }

        /* Responsive */
        @media (max-width: 991px) {
            .founder-image-wrapper {
                margin-top: 50px;
            }
            .founder-image, .founder-image-bg {
                width: 280px;
                height: 360px;
            }
        }
        @media (max-width: 768px) {
            .founder-text h2 {
                font-size: 26px;
            }
            .founder-image, .founder-image-bg {
                width: 250px;
                height: 320px;
            }
        }

        /* ================= SECTION PRODUITS / ARTICLES ================= */
        .products-section {
            padding: 80px 0;
            background: linear-gradient(135deg, #f8f9fa 0%, #eef2f7 100%);
            position: relative;
            overflow: hidden;
        }
        .products-section::before {
            content: '';
            position: absolute;
            top: -100px;
            right: -100px;
            width: 400px;
            height: 400px;
            background: rgba(255, 215, 0, 0.03);
            border-radius: 50%;
        }
        .products-section .heading-text h2 {
            color: #1e3c72;
            font-weight: 700;
            margin-bottom: 15px;
        }
        .products-section .heading-text p {
            color: #666;
            font-size: 16px;
            margin-bottom: 50px;
        }
        .product-card {
            background: #fff;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 8px 30px rgba(30, 60, 114, 0.08);
            border: 1px solid #f0f2f5;
            transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            height: 100%;
            position: relative;
        }
        .product-card:hover {
            transform: translateY(-12px);
            box-shadow: 0 25px 50px rgba(30, 60, 114, 0.15);
            border-color: rgba(255, 215, 0, 0.3);
        }
        .product-image {
            position: relative;
            height: 240px;
            overflow: hidden;
        }
        .product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.6s ease;
        }
        .product-card:hover .product-image img {
            transform: scale(1.1);
        }
        .product-badge {
            position: absolute;
            top: 15px;
            left: 15px;
            background: linear-gradient(135deg, #ffd700 0%, #ffed4e 100%);
            color: #1e3c72;
            padding: 6px 16px;
            border-radius: 50px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            z-index: 3;
        }
        .product-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(to top, rgba(30,60,114,0.8) 0%, transparent 60%);
            opacity: 0;
            transition: opacity 0.4s ease;
            display: flex;
            align-items: flex-end;
            justify-content: center;
            padding-bottom: 20px;
        }
        .product-card:hover .product-overlay {
            opacity: 1;
        }
        .product-overlay .btn-quick {
            background: #fff;
            color: #1e3c72;
            padding: 10px 24px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 13px;
            text-decoration: none;
            transform: translateY(20px);
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }
        .product-card:hover .product-overlay .btn-quick {
            transform: translateY(0);
        }
        .product-info {
            padding: 28px;
            text-align: center;
        }
        .product-info h3 {
            font-size: 20px;
            color: #1e3c72;
            font-weight: 700;
            margin-bottom: 10px;
        }
        .product-info p {
            color: #777;
            font-size: 14px;
            line-height: 1.7;
            margin-bottom: 20px;
        }
        .product-price {
            display: block;
            font-size: 22px;
            color: #ffd700;
            font-weight: 800;
            margin-bottom: 18px;
            text-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }
        .product-info .btn-product {
            display: inline-block;
            padding: 12px 32px;
            background: transparent;
            color: #1e3c72;
            border: 2px solid #1e3c72;
            border-radius: 50px;
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        .product-info .btn-product:hover {
            background: #1e3c72;
            color: #fff;
            border-color: #1e3c72;
        }

        /* ================= SECTION FAQ ================= */
        .faq-section {
            padding: 80px 0;
            background: #ffffff;
            position: relative;
        }
        .faq-section .heading-text h2 {
            color: #1e3c72;
            font-weight: 700;
            margin-bottom: 15px;
        }
        .faq-section .heading-text p {
            color: #666;
            font-size: 16px;
            margin-bottom: 50px;
        }
        .faq-container {
            max-width: 900px;
            margin: 0 auto;
        }
        .faq-item {
            background: #fff;
            border-radius: 14px;
            margin-bottom: 16px;
            box-shadow: 0 4px 20px rgba(30, 60, 114, 0.06);
            border: 1px solid #eef2f7;
            overflow: hidden;
            transition: all 0.3s ease;
        }
        .faq-item:hover {
            box-shadow: 0 8px 30px rgba(30, 60, 114, 0.1);
            border-color: rgba(255, 215, 0, 0.2);
        }
        .faq-question {
            padding: 24px 30px;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-weight: 700;
            color: #1e3c72;
            font-size: 17px;
            transition: all 0.3s;
            user-select: none;
        }
        .faq-question:hover {
            background: rgba(30, 60, 114, 0.02);
        }
        .faq-icon {
            width: 36px;
            height: 36px;
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            color: #ffd700;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            flex-shrink: 0;
            margin-left: 15px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 10px rgba(30, 60, 114, 0.2);
        }
        .faq-item.active .faq-icon {
            transform: rotate(180deg);
            background: linear-gradient(135deg, #ffd700 0%, #ffed4e 100%);
            color: #1e3c72;
        }
        .faq-answer {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275), padding 0.4s ease;
            padding: 0 30px;
            color: #555;
            line-height: 1.8;
            font-size: 15px;
        }
        .faq-item.active .faq-answer {
            max-height: 500px;
            padding: 0 30px 28px;
        }
        .faq-answer strong {
            color: #1e3c72;
        }
        @media (max-width: 768px) {
            .product-image { height: 200px; }
            .product-info { padding: 20px; }
            .faq-question { font-size: 15px; padding: 20px; }
            .faq-item.active .faq-answer { padding: 0 20px 24px; }
        }
     </style>
{{-- <base target="_blank"> --}}
@stack("css")
@livewireStyles()
</head>

<body>
    <!-- Mobile Menu Overlay -->
    <div class="mobile-menu-overlay" id="mobileMenuOverlay" onclick="closeMobileMenu()"></div>

    <!-- Mobile Menu Panel -->
    <div class="mobile-menu-panel" id="mobileMenuPanel" style="z-index: 999999 !important;">
        <div class="mobile-menu-header">
            <h3>Menu</h3>
            <button class="mobile-menu-close" onclick="closeMobileMenu()">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
        <ul class="mobile-menu-list">
            <li><a href="{{ route('homePage') }}" >Acceuil</a></li>
            <li>
                <div class="mobile-submenu-toggle" onclick="toggleMobileSubmenu(this)">
                    <span>Décès</span>
                    <i class="bi bi-chevron-compact-down"></i>
                </div>
                <ul class="mobile-submenu">
                    <li><a href="{{ route('deces.index') }}" >Annonces de décès</a></li>
                    <li><a href="" >Avis & carnet du jour</a></li>
                    <li><a href="" >Registre condoléance</a></li>
                    <li><a href="" >Ephéméride</a></li>
                </ul>
            </li>
            <li><a href="{{ route('services.index') }}">Services</a></li>
            <li>
                <div class="mobile-submenu-toggle" onclick="toggleMobileSubmenu(this)">
                    <span>Arts funéraires</span>
                    <i class="bi bi-chevron-compact-down"></i>
                </div>
                <ul class="mobile-submenu">
                    <li><a href="{{ route('pompe.cercueil') }}" >Cercueil</a></li>
                    <li><a href="{{ route('pompe.gerbes_fleurs') }}" >Gerbe de fleures</a></li>
                    <li><a href="{{ route('marbreries.index') }}" >Marbreries</a></li>
                    <li><a href="" >Rites & pratiques</a></li>
                </ul>
            </li>
            <li><a href="{{ route('morgue.index') }}" >Morgues</a></li>
            <li><a href="{{ route('contact.index') }}" >Contact</a></li>
        </ul>
    </div>

    <!-- Body Inner -->
    <div class="body-inner">
        @yield("container")

        <!-- Footer -->
        <footer id="footer" class="inverted d-print-none">
            <div class="footer-content">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="widget">
                                        <div class="widget-title" style="text-transform: uppercase !important;">{{ $setting->name_entreprise }}</div>
                                        <ul class="list">
                                            <li><a href="" >Qui sommes-nous ?</a></li>
                                            <li><a href="" >Nous contacter</a></li>
                                            <li><a href="" >Emploi</a></li>
                                        </ul>
                                    </div>

                                </div>
                                <div class="col-md-4">
                                    <div class="widget">
                                        <div class="widget-title">Obsèques</div>
                                        <ul class="list">
                                            <li><a href="" >Avis de décès</a></li>
                                            <li><a href="" wire:navigate>Aides</a></li>
                                            <li><a href="" wire:navigate>Pompes funèbres</a></li>
                                        </ul>
                                    </div>

                                </div>
                                <div class="col-md-4">
                                    <div class="widget">
                                        <div class="widget-title">Contactez-nous</div>
                                        <ul class="list">
                                            <li>{{ $setting->localisation }}</li>
                                            <li><i class="fa fa-mobile-alt fa-fw"></i> <a href="tel:+{{ $setting->indicatif }} {{ $setting->telephone_whatsapp }}">{{ $setting->indicatif }} {{ $setting->telephone_whatsapp }}</a></li>
                                            <li style="margin-bottom:20px"><i class="fa fa-envelope fa-fw"></i> <a href="mailto:{{ $setting->email }}">{{ $setting->email }}</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="copyright-content">
                <div class="container">
                    <div class="copyright-text text-center">&copy; {{ date('Y') }} <a href="" style="text-transform: uppercase !important;">{{ $setting->name_entreprise }}</a> - Tous droits réservés - <a href="">Condition d'utilisation</a></div>
                </div>
            </div>
        </footer>
        <!-- end: Footer -->
    </div>
    <!-- end: Body Inner -->

    <!-- Scroll top -->
    <a id="scrollTop" class="d-print-none"><i class="icon-chevron-up"></i><i class="icon-chevron-up"></i></a>

        <!--Plugins-->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" ></script>
    <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
    <script src="{{ asset('assets/plugins/popper/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins.js') }}" defer></script>
    <script src="{{ asset('assets/js/functions.js') }}" defer></script>
    <script src="{{ asset('assets/js/google-places.js') }}"></script>
    <script src="{{ asset('assets/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('assets/js/infinite-scroll.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap-switch/bootstrap-switch.min.js') }}"></script>

    <!-- Lightbox -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.min.js"></script>

    <script>
    // ================= MENU DROPDOWN AU CLIC - CORRIGÉ =================
    document.addEventListener('DOMContentLoaded', function() {

        // Fermer les dropdowns quand on clique ailleurs
        document.addEventListener('click', function(e) {
            const openDropdowns = document.querySelectorAll('.menu_principal .has-submenu.open');
            openDropdowns.forEach(function(dropdown) {
                if (!dropdown.contains(e.target)) {
                    dropdown.classList.remove('open');
                }
            });
        });

        // Gestion des dropdowns desktop
        const submenuToggles = document.querySelectorAll('.menu_principal .has-submenu > a');
        submenuToggles.forEach(function(toggle) {
            toggle.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();

                const parent = this.closest('.has-submenu');
                const isOpen = parent.classList.contains('open');

                // Fermer tous les autres dropdowns
                document.querySelectorAll('.menu_principal .has-submenu.open').forEach(function(d) {
                    d.classList.remove('open');
                });

                // Toggle le dropdown cliqué
                if (!isOpen) {
                    parent.classList.add('open');
                }
            });
        });
    });

    // ================= MENU MOBILE - CORRIGÉ =================
    function toggleMobileMenu() {
        const overlay = document.getElementById('mobileMenuOverlay');
        const panel = document.getElementById('mobileMenuPanel');
        const hamburger = document.getElementById('hamburgerBtn');

        const isOpen = panel.classList.contains('open');

        if (isOpen) {
            // Fermer
            overlay.classList.remove('active');
            panel.classList.remove('open');
            if (hamburger) hamburger.classList.remove('active');
            document.body.style.overflow = '';
        } else {
            // Ouvrir
            overlay.classList.add('active');
            panel.classList.add('open');
            if (hamburger) hamburger.classList.add('active');
            document.body.style.overflow = 'hidden';
        }
    }

    function closeMobileMenu() {
        const overlay = document.getElementById('mobileMenuOverlay');
        const panel = document.getElementById('mobileMenuPanel');
        const hamburger = document.getElementById('hamburgerBtn');

        overlay.classList.remove('active');
        panel.classList.remove('open');
        if (hamburger) hamburger.classList.remove('active');
        document.body.style.overflow = '';
    }

    function openMobileMenu() {
        const overlay = document.getElementById('mobileMenuOverlay');
        const panel = document.getElementById('mobileMenuPanel');
        const hamburger = document.getElementById('hamburgerBtn');

        overlay.classList.add('active');
        panel.classList.add('open');
        if (hamburger) hamburger.classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function toggleMobileSubmenu(element) {
        element.classList.toggle('open');
        const submenu = element.nextElementSibling;
        if (submenu && submenu.classList.contains('mobile-submenu')) {
            submenu.classList.toggle('open');
        }
    }

    // ================= FAQ ACCORDÉON =================
    function toggleFaq(element) {
        const item = element.closest('.faq-item');
        const isActive = item.classList.contains('active');

        // Fermer tous les autres
        document.querySelectorAll('.faq-item.active').forEach(function(faq) {
            if (faq !== item) faq.classList.remove('active');
        });

        // Toggle l'élément cliqué
        item.classList.toggle('active');
    }

    // ================= SCROLL TO TOP =================
    document.addEventListener('DOMContentLoaded', function() {
        const scrollTopBtn = document.getElementById('scrollTop');

        window.addEventListener('scroll', function() {
            if (window.pageYOffset > 300) {
                scrollTopBtn.classList.add('visible');
            } else {
                scrollTopBtn.classList.remove('visible');
            }
        });

        scrollTopBtn.addEventListener('click', function(e) {
            e.preventDefault();
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    });

    // ================= PAGE LOADER =================
    window.addEventListener('load', function() {
        const loader = document.getElementById('page-loader');
        if (loader) {
            setTimeout(function() {
                loader.classList.add('hidden');
            }, 800);
        }
    });

    // ================= JQUERY EXISTANT =================
    jQuery(document).ready(function() {
        $('#form-rappel').submit(function(e) { e.preventDefault(); $('#modal-rappel').modal('hide'); });
        $('#form-urgence').submit(function(e) { e.preventDefault(); $('#modal-urgence').modal('hide'); });
        $('#form-prevoyance').submit(function(e) { e.preventDefault(); $('#modal-prevoyance').modal('hide'); });

        $(window).scroll(function() {
            if($(window).scrollTop() > 20) { $('#footer-phone').addClass('montre'); }
            else { $('#footer-phone').removeClass('montre'); }
        });

        $(".fermer-64").click(function(e) {
            Cookies.set('alert-box-64', 'closed', { expires: 0.5,path: '/' });
            $('.alert-64').hide();
            $("#modalStripSecondary").removeClass("modal-active");
        });

        $('.owl-carousel').owlCarousel({
            loop:true, margin:10, responsiveClass:true, dots:true, autoplay: true,
            autoplayHoverPause:true, autoHeight:true,
            responsive:{ 0:{ items:1 }, 600:{ items:2 }, 1000:{ items:3 } }
        });

        var maxLength = 250;
        $(".show-read-more").each(function(){
            var myStr = $(this).text();
            if($.trim(myStr).length > maxLength){
                var newStr = myStr.substring(0, maxLength);
                newStr = newStr.substr(0, Math.min(newStr.length, newStr.lastIndexOf(" ")));
                var removedStr = myStr.substring(maxLength, $.trim(myStr).length);
                $(this).empty().html(newStr);
                $(this).append('... <a href="javascript:void(0);" class="read-more">Lire la suite</a>');
                $(this).append('<span class="more-text">' + removedStr + '</span>');
            }
        });
        $(".read-more").click(function(){
            $(this).siblings(".more-text").contents().unwrap();
            $(this).remove();
        });

        $(document).on("click", '[data-toggle="lightbox"]', function(event) {
            event.preventDefault();
            $(this).ekkoLightbox();
        });
    });
    </script>

    @stack("scripts")
    @livewireScripts()
</body>
</html>
