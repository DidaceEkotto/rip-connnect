<?php

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Deces;
use Livewire\Attributes\Url;
use Livewire\Attributes\On;
use Carbon\Carbon;

new class extends Component
{
    use WithPagination;

    public $page;
    public $deces;

    #[Url(as: 'nom', except: '')]
    public $searchName = '';

    #[Url(as: 'date', except: '')]
    public $searchDate = '';

    public $isFiltered = false;

    public function mount($page, $deces)
    {
        $this->page = $page;
        $this->deces = $deces ?? collect();

        if (!empty($this->searchDate)) {
            $this->searchDate = $this->normalizeDate($this->searchDate);
        }

        $this->checkIfFiltered();
    }

    public function updatedSearchName()
    {
        $this->resetPage();
        $this->checkIfFiltered();
    }

    public function updatedSearchDate($value)
    {
        $this->resetPage();
        $this->searchDate = $this->normalizeDate($value) ?: '';
        $this->checkIfFiltered();
    }

    private function normalizeDate(?string $date): ?string
    {
        if (empty($date)) return null;

        $formats = ['Y-m-d', 'd-m-Y', 'd/m/Y', 'Y/m/d', 'd F Y', 'j F Y'];

        foreach ($formats as $format) {
            try {
                $parsed = Carbon::createFromFormat($format, $date);
                if ($parsed && $parsed->getError() === null) {
                    return $parsed->format('Y-m-d');
                }
            } catch (\Exception $e) {
                continue;
            }
        }

        try {
            return Carbon::parse($date)->format('Y-m-d');
        } catch (\Exception $e) {
            return null;
        }
    }

    public function checkIfFiltered()
    {
        $this->isFiltered = !empty($this->searchName) || !empty($this->searchDate);
    }

    #[On('filters-reset')]
    public function resetFilters()
    {
        $this->searchName = '';
        $this->searchDate = '';
        $this->isFiltered = false;
        $this->resetPage();
        $this->dispatch('datepicker-reset');
    }

    public function getFilteredDecesProperty()
    {
        if (!$this->deces?->isNotEmpty()) {
            return collect();
        }

        if (!$this->isFiltered) {
            return $this->deces;
        }

        return $this->deces->filter(function($dece) {
            if (!empty($this->searchName)) {
                $fullName = strtolower(($dece->nom ?? '') . ' ' . ($dece->prenom ?? ''));
                $searchTerm = strtolower($this->searchName);
                if (!str_contains($fullName, $searchTerm)) {
                    return false;
                }
            }

            if (!empty($this->searchDate)) {
                if (empty($dece->date_dece)) {
                    return false;
                }

                $deceDateNormalized = $this->normalizeDate($dece->date_dece);

                if (!$deceDateNormalized) {
                    return false;
                }

                if ($deceDateNormalized !== $this->searchDate) {
                    return false;
                }
            }

            return true;
        });
    }
};
?>

