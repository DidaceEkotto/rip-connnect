@extends("layouts.front.template_front")
@php
    $setting = \App\Models\Setting::first();
    $title = $dece->nom. ' '. $dece->prenom. " programme des obsèque :: ". $setting->name_entreprise;
    $title2 = $dece->nom. ' '. $dece->prenom. " programme des obsèque ";
@endphp


@push("css")
     <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #8b7355;
            --accent-gold: #c9a96e;
            --bg-light: #f8f9fa;
            --text-dark: #2c3e50;
            --text-muted: #6c757d;
            --border-light: #e9ecef;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Lato', sans-serif;
            background-color: #f5f5f0;
            color: var(--text-dark);
            line-height: 1.7;
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: 'Playfair Display', serif;
            font-weight: 600;
        }

        /* Hero Section */
        .hero-section {
            background: linear-gradient(135deg, #2c3e50 0%, #34495e 50%, #2c3e50 100%);
            position: relative;
            overflow: hidden;
            padding: 80px 0 60px;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            opacity: 0.5;
        }

        .hero-content {
            position: relative;
            z-index: 1;
        }

        .deceased-photo-wrapper {
            position: relative;
            display: inline-block;
        }

        .deceased-photo {
            width: 220px;
            height: 220px;
            object-fit: cover;
            border-radius: 50%;
            border: 5px solid rgba(255,255,255,0.2);
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            transition: transform 0.3s ease;
        }

        .deceased-photo:hover {
            transform: scale(1.02);
        }

        .photo-frame {
            position: absolute;
            top: -10px;
            left: -10px;
            right: -10px;
            bottom: -10px;
            border: 2px solid var(--accent-gold);
            border-radius: 50%;
            opacity: 0.6;
        }

        .cross-icon {
            color: var(--accent-gold);
            font-size: 2rem;
            margin-bottom: 15px;
            opacity: 0.8;
        }

        .deceased-name {
            font-size: 2.8rem;
            color: #fff;
            margin-bottom: 5px;
            letter-spacing: 1px;
        }

        .dates-info {
            color: rgba(255,255,255,0.8);
            font-size: 1.1rem;
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        .dates-divider {
            display: inline-block;
            width: 40px;
            height: 1px;
            background: var(--accent-gold);
            vertical-align: middle;
            margin: 0 15px;
        }

        .age-badge {
            display: inline-block;
            background: rgba(201, 169, 110, 0.2);
            border: 1px solid var(--accent-gold);
            color: var(--accent-gold);
            padding: 5px 20px;
            border-radius: 30px;
            font-size: 0.9rem;
            margin-top: 15px;
            letter-spacing: 1px;
        }

        /* Section Headers */
        .section-header {
            text-align: center;
            margin-bottom: 40px;
            position: relative;
        }

        .section-header h2 {
            font-size: 2rem;
            color: var(--primary-color);
            display: inline-block;
            padding-bottom: 15px;
        }

        .section-header::after {
            content: '';
            display: block;
            width: 60px;
            height: 3px;
            background: var(--accent-gold);
            margin: 0 auto;
        }

        /* Info Cards */
        .info-card {
            background: #fff;
            border-radius: 16px;
            padding: 35px;
            box-shadow: 0 5px 30px rgba(0,0,0,0.06);
            border: none;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            height: 100%;
        }

        .info-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0,0,0,0.1);
        }

        .info-icon {
            width: 55px;
            height: 55px;
            background: linear-gradient(135deg, var(--primary-color), #34495e);
            color: #fff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            margin-bottom: 20px;
        }

        .info-label {
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: var(--text-muted);
            margin-bottom: 8px;
            font-weight: 700;
        }

        .info-value {
            font-size: 1.15rem;
            color: var(--text-dark);
            font-weight: 500;
            font-family: 'Playfair Display', serif;
        }

        /* Circumstances Section */
        .circumstances-section {
            background: #fff;
            border-radius: 16px;
            padding: 40px;
            box-shadow: 0 5px 30px rgba(0,0,0,0.06);
            position: relative;
            overflow: hidden;
        }

        .circumstances-section::before {
            content: '"';
            position: absolute;
            top: -20px;
            left: 20px;
            font-family: 'Playfair Display', serif;
            font-size: 10rem;
            color: var(--accent-gold);
            opacity: 0.1;
            line-height: 1;
        }

        /* Tabs Customization */
        .custom-tabs {
            border-bottom: 2px solid var(--border-light);
            margin-bottom: 30px;
        }

        .custom-tabs .nav-link {
            border: none;
            color: var(--text-muted);
            font-weight: 600;
            padding: 15px 30px;
            position: relative;
            font-family: 'Playfair Display', serif;
            font-size: 1.1rem;
            letter-spacing: 0.5px;
        }

        .custom-tabs .nav-link:hover {
            color: var(--primary-color);
            border: none;
        }

        .custom-tabs .nav-link.active {
            color: var(--primary-color);
            background: none;
            border: none;
        }

        .custom-tabs .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            right: 0;
            height: 3px;
            background: var(--accent-gold);
        }

        /* Gallery */
        .gallery-item {
            position: relative;
            overflow: hidden;
            border-radius: 12px;
            cursor: pointer;
            aspect-ratio: 1;
        }

        .gallery-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .gallery-item:hover img {
            transform: scale(1.1);
        }

        .gallery-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(44, 62, 80, 0);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.3s ease;
        }

        .gallery-item:hover .gallery-overlay {
            background: rgba(44, 62, 80, 0.4);
        }

        .gallery-overlay i {
            color: #fff;
            font-size: 2rem;
            opacity: 0;
            transform: scale(0.8);
            transition: all 0.3s ease;
        }

        .gallery-item:hover .gallery-overlay i {
            opacity: 1;
            transform: scale(1);
        }

        /* Lightbox */
        .lightbox {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.95);
            z-index: 9999;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }

        .lightbox.active {
            display: flex;
        }

        .lightbox img {
            max-width: 90%;
            max-height: 80vh;
            border-radius: 8px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.5);
        }

        .lightbox-close {
            position: absolute;
            top: 30px;
            right: 40px;
            color: #fff;
            font-size: 2.5rem;
            cursor: pointer;
            background: none;
            border: none;
            transition: color 0.3s;
        }

        .lightbox-close:hover {
            color: var(--accent-gold);
        }

        .lightbox-nav {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            color: #fff;
            font-size: 2rem;
            cursor: pointer;
            background: rgba(255,255,255,0.1);
            border: none;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.3s;
        }

        .lightbox-nav:hover {
            background: rgba(255,255,255,0.3);
        }

        .lightbox-prev { left: 30px; }
        .lightbox-next { right: 30px; }

        /* Condolences */
        .condolence-card {
            background: #fff;
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 20px;
            box-shadow: 0 3px 15px rgba(0,0,0,0.04);
            border-left: 4px solid var(--accent-gold);
            transition: transform 0.2s;
        }

        .condolence-card:hover {
            transform: translateX(5px);
        }

        .condolence-author {
            font-weight: 700;
            color: var(--primary-color);
            font-family: 'Playfair Display', serif;
            font-size: 1.1rem;
        }

        .condolence-meta {
            font-size: 0.85rem;
            color: var(--text-muted);
            margin-bottom: 10px;
        }

        .condolence-text {
            color: #555;
            font-style: italic;
            line-height: 1.8;
        }

        /* Form Styling */
        .form-section {
            background: #fff;
            border-radius: 16px;
            padding: 40px;
            box-shadow: 0 5px 30px rgba(0,0,0,0.06);
        }

        .form-control, .form-select {
            border: 2px solid var(--border-light);
            border-radius: 10px;
            padding: 12px 18px;
            font-size: 1rem;
            transition: all 0.3s;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--accent-gold);
            box-shadow: 0 0 0 0.2rem rgba(201, 169, 110, 0.15);
        }

        .form-label {
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 8px;
            font-size: 0.95rem;
        }

        .btn-submit {
            background: linear-gradient(135deg, var(--primary-color), #34495e);
            color: #fff;
            border: none;
            padding: 14px 40px;
            border-radius: 30px;
            font-weight: 600;
            letter-spacing: 1px;
            text-transform: uppercase;
            font-size: 0.9rem;
            transition: all 0.3s;
            box-shadow: 0 5px 20px rgba(44, 62, 80, 0.3);
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(44, 62, 80, 0.4);
            color: #fff;
        }

        /* Select2 Custom */
        .select2-container--default .select2-selection--single {
            height: 48px;
            border: 2px solid var(--border-light);
            border-radius: 10px;
            display: flex;
            align-items: center;
            padding-left: 10px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 46px;
        }

        .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background-color: var(--primary-color);
        }

        /* Death Notice */
        .notice-card {
            background: #fff;
            border-radius: 16px;
            padding: 50px;
            box-shadow: 0 5px 30px rgba(0,0,0,0.06);
            text-align: center;
            position: relative;
            border: 1px solid var(--border-light);
        }

        .notice-card::before,
        .notice-card::after {
            content: '';
            position: absolute;
            width: 80px;
            height: 80px;
            border: 2px solid var(--accent-gold);
            opacity: 0.3;
        }

        .notice-card::before {
            top: 20px;
            left: 20px;
            border-right: none;
            border-bottom: none;
        }

        .notice-card::after {
            bottom: 20px;
            right: 20px;
            border-left: none;
            border-top: none;
        }

        .notice-title {
            font-size: 2.2rem;
            margin-bottom: 30px;
            color: var(--primary-color);
        }

        .notice-content {
            font-family: 'Playfair Display', serif;
            font-size: 1.2rem;
            line-height: 2;
            color: #444;
            max-width: 700px;
            margin: 0 auto 30px;
        }

        .btn-download {
            background: transparent;
            color: var(--primary-color);
            border: 2px solid var(--primary-color);
            padding: 12px 35px;
            border-radius: 30px;
            font-weight: 600;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
        }

        .btn-download:hover {
            background: var(--primary-color);
            color: #fff;
            transform: translateY(-2px);
        }

        /* Footer */
        .site-footer {
            background: var(--primary-color);
            color: rgba(255,255,255,0.7);
            padding: 40px 0;
            text-align: center;
            margin-top: 80px;
        }

        .site-footer p {
            margin: 0;
            font-size: 0.9rem;
        }

        /* Animations */
        .fade-in {
            animation: fadeIn 0.8s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .deceased-name { font-size: 2rem; }
            .hero-section { padding: 50px 0 40px; }
            .deceased-photo { width: 160px; height: 160px; }
            .notice-card { padding: 30px 20px; }
            .lightbox-nav { display: none; }
        }
    </style>
@endpush
@section("container")
@include("layouts.front.header",['setting'=>$setting])


    @livewire("dece.details-deces",['dece'=>$dece,"page"=>request()->fullUrl()])


@endsection
@push("scripts")
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery (required for Select2) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>


        // Initialize Select2
        $(document).ready(function() {
            $('#countrySelect').select2({
                placeholder: 'Sélectionnez votre pays',
                allowClear: true,
                width: '100%'
            });
        });

        // Form submission
        document.getElementById('condolenceForm').addEventListener('submit', function(e) {
            e.preventDefault();
            alert('Merci pour votre message. Votre condoléance sera publiée après modération.');
            this.reset();
            $('#countrySelect').val(null).trigger('change');
        });

        // Fade in animation on scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        document.querySelectorAll('.info-card, .condolence-card, .gallery-item').forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(20px)';
            el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            observer.observe(el);
        });
    </script>
@endpush
