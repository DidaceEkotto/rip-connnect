<?php

use App\Models\Morgue;
use App\Models\Commentaire;
use Livewire\Component;
use Livewire\Attributes\Layout;

new class extends Component
{
    public Morgue $morgue;

    // Formulaire avis
    public string $nom = '';
    public string $email = '';
    public int $note = 5;
    public string $commentaire = '';

    // Formulaire contact
    public string $contactNom = '';
    public string $contactEmail = '';
    public string $contactTelephone = '';
    public string $contactSujet = '';
    public string $contactMessage = '';
    public string $contactType = 'renseignement';

    public bool $avisEnvoye = false;
    public bool $messageEnvoye = false;

    public function mount(Morgue $morgue)
    {
        $this->morgue = $morgue->load(['ville', 'commentaires' => function($q) {
            $q->where('approuve', true)->latest();
        }, 'services', 'galerie']);
    }

    public function soumettreAvis()
    {
        $this->validate([
            'nom' => 'required|string|max:100',
            'email' => 'required|email|max:255',
            'note' => 'required|integer|min:1|max:5',
            'commentaire' => 'required|string|min:10|max:1000',
        ]);

        $this->morgue->commentaires()->create([
            'nom' => $this->nom,
            'email' => $this->email,
            'note' => $this->note,
            'commentaire' => $this->commentaire,
            'approuve' => false, // modération
        ]);

        $this->reset(['nom', 'email', 'note', 'commentaire']);
        $this->avisEnvoye = true;
    }

    public function soumettreContact()
    {
        $this->validate([
            'contactNom' => 'required|string|max:100',
            'contactEmail' => 'required|email|max:255',
            'contactTelephone' => 'nullable|string|max:20',
            'contactSujet' => 'required|string|max:200',
            'contactMessage' => 'required|string|min:20|max:2000',
            'contactType' => 'required|in:renseignement,devis,prestation,autre',
        ]);

        // Ici tu peux envoyer un mail ou sauvegarder en BDD
        // Mail::to($this->morgue->email)->send(new ContactMorgue(...));

        $this->reset(['contactNom', 'contactEmail', 'contactTelephone', 'contactSujet', 'contactMessage', 'contactType']);
        $this->messageEnvoye = true;
    }

    public function getNoteMoyenneProperty()
    {
        $commentaires = $this->morgue->commentaires->where('approuve', true);
        if ($commentaires->isEmpty()) return 0;
        return round($commentaires->avg('note'), 1);
    }

    public function getTotalAvisProperty()
    {
        return $this->morgue->commentaires->where('approuve', true)->count();
    }
};
?>

