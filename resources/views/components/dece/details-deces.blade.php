<?php

use Livewire\Component;
use App\Models\Photo;
use App\Models\Temoignage;

new class extends Component
{
    public $dece, $page, $photos, $temoignages;
    public $nom, $pays, $temoignage;
    public $activeTab = 'details'; // Propriété pour l'onglet actif

    public function mount($dece, $page)
    {
        $this->dece = $dece;
        $this->page = $page;
        $this->loadMyPhotos();
        $this->loadAllTemoignage();
    }

    public function loadMyPhotos()
    {
        $this->photos = Photo::where('dece_id', $this->dece->id)->get();
    }

    public function loadAllTemoignage()
    {
        $this->temoignages = Temoignage::where('dece_id', $this->dece->id)->latest()->get();
    }

    public function saveTemoignage()
    {
        $this->validate([
            "nom" => "required|min:2",
            "pays" => "required",
            "temoignage" => "required|min:3"
        ], [
            "nom.required" => "Veuillez entrer votre nom complet",
            "nom.min" => "Le nom doit contenir au moins deux caractères",
            "pays.required" => "Veuillez sélectionner votre pays",
            "temoignage.required" => "Veuillez écrire votre message",
            "temoignage.min" => "Le message doit contenir au moins trois caractères"
        ]);

        $avis = new Temoignage();
        $avis->identifiant = uniqid();
        $avis->dece_id = $this->dece->id;
        $avis->nom = $this->nom;
        $avis->pays = $this->pays;
        $avis->temoignage = $this->temoignage;
        $avis->save();

        // Réinitialisation correcte des propriétés
        $this->reset(['nom', 'temoignage']);
        $this->pays = '';

        // Recharger les témoignages
        $this->loadAllTemoignage();

        // Garder l'onglet actif sur "condoleances"
        $this->activeTab = 'condoleances';

        // Message de succès
        session()->flash('message', 'Votre témoignage a été envoyé avec succès.');

        // Dispatch un événement pour réinitialiser Select2
        $this->dispatch('reset-select2');
    }

    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
    }
};
?>

