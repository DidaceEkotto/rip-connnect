@extends('layouts.front.template_front')
@php
    $setting = \App\Models\Setting::first();
    $title = $setting->name_entreprise. ' :: Accueil';
    $title2 = $setting->name_entreprise;
@endphp



@section('container')
@include("layouts.front.header",['setting'=>$setting])

        <!-- ================= SECTION MÉMORIALE ================= -->
        @php
            $dateDeces = !empty($dece->date_dece) ? \Carbon\Carbon::parse($dece->date_dece) : null;
            $dateFr = $dateDeces ? $dateDeces->translatedFormat('l d F Y') : 'Date non précisée';
            $date_naissance = !empty($dece->date_naissance) ? \Carbon\Carbon::parse($dece->date_naissance) : null;
            $date_naissanceFR = $date_naissance ? $date_naissance->translatedFormat('l d F Y') : 'Date non précisée';
        @endphp

        <section class="memorial-section">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-5 col-md-6 mb-4 mb-md-0 fade-in-up">
                        <div class="memorial-card">
                            <div class="memorial-image">
                                <img src="{{ asset($dece->photo) }}" alt="{{ $dece->nom. ' '.$dece->prenom }}">
                                <div class="memorial-overlay">
                                    <h2>{{ $dece->nom. ' '.$dece->prenom }}</h2>
                                    <div class="dates">
                                        ✝️ {{ $date_naissance ? $date_naissance->translatedFormat('d M Y') : '' }} - {{ $dateDeces ? $dateDeces->translatedFormat('d M Y') : '' }}
                                    </div>
                                </div>
                            </div>
                            <div class="memorial-badge">In Memoriam</div>
                        </div>
                    </div>

                    <div class="col-lg-7 col-md-6 fade-in-up">
                        <div class="testimonials-wrapper">
                            <div class="testimonials-header">
                                <h3>Témoignages de ses proches <i class="bi bi-heart-fill"></i></h3>
                            </div>
                            <div class="testimonials-container">
                                <div class="testimonials-scroll" id="testimonialsScroll">
                                    @foreach ($temoignages as $temoignage)
                                        <div class="testimonial-card">
                                            <div class="testimonial-header">
                                                <img src="{{ asset('assets/images/die.png') }}" alt="Avatar" class="testimonial-avatar">
                                                <div class="testimonial-meta">
                                                    <h4>{{ $temoignage->nom . ' '. $temoignage->prenom }}</h4>
                                                    <div class="stars">
                                                        <i class="bi bi-heart-fill"></i>
                                                        <i class="bi bi-heart-fill"></i>
                                                        <i class="bi bi-heart-fill"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <p>"{!! $temoignage->temoignage !!}"</p>
                                        </div>
                                    @endforeach
                                    {{-- Duplicates pour boucle infinie --}}
                                    @foreach ($temoignages as $temoignage)
                                        <div class="testimonial-card">
                                            <div class="testimonial-header">
                                                <img src="{{ asset('assets/images/die.png') }}" alt="Avatar" class="testimonial-avatar">
                                                <div class="testimonial-meta">
                                                    <h4>{{ $temoignage->nom . ' '. $temoignage->prenom }}</h4>
                                                    <div class="stars">
                                                        <i class="bi bi-heart-fill"></i>
                                                        <i class="bi bi-heart-fill"></i>
                                                        <i class="bi bi-heart-fill"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <p>"{!! $temoignage->temoignage !!}"</p>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ================= SECTION MOT DU FONDATEUR ================= -->
        <section class="founder-section">
            <div class="container founder-content">
                <div class="row align-items-center">
                    <div class="col-lg-7 fade-in-up">
                        <div class="founder-quote-icon">
                            <i class="bi bi-card-text"></i>
                        </div>
                        <div class="founder-text">
                            <span class="subtitle">Mot du fondateur</span>
                            <h2>{{ $mots->nom ?? '' }}</h2>
                            <p class="message">{!! $mots->description ?? '' !!}</p>
                            <div class="signature">{{ $mots->nom ?? '' }}</div>
                            <div class="role">{{ $mots->poste ?? '' }}</div>
                        </div>
                    </div>
                    <div class="col-lg-5 fade-in-up">
                        <div class="founder-image-wrapper">
                            <div class="founder-image-bg"></div>
                            <img src="{{ isset($mots->image) ? asset($mots->image) : ''}}" alt="{{ $mots->nom ?? 'Fondateur' }} - {{ $mots->poste ?? '' }}" class="founder-image"/>
                            <div class="founder-badge">{{ $mots->poste ?? '' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ================= À PROPOS ================= -->
        <section id="page-content">
            <div class="container">
                <div class="grid-system-demo-live">
                    <div class="row">
                        <div class="col-md-12 fade-in-up">
                            <div class="heading-text heading-section">
                                <h2>À propos de {{ $setting->name_entreprise }}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="row align-items-center">
                        <div class="col-md-8 fade-in-up">
                            <p>{!! $about->description ?? '' !!}</p>
                        </div>
                        <div class="col-md-4 fade-in-up">
                            <img src="{{ asset('assets/images/rip.png') }}" alt="À propos" style="width: 100% !important;">
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ================= SERVICES ================= -->
        <section class="services-section">
            <div class="container">
                <div class="heading-text heading-section text-center fade-in-up">
                    <h2 style="color: #1e3c72; font-weight: 700; margin-bottom: 15px;">Nos Services Funéraires</h2>
                    <p style="color: #666; font-size: 16px; margin-bottom: 50px;">Des prestations complètes et personnalisées pour vous accompagner dans les moments difficiles</p>
                </div>
                <div class="row">
                    @foreach($services as $service)
                        <div class="col-lg-4 col-md-6 mb-4 fade-in-up">
                            <div class="service-card">
                                <img src="{{ asset($service->image) }}" alt="{{ $service->titre }}">
                                <h3>{{ $service->titre }}</h3>
                                <p>{!! Str::limit($service->description, 167, '...') !!}</p>
                                <a href="{{ route('services.details',['slug'=>$service->slug]) }}">En savoir plus</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- ================= CTA DEVIS ================= -->
        <section class="cta-devis">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-9 fade-in-up">
                        <h2>Obtenez un devis pour vos obsèques</h2>
                        <p>Vous faites face à un décès ou l'un de vos proches est en fin de vie ? Accédez à notre tarificateur en ligne et calculez le prix des obsèques, pour un enterrement au cimetière ou une crémation au crématorium. Devis gratuit et immédiat.</p>
                    </div>
                    <div class="col-lg-3 text-lg-right text-center fade-in-up">
                        <a href="devis-en-ligne.html" class="btn-estimation">Obtenir une estimation</a>
                    </div>
                </div>
            </div>
        </section>

        <!-- ================= PRODUITS ================= -->
        <section class="products-section">
            <div class="container">
                <div class="heading-text heading-section text-center fade-in-up">
                    <h2>Nos Articles Funéraires</h2>
                    <p>Des produits de qualité pour honorer la mémoire de vos proches dans la dignité</p>
                </div>
                <div class="row">
                    @foreach ($produits as $produit)
                        <div class="col-lg-4 col-md-6 mb-4 fade-in-up">
                            <div class="product-card">
                                <div class="product-image">
                                    @if ($produit->images->count() > 0)
                                        <img src="{{ asset($produit->images->first()->path) }}" alt="{{ $produit->name }}" class="img-thumbnail">
                                    @endif
                                    <span class="product-badge">{{ $produit->type_product }}</span>
                                    <div class="product-overlay">
                                        <a href="{{ route('pompe.details.produit',['slug_produit'=>$produit->slug]) }}" class="btn-quick">Voir le détail</a>
                                    </div>
                                </div>
                                <div class="product-info">
                                    <h3>{{ $produit->name }}</h3>
                                    <p>{!! Str::limit($produit->content, 100, '...') !!}</p>
                                    <span class="product-price">{{ number_format($produit->prix, 0, ',', ' ') }} FCFA</span>
                                    <a href="{{ route('pompe.details.produit',['slug_produit'=>$produit->slug]) }}" class="btn-product">Commander</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- ================= AVIS DE DÉCÈS ================= -->
        <section class="background-grey">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 p-b-20">
                        <div class="heading-text heading-line text-center fade-in-up">
                            <h4>Derniers avis de décès</h4>
                        </div>
                        <div class="row team-members team-members-left team-members-shadow m-b-40">
                            @foreach ($morts as $mort)
                                @php
                                    $dateDeces = !empty($mort->date_dece) ? \Carbon\Carbon::parse($mort->date_dece) : null;
                                    $dateFr = $dateDeces ? $dateDeces->translatedFormat('l d F Y') : 'Date non précisée';
                                @endphp
                                <div class="col-md-6 fade-in-up">
                                    <div class="team-member">
                                        <div class="team-image">
                                            <div data-bg-image="{{ asset($mort->photo) }}" style="height:200px;"></div>
                                        </div>
                                        <div class="team-desc">
                                            <h3>{{ $mort->nom. ' '.$mort->prenom }}</h3>
                                            <span>{{ isset($mort->age) ? $mort->age . ' ans' : 'Âge non précisé' }} - {{ $mort->lieu ?? 'Lieu non précisé' }}</span>
                                            <p>Avis de décès publié le {{ $dateFr }}</p>
                                            <div class="align-center">
                                                <a href="{{ route('deces.details',['identifiant'=>$mort->identifiant]) }}" class="btn btn-icon-holder btn-shadow btn-light-hover">Consulter <i class="fa fa-caret-right"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="text-center fade-in-up">
                            <a class="btn icon-left" href="{{ route('deces.index') }}"><span>Voir tous nos avis de décès</span></a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ================= FAQ ================= -->
        <section class="faq-section">
            <div class="container">
                <div class="heading-text heading-section text-center fade-in-up">
                    <h2>Foire aux Questions</h2>
                    <p>Retrouvez les réponses aux questions les plus fréquentes sur nos services funéraires</p>
                </div>
                <div class="faq-container">
                    @foreach ($faqs as $index => $faq)
                        <div class="faq-item fade-in-up" data-faq="{{ $index }}">
                            <div class="faq-question" onclick="toggleFaq(this)">
                                <span>{{ $faq->question }}</span>
                                <div class="faq-icon"><i class="bi bi-chevron-down"></i></div>
                            </div>
                            <div class="faq-answer">
                                {{ $faq->reponse }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

@endsection

@push('js')
<script>
document.addEventListener('DOMContentLoaded', function() {

    // ================= ANIMATIONS AU SCROLL =================
    const fadeElements = document.querySelectorAll('.fade-in-up');

    const observerOptions = {
        root: null,
        rootMargin: '0px',
        threshold: 0.1
    };

    const observer = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    fadeElements.forEach(el => observer.observe(el));

    // ================= FAQ ACCORDÉON =================
    window.toggleFaq = function(element) {
        const item = element.parentElement;
        const isActive = item.classList.contains('active');

        // Fermer tous les autres
        document.querySelectorAll('.faq-item.active').forEach(faq => {
            if (faq !== item) faq.classList.remove('active');
        });

        // Toggle l'élément cliqué
        item.classList.toggle('active');
    };

    // ================= TÉMOIGNAGES SCROLL INFINI =================
    const scrollContainer = document.getElementById('testimonialsScroll');
    if (scrollContainer) {
        let isPaused = false;
        const container = scrollContainer.closest('.testimonials-container');

        container.addEventListener('mouseenter', () => {
            scrollContainer.style.animationPlayState = 'paused';
        });

        container.addEventListener('mouseleave', () => {
            scrollContainer.style.animationPlayState = 'running';
        });

        // Pause au touch sur mobile
        container.addEventListener('touchstart', () => {
            scrollContainer.style.animationPlayState = 'paused';
        });

        container.addEventListener('touchend', () => {
            setTimeout(() => {
                scrollContainer.style.animationPlayState = 'running';
            }, 3000);
        });
    }

    // ================= PARALLAX LÉGER =================
    window.addEventListener('scroll', () => {
        const scrolled = window.pageYOffset;
        const parallaxElements = document.querySelectorAll('.memorial-section::before, .founder-image-bg');

        // Effet parallax sur la section mémoriale
        const memorialSection = document.querySelector('.memorial-section');
        if (memorialSection) {
            const speed = 0.5;
            memorialSection.style.backgroundPosition = `center ${scrolled * speed}px`;
        }
    });

    // ================= SMOOTH SCROLL POUR ANCRES =================
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // ================= COUNTER ANIMATION (optionnel) =================
    function animateCounter(element, target, duration = 2000) {
        let start = 0;
        const increment = target / (duration / 16);

        function updateCounter() {
            start += increment;
            if (start < target) {
                element.textContent = Math.floor(start);
                requestAnimationFrame(updateCounter);
            } else {
                element.textContent = target;
            }
        }

        updateCounter();
    }

});
</script>
@endpush