<div>
    <!-- ===== HERO SECTION ===== -->
    <section class="morgue-hero position-relative">
        <div class="hero-overlay"></div>
        <div class="hero-bg" style="background-image: url('{{ asset($morgue->banniere ?? $morgue->logo ?? 'images/default-banner.jpg') }}')"></div>
        <div class="container position-relative z-2 py-5">
            <div class="row align-items-end min-vh-50">
                <div class="col-lg-8">
                    <nav aria-label="breadcrumb" class="mb-3">
                        <ol class="breadcrumb breadcrumb-dark">
                            <li class="breadcrumb-item"><a href="{{ route('homePage') }}" class="text-white-50">Accueil</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('morgue.index') }}" class="text-white-50">Morgues</a></li>
                            <li class="breadcrumb-item active text-white" aria-current="page">{{ $morgue->nom }}</li>
                        </ol>
                    </nav>
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <img src="{{ asset($morgue->logo ?? 'images/default-logo.png') }}"
                             alt="{{ $morgue->nom }}"
                             class="morgue-logo rounded-3 shadow"
                             onerror="this.src='https://via.placeholder.com/80?text=M'">
                        <div>
                            <h1 class="display-5 fw-bold text-white mb-1">{{ $morgue->nom }}</h1>
                            <p class="text-white-75 mb-0 fs-5">
                                <i class="fas fa-map-marker-alt me-2"></i>{{ $morgue->adresse }}, {{ $morgue->ville->name }}
                            </p>
                        </div>
                    </div>

                    <!-- Badges & Note -->
                    <div class="d-flex flex-wrap align-items-center gap-3 mt-4">
                        @if($this->noteMoyenne > 0)
                        <div class="badge-rating d-flex align-items-center gap-2 bg-white bg-opacity-10 backdrop-blur rounded-pill px-4 py-2">
                            <span class="fw-bold fs-4 text-white">{{ $this->noteMoyenne }}</span>
                            <div class="stars text-warning">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star {{ $i <= round($this->noteMoyenne) ? '' : 'text-white-25' }} small"></i>
                                @endfor
                            </div>
                            <span class="text-white-75 small">({{ $this->totalAvis }} avis)</span>
                        </div>
                        @endif

                        @if($morgue->est_ouverte_24h)
                        <span class="badge bg-success bg-opacity-25 text-success border border-success border-opacity-25 rounded-pill px-3 py-2">
                            <i class="fas fa-clock me-1"></i> Ouvert 24h/24
                        </span>
                        @endif

                        @if($morgue->parking_disponible)
                        <span class="badge bg-info bg-opacity-25 text-info border border-info border-opacity-25 rounded-pill px-3 py-2">
                            <i class="fas fa-parking me-1"></i> Parking
                        </span>
                        @endif

                        <span class="badge bg-white bg-opacity-10 text-white border border-white border-opacity-20 rounded-pill px-3 py-2">
                            <i class="fas fa-certificate me-1"></i> Agréée
                        </span>
                    </div>
                </div>

                <!-- Boutons d'action rapide -->
                <div class="col-lg-4 text-lg-end mt-4 mt-lg-0">
                    <div class="d-flex flex-column gap-2">
                        <a href="tel:{{ $morgue->telephone }}" class="btn btn-light btn-lg rounded-pill fw-semibold shadow-sm">
                            <i class="fas fa-phone me-2"></i>{{ $morgue->telephone }}
                        </a>
                        <a href="#contact" class="btn btn-outline-light btn-lg rounded-pill fw-semibold">
                            <i class="fas fa-envelope me-2"></i>Nous contacter
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Vague décorative -->
        <div class="hero-wave">
            <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 120L60 110C120 100 240 80 360 70C480 60 600 60 720 65C840 70 960 80 1080 85C1200 90 1320 90 1380 90L1440 90V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0Z" fill="#f8f9fa"/>
            </svg>
        </div>
    </section>

    <!-- ===== CONTENU PRINCIPAL ===== -->
    <div class="container py-5">
        <div class="row g-5">

            <!-- COLONNE GAUCHE -->
            <div class="col-lg-8">

                <!-- À propos -->
                <section class="mb-5">
                    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                        <div class="card-body p-4 p-md-5">
                            <h2 class="fw-bold mb-4 d-flex align-items-center gap-2">
                                <span class="icon-circle bg-primary bg-opacity-10 text-primary">
                                    <i class="fas fa-info"></i>
                                </span>
                                À propos
                            </h2>
                            <p class="lead text-muted mb-4">{!! $morgue->description ?? 'Aucune description disponible pour cet établissement.' !!}</p>

                            @if($morgue->services && $morgue->services->count() > 0)
                            <div class="row g-3 mt-2">
                                @foreach($morgue->services as $service)
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center gap-3 p-3 rounded-3 bg-light">
                                        <div class="flex-shrink-0">
                                            <span class="icon-circle-sm bg-white text-primary shadow-sm">
                                                <i class="fas {{ $service->icone ?? 'fa-check' }}"></i>
                                            </span>
                                        </div>
                                        <div>
                                            <h6 class="fw-semibold mb-0">{{ $service->nom }}</h6>
                                            <p class="text-muted small mb-0">{{ $service->description }}</p>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @else
                            <div class="row g-3 mt-2">
                                @foreach([
                                    ['icon' => 'fa-ambulance', 'title' => 'Transport funéraire', 'desc' => 'Véhicules adaptés et chauffeurs expérimentés'],
                                    ['icon' => 'fa-church', 'title' => 'Chambre funéraire', 'desc' => 'Espaces de recueillement calmes et respectueux'],
                                    ['icon' => 'fa-user-md', 'title' => 'Soins de conservation', 'desc' => 'Présentation digne et respectueuse'],
                                    ['icon' => 'fa-file-signature', 'title' => 'Formalités administratives', 'desc' => 'Accompagnement dans les démarches'],
                                    ['icon' => 'fa-flower', 'title' => 'Fleurs & décorations', 'desc' => 'Compositions florales sur mesure'],
                                    ['icon' => 'fa-pray', 'title' => 'Cérémonies religieuses', 'desc' => 'Toutes confessions respectées'],
                                ] as $service)
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center gap-3 p-3 rounded-3 bg-light hover-lift transition-all">
                                        <div class="flex-shrink-0">
                                            <span class="icon-circle-sm bg-white text-primary shadow-sm">
                                                <i class="fas {{ $service['icon'] }}"></i>
                                            </span>
                                        </div>
                                        <div>
                                            <h6 class="fw-semibold mb-0">{{ $service['title'] }}</h6>
                                            <p class="text-muted small mb-0">{{ $service['desc'] }}</p>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @endif
                        </div>
                    </div>
                </section>

                <!-- Galerie -->
                <section class="mb-5">
                    <h2 class="fw-bold mb-4 d-flex align-items-center gap-2">
                        <span class="icon-circle bg-primary bg-opacity-10 text-primary">
                            <i class="fas fa-images"></i>
                        </span>
                        Galerie photos
                    </h2>
                    <div class="row g-3">
                        @if($morgue->galerie && $morgue->galerie->count() > 0)
                            @foreach($morgue->galerie as $photo)
                            <div class="col-6 col-md-4">
                                <div class="gallery-item rounded-4 overflow-hidden shadow-sm position-relative cursor-pointer" onclick="openLightbox('{{ asset($photo->chemin) }}')">
                                    <img src="{{ asset($photo->chemin) }}" class="w-100 h-100 object-fit-cover" style="height: 200px;" alt="{{ $photo->legende }}">
                                    <div class="gallery-overlay d-flex align-items-center justify-content-center">
                                        <i class="fas fa-expand text-white fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @else
                            @foreach([
                                'https://images.unsplash.com/photo-1544126592-807ade215a0b?w=400&h=300&fit=crop',
                                'https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?w=400&h=300&fit=crop',
                                'https://images.unsplash.com/photo-1497366216548-37526070297c?w=400&h=300&fit=crop',
                                'https://images.unsplash.com/photo-1497366811353-6870744d04b2?w=400&h=300&fit=crop',
                                'https://images.unsplash.com/photo-1524758631624-e2822e304c36?w=400&h=300&fit=crop',
                                'https://images.unsplash.com/photo-1497215728101-856f4ea42174?w=400&h=300&fit=crop',
                            ] as $img)
                            <div class="col-6 col-md-4">
                                <div class="gallery-item rounded-4 overflow-hidden shadow-sm position-relative cursor-pointer" onclick="openLightbox('{{ $img }}')">
                                    <img src="{{ $img }}" class="w-100 h-100 object-fit-cover" style="height: 200px;" alt="Galerie">
                                    <div class="gallery-overlay d-flex align-items-center justify-content-center">
                                        <i class="fas fa-expand text-white fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @endif
                    </div>
                </section>

                <!-- Horaires -->
                <section class="mb-5">
                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-body p-4 p-md-5">
                            <h2 class="fw-bold mb-4 d-flex align-items-center gap-2">
                                <span class="icon-circle bg-primary bg-opacity-10 text-primary">
                                    <i class="fas fa-clock"></i>
                                </span>
                                Horaires d'ouverture
                            </h2>
                            <div class="row g-3">
                                @php
                                $jours = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];
                                $horaires = $morgue->horaires ?? [];
                                @endphp
                                @foreach($jours as $jour)
                                @php
                                    $aujourdhui = now()->locale('fr')->dayName === $jour;
                                    $horaire = $horaires[$loop->index] ?? ['ouverture' => '08:00', 'fermeture' => '18:00', 'ouvert' => true];
                                @endphp
                                <div class="col-md-6">
                                    <div class="d-flex justify-content-between align-items-center p-3 rounded-3 {{ $aujourdhui ? 'bg-primary bg-opacity-10 border border-primary border-opacity-25' : 'bg-light' }}">
                                        <span class="fw-medium {{ $aujourdhui ? 'text-primary' : '' }}">
                                            {{ $jour }} @if($aujourdhui)<span class="badge bg-primary ms-2">Aujourd'hui</span>@endif
                                        </span>
                                        <span class="text-muted">
                                            @if($horaire['ouvert'] ?? true)
                                                {{ $horaire['ouverture'] }} - {{ $horaire['fermeture'] }}
                                            @else
                                                <span class="text-danger">Fermé</span>
                                            @endif
                                        </span>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Avis clients -->
                <section class="mb-5" id="avis">
                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-body p-4 p-md-5">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h2 class="fw-bold mb-0 d-flex align-items-center gap-2">
                                    <span class="icon-circle bg-primary bg-opacity-10 text-primary">
                                        <i class="fas fa-star"></i>
                                    </span>
                                    Avis clients
                                </h2>
                                @if($this->totalAvis > 0)
                                <div class="d-flex align-items-center gap-2">
                                    <span class="display-6 fw-bold text-primary">{{ $this->noteMoyenne }}</span>
                                    <div class="text-warning">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star {{ $i <= round($this->noteMoyenne) ? '' : 'text-muted' }} small"></i>
                                        @endfor
                                    </div>
                                </div>
                                @endif
                            </div>

                            @if($this->totalAvis > 0)
                            <div class="row g-4 mb-5">
                                @foreach($morgue->commentaires->where('approuve', true)->take(6) as $avis)
                                <div class="col-md-6">
                                    <div class="p-4 rounded-4 bg-light h-100">
                                        <div class="d-flex align-items-center gap-3 mb-3">
                                            <div class="avatar-circle bg-primary text-white fw-bold">
                                                {{ strtoupper(substr($avis->nom, 0, 1)) }}
                                            </div>
                                            <div>
                                                <h6 class="fw-semibold mb-0">{{ $avis->nom }}</h6>
                                                <div class="text-warning small">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        <i class="fas fa-star {{ $i <= $avis->note ? '' : 'text-muted opacity-25' }}"></i>
                                                    @endfor
                                                </div>
                                            </div>
                                            <span class="text-muted small ms-auto">{{ $avis->created_at->diffForHumans() }}</span>
                                        </div>
                                        <p class="text-muted mb-0">"{{ $avis->commentaire }}"</p>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @else
                            <div class="text-center py-5 bg-light rounded-4 mb-5">
                                <i class="fas fa-comment-dots fa-3x text-muted opacity-25 mb-3"></i>
                                <p class="text-muted">Soyez le premier à laisser un avis !</p>
                            </div>
                            @endif

                            <!-- Formulaire avis -->
                            <div class="border-top pt-4">
                                <h5 class="fw-bold mb-3">Laisser un avis</h5>
                                @if($avisEnvoye)
                                <div class="alert alert-success rounded-3 d-flex align-items-center gap-2">
                                    <i class="fas fa-check-circle"></i>
                                    <span>Merci ! Votre avis a été soumis et sera publié après modération.</span>
                                </div>
                                @endif
                                <form wire:submit="soumettreAvis" class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-medium">Votre nom</label>
                                        <input type="text" wire:model="nom" class="form-control rounded-3" placeholder="Jean Dupont">
                                        @error('nom') <span class="text-danger small">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-medium">Votre email</label>
                                        <input type="email" wire:model="email" class="form-control rounded-3" placeholder="jean@exemple.com">
                                        @error('email') <span class="text-danger small">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label fw-medium">Note</label>
                                        <div class="star-rating d-flex gap-2">
                                            @for($i = 1; $i <= 5; $i++)
                                            <button type="button"
                                                    wire:click="$set('note', {{ $i }})"
                                                    class="btn btn-link p-0 text-decoration-none">
                                                <i class="fas fa-star fa-2x {{ $i <= $note ? 'text-warning' : 'text-muted opacity-25' }}"></i>
                                            </button>
                                            @endfor
                                        </div>
                                        @error('note') <span class="text-danger small">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label fw-medium">Votre commentaire</label>
                                        <textarea wire:model="commentaire" rows="4" class="form-control rounded-3" placeholder="Partagez votre expérience..."></textarea>
                                        @error('commentaire') <span class="text-danger small">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary rounded-pill px-4 fw-semibold">
                                            <i class="fas fa-paper-plane me-2"></i>Envoyer mon avis
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </section>

            </div>

            <!-- COLONNE DROITE (STICKY) -->
            <div class="col-lg-4">
                <div class="sticky-top" style="top: 20px; z-index: 1020;">

                    <!-- Carte de contact -->
                    <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
                        <div class="card-header bg-primary text-white p-4 border-0">
                            <h5 class="fw-bold mb-0"><i class="fas fa-address-card me-2"></i>Informations</h5>
                        </div>
                        <div class="card-body p-4">
                            <ul class="list-unstyled mb-0">
                                <li class="d-flex align-items-start gap-3 mb-4">
                                    <span class="icon-circle-sm bg-primary bg-opacity-10 text-primary flex-shrink-0 mt-1">
                                        <i class="fas fa-map-marker-alt"></i>
                                    </span>
                                    <div>
                                        {{-- <span class="text-muted small d-block">Adresse</span> --}}
                                        <span class="fw-medium">{{ $morgue->adresse }}</span>
                                        <span class="text-muted d-block">{{ $morgue->ville->name }}</span>
                                    </div>
                                </li>
                                <li class="d-flex align-items-start gap-3 mb-4">
                                    <span class="icon-circle-sm bg-success bg-opacity-10 text-success flex-shrink-0 mt-1">
                                        <i class="fas fa-phone"></i>
                                    </span>
                                    <div>
                                        <span class="text-muted small d-block">Téléphone</span>
                                        <a href="tel:{{ $morgue->telephone }}" class="fw-medium text-decoration-none">{{ $morgue->telephone }}</a>
                                    </div>
                                </li>
                                @if($morgue->email)
                                <li class="d-flex align-items-start gap-3 mb-4">
                                    <span class="icon-circle-sm bg-info bg-opacity-10 text-info flex-shrink-0 mt-1">
                                        <i class="fas fa-envelope"></i>
                                    </span>
                                    <div>
                                        <span class="text-muted small d-block">Email</span>
                                        <a href="mailto:{{ $morgue->email }}" class="fw-medium text-decoration-none">{{ $morgue->email }}</a>
                                    </div>
                                </li>
                                @endif
                                @if($morgue->site_web)
                                <li class="d-flex align-items-start gap-3 mb-4">
                                    <span class="icon-circle-sm bg-warning bg-opacity-10 text-warning flex-shrink-0 mt-1">
                                        <i class="fas fa-globe"></i>
                                    </span>
                                    <div>
                                        <span class="text-muted small d-block">Site web</span>
                                        <a href="{{ $morgue->site_web }}" target="_blank" class="fw-medium text-decoration-none">{{ $morgue->site_web }}</a>
                                    </div>
                                </li>
                                @endif
                                @if($morgue->whatsapp)
                                <li class="d-flex align-items-start gap-3">
                                    <span class="icon-circle-sm bg-success bg-opacity-10 text-success flex-shrink-0 mt-1">
                                        <i class="fab fa-whatsapp"></i>
                                    </span>
                                    <div>
                                        <span class="text-muted small d-block">WhatsApp</span>
                                        <a href="https://wa.me/{{ $morgue->whatsapp }}" target="_blank" class="fw-medium text-decoration-none">{{ $morgue->whatsapp }}</a>
                                    </div>
                                </li>
                                @endif
                            </ul>

                            <hr class="my-4">

                            <div class="d-grid gap-2">
                                <a href="tel:{{ $morgue->telephone }}" class="btn btn-primary rounded-pill fw-semibold">
                                    <i class="fas fa-phone me-2"></i>Appeler maintenant
                                </a>
                                @if($morgue->whatsapp)
                                <a href="https://wa.me/{{ $morgue->whatsapp }}" target="_blank" class="btn btn-success rounded-pill fw-semibold">
                                    <i class="fab fa-whatsapp me-2"></i>Contacter sur WhatsApp
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Carte géographique -->
                    <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
                        <div class="card-header bg-white p-4 border-bottom">
                            <h5 class="fw-bold mb-0"><i class="fas fa-map me-2 text-primary"></i>Localisation</h5>
                        </div>
                        <div class="card-body p-0">
                            <div wire:ignore id="detailMap" style="height: 300px;"></div>
                        </div>
                        <div class="card-footer bg-white p-3">
                            <a href="https://www.google.com/maps?q={{ $morgue->latitude }},{{ $morgue->longitude }}"
                               target="_blank"
                               class="btn btn-outline-primary w-100 rounded-pill fw-medium">
                                <i class="fas fa-external-link-alt me-2"></i>Ouvrir dans Google Maps
                            </a>
                        </div>
                    </div>

                    <!-- Formulaire de contact rapide -->
                    <div class="card border-0 shadow-sm rounded-4 mb-4" id="contact">
                        <div class="card-header bg-dark text-white p-4 border-0">
                            <h5 class="fw-bold mb-0"><i class="fas fa-paper-plane me-2"></i>Nous contacter</h5>
                        </div>
                        <div class="card-body p-4">
                            @if($messageEnvoye)
                            <div class="alert alert-success rounded-3 d-flex align-items-center gap-2">
                                <i class="fas fa-check-circle"></i>
                                <span>Votre message a bien été envoyé. Nous vous répondrons dans les plus brefs délais.</span>
                            </div>
                            @endif
                            <form wire:submit="soumettreContact" class="row g-3">
                                <div class="col-12">
                                    <label class="form-label small fw-medium">Type de demande</label>
                                    <select wire:model="contactType" class="form-select rounded-3">
                                        <option value="renseignement">Renseignement</option>
                                        <option value="devis">Demande de devis</option>
                                        <option value="prestation">Prestation</option>
                                        <option value="autre">Autre</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <input type="text" wire:model="contactNom" class="form-control rounded-3" placeholder="Votre nom complet *">
                                    @error('contactNom') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-12">
                                    <input type="email" wire:model="contactEmail" class="form-control rounded-3" placeholder="Votre email *">
                                    @error('contactEmail') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-12">
                                    <input type="tel" wire:model="contactTelephone" class="form-control rounded-3" placeholder="Votre téléphone">
                                </div>
                                <div class="col-12">
                                    <input type="text" wire:model="contactSujet" class="form-control rounded-3" placeholder="Sujet *">
                                    @error('contactSujet') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-12">
                                    <textarea wire:model="contactMessage" rows="3" class="form-control rounded-3" placeholder="Votre message *"></textarea>
                                    @error('contactMessage') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-dark w-100 rounded-pill fw-semibold">
                                        <i class="fas fa-paper-plane me-2"></i>Envoyer
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Partager -->
                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-body p-4 text-center">
                            <h6 class="fw-bold mb-3">Partager cette page</h6>
                            <div class="d-flex justify-content-center gap-2">
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}"
                                   target="_blank"
                                   class="btn btn-outline-primary rounded-circle social-btn">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                                <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($morgue->nom) }}"
                                   target="_blank"
                                   class="btn btn-outline-info rounded-circle social-btn">
                                    <i class="fab fa-twitter"></i>
                                </a>
                                <a href="https://wa.me/?text={{ urlencode($morgue->nom . ' - ' . request()->url()) }}"
                                   target="_blank"
                                   class="btn btn-outline-success rounded-circle social-btn">
                                    <i class="fab fa-whatsapp"></i>
                                </a>
                                <button onclick="navigator.clipboard.writeText(window.location.href); this.innerHTML='<i class=\'fas fa-check\'></i>'; setTimeout(()=>this.innerHTML='<i class=\'fas fa-link\'></i>', 2000)"
                                        class="btn btn-outline-secondary rounded-circle social-btn">
                                    <i class="fas fa-link"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Lightbox -->
    <div id="lightbox" class="lightbox" onclick="closeLightbox()">
        <button class="lightbox-close" onclick="closeLightbox()">
            <i class="fas fa-times"></i>
        </button>
        <img id="lightboxImg" src="" alt="">
    </div>

        <script>
        document.addEventListener('livewire:initialized', () => {
            const lat = {{ $morgue->latitude ?? 7.3697 }};
            const lng = {{ $morgue->longitude ?? 12.3547 }};

            const map = L.map('detailMap').setView([lat, lng], 15);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors',
                maxZoom: 19
            }).addTo(map);

            L.marker([lat, lng]).addTo(map)
                .bindPopup('<b>{{ $morgue->nom }}</b><br>{{ $morgue->adresse }}')
                .openPopup();
        });

        function openLightbox(src) {
            document.getElementById('lightboxImg').src = src;
            document.getElementById('lightbox').classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeLightbox() {
            document.getElementById('lightbox').classList.remove('active');
            document.body.style.overflow = '';
        }

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') closeLightbox();
        });
    </script>

</div>