<div>
    <!-- Hero Section -->
    @php
        $dateDeces = !empty($dece->date_dece) ? \Carbon\Carbon::parse($dece->date_dece) : null;
        $dateFr = $dateDeces ? $dateDeces->translatedFormat('l d F Y') : 'Date non précisée';

        //date de naissance
        $date_naissance = !empty($dece->date_naissance) ? \Carbon\Carbon::parse($dece->date_naissance) : null;
        $date_naissanceFR = $date_naissance ? $date_naissance->translatedFormat('l d F Y') : 'Date non précisée';

        //Date de la levé
        $date_leve = !empty($dece->date_leve) ? \Carbon\Carbon::parse($dece->date_leve) : null;
        $date_leveFR = $date_leve ? $date_leve->translatedFormat('l d F Y') : 'Date non précisée';
    @endphp

    <section class="hero-section">
        <div class="container text-center hero-content">
            <div class="mb-4">
                <i class="bi bi-cross cross-icon"></i>
            </div>
            <div class="deceased-photo-wrapper mb-4">
                <div class="photo-frame"></div>
                <img src="{{ asset($dece->photo) }}"
                     alt="{{ $dece->nom . ' ' . $dece->prenom }}"
                     class="deceased-photo">
            </div>
            <h1 class="deceased-name">{{ $dece->nom . ' ' . $dece->prenom }}</h1>
            <p class="dates-info">
                {{ $date_naissance ? $date_naissance->translatedFormat('d M Y') : 'Date non précisée' }}
                <span class="dates-divider"></span>
                {{ $dateDeces ? $dateDeces->translatedFormat('d M Y') : 'Date non précisée' }}
            </p>
            <div class="age-badge">
                <i class="bi bi-heart-fill me-2" style="font-size: 0.7rem;"></i>
                {{ $dece->age }} Ans
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <div class="container my-5">
        <!-- Information Cards -->
        <div class="row g-4 mb-5 fade-in">
            <div class="col-md-4">
                <div class="info-card text-center">
                    <div class="info-icon mx-auto">
                        <i class="bi bi-geo-alt-fill"></i>
                    </div>
                    <div class="info-label">Lieu de décès</div>
                    <div class="info-value">{{ $dece->lieux_deces }}</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="info-card text-center">
                    <div class="info-icon mx-auto">
                        <i class="bi bi-calendar-event-fill"></i>
                    </div>
                    <div class="info-label">Date lévé de corps</div>
                    <div class="info-value">
                        {{ $date_leveFR }}<br>
                        @if($dece->heure_leve)
                            à {{ str_replace(':', 'H', $dece->heure_leve) }}
                        @else
                            Heure non précisée
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="info-card text-center">
                    <div class="info-icon mx-auto">
                        <i class="bi bi-heart-pulse-fill"></i>
                    </div>
                    <div class="info-label">Circonstances</div>
                    <div class="info-value">{{ $dece->cause_deces }}</div>
                </div>
            </div>
        </div>

        <!-- Tabs Section -->
        <div class="row mb-5 fade-in">
            <div class="col-12">
                <ul class="nav nav-tabs custom-tabs justify-content-center" id="hommageTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link {{ $activeTab == 'details' ? 'active' : '' }}"
                            wire:click.prevent="setActiveTab('details')"
                            type="button" role="tab">
                            <i class="bi bi-journal-text me-2"></i>Détails
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link {{ $activeTab == 'ceremonie' ? 'active' : '' }}"
                            wire:click.prevent="setActiveTab('ceremonie')"
                            type="button" role="tab">
                            <i class="bi bi-bell me-2"></i>Cérémonie
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link {{ $activeTab == 'galerie' ? 'active' : '' }}"
                            wire:click.prevent="setActiveTab('galerie')"
                            type="button" role="tab">
                            <i class="bi bi-images me-2"></i>Galerie
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link {{ $activeTab == 'condoleances' ? 'active' : '' }}"
                            wire:click.prevent="setActiveTab('condoleances')"
                            type="button" role="tab">
                            <i class="bi bi-chat-heart me-2"></i>Condoléances
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link {{ $activeTab == 'avis' ? 'active' : '' }}"
                            wire:click.prevent="setActiveTab('avis')"
                            type="button" role="tab">
                            <i class="bi bi-file-text me-2"></i>Avis de décès
                        </button>
                    </li>
                </ul>

                <div class="tab-content" id="hommageTabsContent">
                    <!-- Détails Tab -->
                    <div class="tab-pane fade {{ $activeTab == 'details' ? 'show active' : '' }}" id="details" role="tabpanel" wire:key="details-tab">
                        <div class="row g-3">
                            <div class="col-md-12">
                                <div class="row mb-5 fade-in">
                                    <div class="col-12">
                                        <div class="circumstances-section">
                                            <div class="lead" style="color: #555; line-height: 2;">
                                                {!! $dece->description !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Cérémonie Tab -->
                    <div class="tab-pane fade {{ $activeTab == 'ceremonie' ? 'show active' : '' }}" id="ceremonie" role="tabpanel" wire:key="ceremonie-tab">
                        <div class="row g-4">
                           {!! $dece->details_ceremonie !!}
                        </div>
                    </div>

                    <!-- Galerie Tab -->
                    <div class="tab-pane fade {{ $activeTab == 'galerie' ? 'show active' : '' }}" id="galerie" role="tabpanel" wire:key="details-tab">
                        <div class="row g-3">
                            @foreach ($photos as $photo)
                                <div class="col-6 col-md-4 col-lg-3">
                                    <div class="gallery-item" onclick="openLightbox({{ $loop->index }})">
                                        <img src="{{ asset($photo->photo) }}" alt="{{ $dece->nom . ' ' . $dece->prenom }}">
                                        <div class="gallery-overlay">
                                            <i class="bi bi-zoom-in"></i>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Condoléances Tab -->
                    <div class="tab-pane fade {{ $activeTab == 'condoleances' ? 'show active' : '' }}"
                        id="condoleances"
                        role="tabpanel"
                        wire:key="condoleances-tab">
                        <div class="row">
                            <div class="col-lg-7 mb-4">
                                <h3 class="mb-4" style="font-family: 'Playfair Display', serif; color: var(--primary-color);">
                                    <i class="bi bi-pencil-square me-2"></i>Livre de condoléances
                                </h3>

                                @if(session()->has('message'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        {{ session('message') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @endif

                                @forelse ($temoignages as $avis)
                                    <div class="condolence-card" wire:key="condolence-{{ $avis->id }}">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <div class="condolence-author">{{ $avis->nom }}</div>
                                                <div class="condolence-meta">
                                                    <i class="bi bi-geo-alt me-1"></i>{{ $avis->pays }}
                                                </div>
                                            </div>
                                            <i class="bi bi-heart-fill text-danger opacity-25"></i>
                                        </div>
                                        <div class="condolence-text">
                                            {!! nl2br(e($avis->temoignage)) !!}
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center py-5">
                                        <i class="bi bi-chat-heart" style="font-size: 3rem; color: #ccc;"></i>
                                        <p class="mt-3 text-muted">Aucun témoignage pour le moment. Soyez le premier à laisser un message.</p>
                                    </div>
                                @endforelse
                            </div>

                            <div class="col-lg-5">
                                <div class="form-section">
                                    <h4 class="mb-4" style="font-family: 'Playfair Display', serif; color: var(--primary-color);">
                                        <i class="bi bi-envelope-heart me-2"></i>Laisser un message
                                    </h4>
                                    <form wire:submit.prevent="saveTemoignage">
                                        <div class="mb-3">
                                            <label class="form-label">Votre nom</label>
                                            <input type="text" class="form-control @error('nom') is-invalid @enderror"
                                                   wire:model="nom"
                                                   placeholder="Entrez votre nom complet">
                                            @error('nom')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <div wire:ignore>
                                                <label class="form-label">Votre pays</label>
                                            <select class="form-select @error('pays') is-invalid @enderror"
                                                    wire:model="pays"

                                                    id="countrySelect---">
                                                <option value="">Sélectionnez votre pays</option>
                                                <option value="France">France</option>
                                                <option value="Belgique">Belgique</option>
                                                <option value="Suisse">Suisse</option>
                                                <option value="Canada">Canada</option>
                                                <option value="États-Unis">États-Unis</option>
                                                <option value="Royaume-Uni">Royaume-Uni</option>
                                                <option value="Allemagne">Allemagne</option>
                                                <option value="Italie">Italie</option>
                                                <option value="Espagne">Espagne</option>
                                                <option value="Portugal">Portugal</option>
                                                <option value="Pays-Bas">Pays-Bas</option>
                                                <option value="Luxembourg">Luxembourg</option>
                                                <option value="Maroc">Maroc</option>
                                                <option value="Tunisie">Tunisie</option>
                                                <option value="Algérie">Algérie</option>
                                                <option value="Côte d'Ivoire">Côte d'Ivoire</option>
                                                <option value="Sénégal">Sénégal</option>
                                                <option value="Cameroun">Cameroun</option>
                                                <option value="Australie">Australie</option>
                                                <option value="Brésil">Brésil</option>
                                                <option value="Japon">Japon</option>
                                                <option value="Chine">Chine</option>
                                                <option value="Inde">Inde</option>
                                                <option value="Mexique">Mexique</option>
                                                <option value="Afrique du Sud">Afrique du Sud</option>
                                                <option value="Nigéria">Nigéria</option>
                                                <option value="Kenya">Kenya</option>
                                                <option value="Ghana">Ghana</option>
                                                <option value="Suède">Suède</option>
                                                <option value="Norvège">Norvège</option>
                                                <option value="Danemark">Danemark</option>
                                                <option value="Finlande">Finlande</option>
                                                <option value="Pologne">Pologne</option>
                                                <option value="Russie">Russie</option>
                                                <option value="Turquie">Turquie</option>
                                                <option value="Grèce">Grèce</option>
                                                <option value="Autriche">Autriche</option>
                                                <option value="Irlande">Irlande</option>
                                                <option value="Nouvelle-Zélande">Nouvelle-Zélande</option>
                                                <option value="Singapour">Singapour</option>
                                                <option value="Thaïlande">Thaïlande</option>
                                                <option value="Vietnam">Vietnam</option>
                                                <option value="Indonésie">Indonésie</option>
                                                <option value="Malaisie">Malaisie</option>
                                                <option value="Philippines">Philippines</option>
                                                <option value="Corée du Sud">Corée du Sud</option>
                                                <option value="Israël">Israël</option>
                                                <option value="Émirats Arabes Unis">Émirats Arabes Unis</option>
                                                <option value="Arabie Saoudite">Arabie Saoudite</option>
                                                <option value="Qatar">Qatar</option>
                                                <option value="Koweït">Koweït</option>
                                                <option value="Égypte">Égypte</option>
                                                <option value="Liban">Liban</option>
                                                <option value="Jordanie">Jordanie</option>
                                                <option value="Colombie">Colombie</option>
                                                <option value="Argentine">Argentine</option>
                                                <option value="Chili">Chili</option>
                                                <option value="Pérou">Pérou</option>
                                                <option value="Venezuela">Venezuela</option>
                                                <option value="Équateur">Équateur</option>
                                                <option value="Uruguay">Uruguay</option>
                                                <option value="Paraguay">Paraguay</option>
                                                <option value="Bolivie">Bolivie</option>
                                                <option value="Costa Rica">Costa Rica</option>
                                                <option value="Panama">Panama</option>
                                                <option value="Guatemala">Guatemala</option>
                                                <option value="Honduras">Honduras</option>
                                                <option value="Salvador">Salvador</option>
                                                <option value="Nicaragua">Nicaragua</option>
                                                <option value="Cuba">Cuba</option>
                                                <option value="République Dominicaine">République Dominicaine</option>
                                                <option value="Jamaïque">Jamaïque</option>
                                                <option value="Haïti">Haïti</option>
                                                <option value="Éthiopie">Éthiopie</option>
                                                <option value="Ouganda">Ouganda</option>
                                                <option value="Tanzanie">Tanzanie</option>
                                                <option value="Zimbabwe">Zimbabwe</option>
                                                <option value="Zambie">Zambie</option>
                                                <option value="Malawi">Malawi</option>
                                                <option value="Mozambique">Mozambique</option>
                                                <option value="Angola">Angola</option>
                                                <option value="RDC">RDC</option>
                                                <option value="Rwanda">Rwanda</option>
                                                <option value="Burundi">Burundi</option>
                                                <option value="Madagascar">Madagascar</option>
                                                <option value="Maurice">Maurice</option>
                                                <option value="Seychelles">Seychelles</option>
                                                <option value="Islande">Islande</option>
                                                <option value="République Tchèque">République Tchèque</option>
                                                <option value="Slovaquie">Slovaquie</option>
                                                <option value="Hongrie">Hongrie</option>
                                                <option value="Roumanie">Roumanie</option>
                                                <option value="Bulgarie">Bulgarie</option>
                                                <option value="Croatie">Croatie</option>
                                                <option value="Slovénie">Slovénie</option>
                                                <option value="Bosnie-Herzégovine">Bosnie-Herzégovine</option>
                                                <option value="Serbie">Serbie</option>
                                                <option value="Monténégro">Monténégro</option>
                                                <option value="Macédoine du Nord">Macédoine du Nord</option>
                                                <option value="Albanie">Albanie</option>
                                                <option value="Moldavie">Moldavie</option>
                                                <option value="Ukraine">Ukraine</option>
                                                <option value="Biélorussie">Biélorussie</option>
                                                <option value="Lituanie">Lituanie</option>
                                                <option value="Lettonie">Lettonie</option>
                                                <option value="Estonie">Estonie</option>
                                                <option value="Kazakhstan">Kazakhstan</option>
                                                <option value="Ouzbékistan">Ouzbékistan</option>
                                                <option value="Azerbaïdjan">Azerbaïdjan</option>
                                                <option value="Géorgie">Géorgie</option>
                                                <option value="Arménie">Arménie</option>
                                                <option value="Tadjikistan">Tadjikistan</option>
                                                <option value="Kirghizistan">Kirghizistan</option>
                                                <option value="Turkménistan">Turkménistan</option>
                                                <option value="Mongolie">Mongolie</option>
                                                <option value="Népal">Népal</option>
                                                <option value="Bangladesh">Bangladesh</option>
                                                <option value="Sri Lanka">Sri Lanka</option>
                                                <option value="Pakistan">Pakistan</option>
                                                <option value="Afghanistan">Afghanistan</option>
                                                <option value="Iran">Iran</option>
                                                <option value="Irak">Irak</option>
                                                <option value="Syrie">Syrie</option>
                                                <option value="Yémen">Yémen</option>
                                                <option value="Oman">Oman</option>
                                                <option value="Bahreïn">Bahreïn</option>
                                                <option value="Chypre">Chypre</option>
                                                <option value="Malte">Malte</option>
                                                <option value="Liechtenstein">Liechtenstein</option>
                                                <option value="Monaco">Monaco</option>
                                                <option value="Andorre">Andorre</option>
                                                <option value="Saint-Marin">Saint-Marin</option>
                                                <option value="Vatican">Vatican</option>
                                            </select>
                                            </div>
                                            @error('pays')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label">Votre message</label>
                                            <textarea class="form-control @error('temoignage') is-invalid @enderror"
                                                      rows="5"
                                                      wire:model="temoignage"
                                                      placeholder="Partagez vos souvenirs, vos pensées ou un message de soutien pour la famille..."></textarea>
                                            @error('temoignage')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <button type="submit" class="btn btn-submit w-100">
                                            <i class="bi bi-send-heart me-2"></i>Envoyer ma condoléance
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Avis de décès Tab -->
                    <div class="tab-pane fade {{ $activeTab == 'avis' ? 'show active' : '' }}" id="avis" role="tabpanel" wire:key="avis-tab">
                        <div class="notice-card">
                            <div class="mb-4">
                                <i class="bi bi-cross" style="font-size: 3rem; color: var(--accent-gold);"></i>
                            </div>
                            <h2 class="notice-title">Avis de Décès</h2>
                            <div class="notice-content">
                                <p><strong>{{ $dece->nom . ' ' . $dece->prenom }}</strong></p>
                                <p>Né le {{ $date_naissanceFR }}</p>
                                <p>Décédé le {{ $dateFr }}</p>
                                <p>à l'âge de {{ $dece->age }} ans</p>
                                {{-- <p style="margin-top: 30px;">
                                    La cérémonie religieuse sera célébrée le samedi 3 juin 2026 à 14h00<br>
                                    en l'église Saint-Sulpice, 2 Rue Palatine, 75006 Paris
                                </p>
                                <p style="margin-top: 20px; font-size: 1rem;">
                                    <em>La famille remercie toutes les personnes qui lui ont témoigné leur affection<br>
                                    et leur sympathie dans cette douloureuse épreuve.</em>
                                </p> --}}
                            </div>
                            @if($dece->programme_obseque_pdf)
                                <a href="{{ asset($dece->programme_obseque_pdf) }}" class="btn-download" onclick="alert('Télécharger le progamme des obsèque (PDF)'); return false;">
                                    <i class="bi bi-download me-2"></i>Télécharger le progamme des obsèque (PDF)
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Lightbox -->
    <div class="lightbox" id="lightbox">
        <button class="lightbox-close" onclick="closeLightbox()">
            <i class="bi bi-x-lg"></i>
        </button>
        <button class="lightbox-nav lightbox-prev" onclick="changeImage(-1)">
            <i class="bi bi-chevron-left"></i>
        </button>
        <img src="" alt="Gallery Image" id="lightboxImage">
        <button class="lightbox-nav lightbox-next" onclick="changeImage(1)">
            <i class="bi bi-chevron-right"></i>
        </button>
    </div>

    <script>
        // Gallery images
        const galleryImages = [
            @foreach ($photos as $photo)
                '{{ asset($photo->photo) }}',
            @endforeach
        ];

        let currentImageIndex = 0;

        function openLightbox(index) {
            currentImageIndex = index;
            const lightboxImage = document.getElementById('lightboxImage');
            if (lightboxImage && galleryImages[index]) {
                lightboxImage.src = galleryImages[index];
                document.getElementById('lightbox').classList.add('active');
                document.body.style.overflow = 'hidden';
            }
        }

        function closeLightbox() {
            document.getElementById('lightbox').classList.remove('active');
            document.body.style.overflow = 'auto';
        }

        function changeImage(direction) {
            currentImageIndex += direction;
            if (currentImageIndex < 0) currentImageIndex = galleryImages.length - 1;
            if (currentImageIndex >= galleryImages.length) currentImageIndex = 0;
            const lightboxImage = document.getElementById('lightboxImage');
            if (lightboxImage && galleryImages[currentImageIndex]) {
                lightboxImage.src = galleryImages[currentImageIndex];
            }
        }

        // Close lightbox on background click
        const lightbox = document.getElementById('lightbox');
        if (lightbox) {
            lightbox.addEventListener('click', function(e) {
                if (e.target === this) closeLightbox();
            });
        }

        // Keyboard navigation
        document.addEventListener('keydown', function(e) {
            const lightboxElement = document.getElementById('lightbox');
            if (!lightboxElement || !lightboxElement.classList.contains('active')) return;
            if (e.key === 'Escape') closeLightbox();
            if (e.key === 'ArrowLeft') changeImage(-1);
            if (e.key === 'ArrowRight') changeImage(1);
        });
    </script>
</div>

@script
<script>
    // Initialisation de Select2
    function initSelect2() {
        // Attendre que le DOM soit prêt
        setTimeout(() => {
            if (typeof $ !== 'undefined' && $('#countrySelect').length && !$('#countrySelect').hasClass('select2-hidden-accessible')) {
                // Détruire l'instance existante si elle existe
                if ($('#countrySelect').data('select2')) {
                    $('#countrySelect').select2('destroy');
                }

                $('#countrySelect').select2({
                    placeholder: "Sélectionnez votre pays",
                    allowClear: true,
                    width: '100%'
                });

                // Synchronisation avec Livewire
                $('#countrySelect').off('change').on('change', function(e) {
                    @this.set('pays', e.target.value);
                });
            }
        }, 100);
    }

    // Écouter l'événement de réinitialisation
    document.addEventListener('reset-select2', function() {
        initSelect2();
    });

    // Initialisation au chargement
    document.addEventListener('livewire:navigated', function() {
        initSelect2();
    });

    // Initialisation après chaque mise à jour Livewire
    document.addEventListener('livewire:initialized', function() {
        initSelect2();
    });

    // Initialisation au chargement de la page
    document.addEventListener('DOMContentLoaded', function() {
        initSelect2();
    });
</script>
@endscript
