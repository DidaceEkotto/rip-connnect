<?php

use App\Models\Ville;
use App\Models\Morgue;
use Livewire\Attributes\Url;
use Livewire\Component;

new class extends Component
{
    #[Url(as: 'q', history: true)]
    public string $search = '';

    #[Url(as: 'ville', history: true)]
    public string $selectedVille = '';

    public $villes;

    public function mount()
    {
        $this->loadVilles();
    }

    public function loadVilles()
    {
        $this->villes = Ville::orderBy('name')->get();
    }

    /**
     * Propriété calculée : récupère les morgues filtrées
     */
    public function getFilteredMorguesProperty()
    {
        $query = Morgue::with('ville');

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('nom', 'like', '%' . $this->search . '%')
                  ->orWhere('adresse', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->selectedVille) {
            $query->whereHas('ville', function ($q) {
                $q->where('name', $this->selectedVille);
            });
        }

        return $query->get();
    }

    /**
     * À chaque mise à jour de search ou selectedVille, on notifie la carte
     */
    public function updated($property)
    {
        if (in_array($property, ['search', 'selectedVille'])) {
            $this->dispatch('morgues-updated', morgues: $this->filteredMorgues);
        }
    }
};
?>

<div>
    <!-- ===== LIBRAIRIES EXTERNES ===== -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

    <!-- ===== HEADER ===== -->
    <header class="page-header text-white py-5 mb-0">
        <div class="container">
            <h1 class="display-5 fw-bold mb-2">Nos Morgues & Chambres Funéraires</h1>
            <p class="lead mb-0 opacity-75">Des espaces de recueillement dignes, respectueux et apaisants</p>
        </div>
    </header>

    <!-- ===== CONTENU ===== -->
    <div class="container py-5">
        <div class="row g-4">

            <!-- PARTIE GAUCHE : LISTE -->
            <div class="col-lg-7">
                <div class="d-flex align-items-center mb-4">
                    <h3 class="fw-bold mb-0">Nos Établissements</h3>
                    &nbsp;&nbsp;
                    <span class="badge bg-primary rounded-pill ms-3" style="padding: 6px !important;color:white !important;">{{ count($this->filteredMorgues) }} résultat(s)</span>
                </div>

                <!-- FILTRES -->
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <div class="input-group shadow-sm rounded-3 overflow-hidden">
                            <span class="input-group-text bg-white border-end-0 ps-3">
                                <i class="fas fa-search text-muted"></i>
                            </span>
                            <input type="text"
                                   wire:model.live.debounce.300ms="search"
                                   class="form-control border-start-0 ps-0 shadow-none py-2"
                                   placeholder="Rechercher une morgue...">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group shadow-sm rounded-3 overflow-hidden">
                            {{-- <span class="input-group-text bg-white border-end-0 ps-3">
                                <i class="fas fa-city text-muted"></i>
                            </span> --}}
                            <select wire:model.live="selectedVille"
                                    class="form-select border-start-0 ps-0 shadow-none py-2">
                                <option value="">Toutes les villes</option>
                                @foreach ($villes as $ville)
                                    <option value="{{ $ville->name }}">{{ $ville->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <!-- LISTE DES MORGUES -->
                <div class="row g-4">
                    @forelse ($this->filteredMorgues as $morgue)
                        <div class="col-12" wire:key="morgue-{{ $morgue->id }}">
                            <div class="card border-0 shadow-sm overflow-hidden hover-lift transition-all">
                                <div class="row g-0">
                                    <!-- Image -->
                                    <div class="col-md-4">
                                        <div class="h-100" style="min-height: 200px;">
                                            <img src="{{ asset($morgue->logo ?? 'images/default-morgue.jpg') }}"
                                                 class="w-100 h-100 object-fit-cover"
                                                 alt="{{ $morgue->nom }}"
                                                 onerror="this.src='https://via.placeholder.com/400x300?text=Morgue'">
                                        </div>
                                    </div>
                                    <!-- Contenu -->
                                    <div class="col-md-8">
                                        <div class="card-body p-4 d-flex flex-column h-100">
                                            <h5 class="card-title fw-bold text-dark mb-3">{{ $morgue->nom }}</h5>

                                            <p class="mb-2 text-muted">
                                                <i class="fas fa-map-marker-alt text-primary me-2"></i>
                                                {{ $morgue->adresse }}
                                            </p>
                                            <p class="mb-3 text-muted">
                                                <i class="fas fa-phone text-primary me-2"></i>
                                                <a href="tel:{{ $morgue->telephone }}" class="text-decoration-none text-muted fw-medium">
                                                    {{ $morgue->telephone }}
                                                </a>
                                            </p>

                                            <div class="mt-auto d-flex justify-content-between align-items-center">
                                                <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-2 fw-normal" style="color:white !important;">
                                                    <i class="fas fa-city me-1"></i> {{ $morgue->ville->name }}
                                                </span>
                                                <a href="{{ route('morgue.details', ['slug' => $morgue->slug]) }}"
                                                   class="btn btn-outline-primary btn-sm rounded-pill px-3 fw-medium">
                                                    Détails <i class="fas fa-arrow-right ms-1"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="text-center py-5 bg-light rounded-4 border">
                                <i class="fas fa-search fa-3x text-muted mb-3 opacity-25"></i>
                                <p class="lead text-muted mb-2">Aucune morgue ne correspond à votre recherche.</p>
                                <button type="button"
                                        wire:click="$set('search', ''); $set('selectedVille', '')"
                                        class="btn btn-link text-primary text-decoration-none fw-medium" style="color: white !important;">
                                    <i class="fas fa-rotate-left me-1"></i> Réinitialiser les filtres
                                </button>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- PARTIE DROITE : CARTE -->
            <div class="col-lg-5">
                <div class="sticky-top" style="top: 20px; z-index: 1020;">
                    <h3 class="fw-bold mb-4">Localisation</h3>
                    <!-- wire:ignore empêche Livewire de détruire/recréer la carte à chaque render -->
                    <div wire:ignore id="map" class="rounded-4 shadow-sm border"></div>
                </div>
            </div>

        </div>
    </div>

    <!-- ===== SCRIPTS ===== -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <script>
        document.addEventListener('livewire:initialized', () => {
            // 1. INITIALISATION CARTE
            const map = L.map('map').setView([7.3697, 12.3547], 6);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
                maxZoom: 19
            }).addTo(map);

            const markersLayer = L.layerGroup().addTo(map);

            // 2. FONCTION DE MISE À JOUR DES MARQUEURS
            function updateMarkers(morgues) {
                markersLayer.clearLayers();

                if (!morgues || morgues.length === 0) {
                    return;
                }

                const markers = [];

                morgues.forEach(morgue => {
                    const lat = parseFloat(morgue.latitude);
                    const lng = parseFloat(morgue.longitude);

                    if (lat && lng) {
                        const marker = L.marker([lat, lng])
                            .bindPopup(`
                                <div style="min-width: 200px;">
                                    <strong class="d-block mb-1 fs-6">${morgue.nom}</strong>
                                    <p class="mb-1 text-muted small"><i class="fas fa-map-marker-alt me-1"></i> ${morgue.adresse}</p>
                                    <p class="mb-0 small"><i class="fas fa-phone me-1"></i> <a href="tel:${morgue.telephone}">${morgue.telephone}</a></p>
                                </div>
                            `);

                        markers.push(marker);
                        markersLayer.addLayer(marker);
                    }
                });

                // Ajuster la vue sur les marqueurs
                if (markers.length > 0) {
                    const group = L.featureGroup(markers);
                    map.fitBounds(group.getBounds().pad(0.15));
                }
            }

            // 3. CHARGEMENT INITIAL
            const initialMorgues = @json($this->filteredMorgues);
            updateMarkers(initialMorgues);

            // 4. ÉCOUTE DES MISES À JOUR LIVEWIRE
            @this.on('morgues-updated', (event) => {
                updateMarkers(event.morgues);
            });
        });
    </script>

    <!-- ===== STYLES PERSONNALISÉS ===== -->
    <style>
        .page-header {
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
        }
        #map {
            height: 600px;
            width: 100%;
            background: #f8f9fa;
        }
        .hover-lift:hover {
            transform: translateY(-4px);
            box-shadow: 0 1rem 2rem rgba(0,0,0,0.1) !important;
        }
        .transition-all {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .object-fit-cover {
            object-fit: cover;
        }
        .form-control:focus, .form-select:focus {
            border-color: #86b7fe;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
        }
        /* Responsive carte */
        @media (max-width: 991.98px) {
            #map { height: 400px; }
            .sticky-top { position: relative !important; top: 0 !important; }
        }
    </style>
</div>