<div>
    <div class="container">
        <div class="filters-section">
            <div class="row g-3">
                <div class="col-md-5 filter-group">
                    <label for="search-name"><i class="fa fa-user"></i> Rechercher par nom</label>
                    <input type="text"
                           id="search-name"
                           class="form-control"
                           placeholder="Nom du défunt..."
                           wire:model.live.debounce.500ms="searchName">
                </div>

                <div class="col-md-4 filter-group">
                    <label for="search-date"><i class="fa fa-calendar"></i> Date de décès</label>
                    <div wire:ignore wire:key="datepicker-wrapper">
                        <input type="text"
                               id="search-date"
                               class="form-control datepicker"
                               placeholder="JJ/MM/AAAA"
                               autocomplete="off">
                    </div>
                </div>

                <div class="col-md-3 filter-group d-flex align-items-end">
                    <button id="reset-filters"
                            class="btn-reset w-100 {{ !$isFiltered ? 'disabled' : '' }}"
                            wire:click="resetFilters"
                            {{ !$isFiltered ? 'disabled' : '' }}>
                        <i class="fa fa-undo"></i> Réinitialiser
                    </button>
                </div>
            </div>

            @if($isFiltered)
            <div class="active-filters mt-3">
                @if($searchName)
                <span class="badge bg-light text-dark">
                    Nom: "{{ $searchName }}"
                    <button type="button" wire:click="$set('searchName', '')" class="btn-close btn-close-xs ms-1"></button>
                </span>
                @endif
                @if($searchDate)
                <span class="badge bg-light text-dark">
                    Date: {{ \Carbon\Carbon::parse($searchDate)->translatedFormat('d F Y') }}
                    <button type="button" wire:click="$set('searchDate', '')" class="btn-close btn-close-xs ms-1"></button>
                </span>
                @endif
            </div>
            @endif
        </div>
    </div>

    <section id="page-content" class="mt-4">
        <div class="container">
            <div class="row">
                @forelse ($this->filteredDeces as $dece)
                    @php
                        $dateDeces = !empty($dece->date_dece)
                            ? \Carbon\Carbon::parse($dece->date_dece)
                            : null;
                        $dateFr = $dateDeces ? $dateDeces->translatedFormat('l d F Y') : 'Date non précisée';
                    @endphp

                    <div class="col-md-6 col-lg-6">
                        <div class="post-item team-members team-members-left team-members-shadow">
                            <div class="team-member">
                                <div class="team-image">
                                    <div style="height:200px;background:#FFFFFF url('{{ asset($dece->photo) }}');background-size:contain;background-repeat:no-repeat;background-position:top center;"></div>
                                    @if($dateDeces)
                                    <span class="date-badge">
                                        {{ $dateDeces->translatedFormat('d M Y') }}
                                    </span>
                                    @endif
                                </div>
                                <div class="team-desc">
                                    <h3>{{ strtoupper($dece->nom ?? '') }} {{ $dece->prenom ?? '' }}</h3>
                                    <span>{{ $dece->age ?? '' }} Ans - <strong style="text-transform: uppercase">{{ $dece->lieux_deces ?? 'Lieu non précisé' }}</strong></span>
                                    <p>Décès survenu le <strong>{{ $dateFr }}</strong></p>
                                    <div class="align-center">
                                        <a href="{{ route('deces.details', ['identifiant' => $dece->identifiant]) }}" class="btn-consulter">
                                            Consulter <i class="fa fa-caret-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="no-results text-center py-5">
                            <i class="fa fa-search fa-3x text-muted mb-3"></i>
                            <h4>Aucun avis de décès trouvé</h4>
                            <p class="text-muted">Essayez de modifier vos critères de recherche.</p>
                            @if($isFiltered)
                            <button wire:click="resetFilters" class="btn btn-outline-secondary mt-2">
                                <i class="fa fa-undo"></i> Effacer les filtres
                            </button>
                            @endif
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
</div>

<style>
    .filter-group label {
        font-weight: 600;
        font-size: 0.9rem;
        color: #2c3e50;
        margin-bottom: 6px;
        display: block;
    }
    .filter-group label i {
        margin-right: 5px;
        color: #8e44ad;
    }
    .date-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        background: linear-gradient(135deg, #c0392b, #e74c3c);
        color: #fff;
        padding: 5px 12px;
        border-radius: 15px;
        font-size: 0.8rem;
        font-weight: 600;
        z-index: 2;
    }
    .active-filters {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }
    .active-filters .badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }
    .btn-close-xs {
        padding: 0;
        width: 1rem;
        height: 1rem;
        font-size: 0.6rem;
        opacity: 0.6;
    }
    .btn-close-xs:hover {
        opacity: 1;
    }
    .btn-reset.disabled,
    .btn-reset:disabled {
        opacity: 0.5;
        cursor: not-allowed;
        pointer-events: none;
    }
    .flatpickr-calendar {
        z-index: 9999 !important;
        border-radius: 12px !important;
        box-shadow: 0 10px 40px rgba(0,0,0,0.15) !important;
    }
    .flatpickr-day.selected {
        background: #8e44ad !important;
        border-color: #8e44ad !important;
    }
</style>

@push('scripts')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/fr.js"></script>

<script>
document.addEventListener('livewire:initialized', () => {
    const input = document.getElementById('search-date');
    if (!input) return;

    const fp = flatpickr(input, {
        locale: 'fr',
        dateFormat: 'd/m/Y',
        allowInput: true,
        defaultDate: @js($searchDate) || null,
        onChange: function(selectedDates, dateStr) {
            if (dateStr && dateStr.includes('/')) {
                const [d, m, y] = dateStr.split('/');
                @this.set('searchDate', `${y}-${m}-${d}`);
            } else {
                @this.set('searchDate', '');
            }
        }
    });

    @this.watch('searchDate', (value) => {
        if (value && /^\d{4}-\d{2}-\d{2}$/.test(value)) {
            fp.setDate(value, false);
        } else {
            fp.clear();
        }
    });

    Livewire.on('datepicker-reset', () => {
        fp.clear();
    });
});
</script>
@endpush
