<?php

use App\Models\Morgue;
use App\Models\Ville;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;
use Livewire\Component;
use Livewire\WithFileUploads;
use Stevebauman\Location\Facades\Location;

new class extends Component
{
    use WithFileUploads;
   public $page,$villes;
   public $nom,$logo,$telephone,$adresse,$ville,$longitude,$latitude,$heure_ouverture,$heure_fermeture,$content;
    public $trixId;

   public function mount($page)
   {
        $this->page = $page;
        $this->trixId = 'trix-' . Str::random(8);
        $this->loadVilles();
   }

   public function loadVilles()
   {
        $this->villes = Ville::all();
   }

   public function saveMorgue()
   {
        $this->validate([
            "nom"=>"required|min:2",
            "logo"=>"required|image|mimes:png,webp,jpeg,jpg|max:2999",
            "telephone"=>"required|numeric|min:9",
            //"ville"=>"required|in:villes,id",
            "ville"=>"required",
            "longitude"=>"required",
            "latitude"=>"required",
            "heure_ouverture"=>"required",
            "heure_fermeture"=>"required",
            "adresse"=>"required|min:10",
            "content"=>"required|min:10",
        ]);

        $image = $this->logo;
        $image_name = time() . '-morgue-' . Auth::guard('admin')->user()->id . '.' . $image->getClientOriginalExtension();
        // Version 4 - Utilisez decode() au lieu de make()
        $image_resize = Image::decode($image->getRealPath());
        //$image_resize->scale(width: null, height: 300); // Redimensionnement (ajustez selon vos besoins)
        // Sauvegarde de l'image
        $image_resize->save('storage/images/' . $image_name);

        $morgue = new Morgue();
        $morgue->identifiant = uniqid();
        $morgue->admin_id = Auth::guard('admin')->user()->id;
        $morgue->nom = $this->nom;
        $morgue->slug = Str::slug($this->nom);
        $morgue->logo = "storage/images/{$image_name}";
        $morgue->telephone = $this->telephone;
        $morgue->ville_id = $this->ville;
        $morgue->longitude = $this->longitude;
        $morgue->latitude = $this->latitude;
        $morgue->adresse = $this->adresse;
        $morgue->heure_ouverture = $this->heure_ouverture;
        $morgue->heure_fermeture = $this->heure_fermeture;
        $morgue->description = $this->content;
        $morgue->save();
        return redirect()->route('admin.morgues.index')->with("success", "Morgue ajouter avec succès");
   }
};
?>

<div>
    <div class="container-fluid p-4">

        <div class="card">
            <div class="card-body">
                @if (session()->has('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if (session()->has('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form wire:submit.prevent="saveMorgue" enctype="multipart/form-data" autocomplete="off">
                    @csrf

                    <div class='row'>
                        <div class="col-md-7 col-lg-7">
                            <h3 class="text-lg font-semibold mb-4">Informations sur la morgue</h3>

                            <div class="">
                                <div class="row">
                                    <div class="col-md-6 col-lg-6">
                                        <label class="block text-gray-700 text-sm font-bold mb-2" for="logo">
                                            Logo *
                                        </label>
                                        <input type="file" id="logo" wire:model="logo" class="form-control @error('logo') is-invalid @enderror" accept=".jpg,.jpeg,.webp,.png">

                                        @if ($logo)
                                            <div class="form-group">
                                                <img src="{{ $logo->temporaryUrl() }}"style="width: 100px !important;height:150px !important;">
                                            </div>
                                        @endif
                                        @error('logo')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 col-lg-6">
                                        <label class="block text-gray-700 text-sm font-bold mb-2" for="nom">
                                            Nom de la morgue *
                                        </label>
                                        <input type="text" id="nom" wire:model="nom"
                                            class="form-control @error('nom') is-invalid @enderror">
                                        @error('nom')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 col-lg-6">
                                        <label class="block text-gray-700 text-sm font-bold mb-2" for="telephone">
                                            Téléphone
                                        </label>
                                        <input type="number" id="telephone" wire:model="telephone" class="form-control @error('telephone') is-invalid @enderror">
                                        @error('telephone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 col-lg-6">
                                        <label class="block text-gray-700 text-sm font-bold mb-2" for="type_product">
                                            Choisir la ville *
                                        </label>
                                        <select id="ville" wire:model="ville"class="form-control @error('ville') is-invalid @enderror">
                                            <option value="">Choisir une ville</option>
                                            @foreach ($villes as $ville)
                                                <option value="{{ $ville->id }}">{{ $ville->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('ville')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-lg-6">
                                        <label class="block text-gray-700 text-sm font-bold mb-2" for="latitude">
                                            Latitude *
                                        </label>
                                        <input type="text" id="latitude" wire:model="latitude"class="form-control @error('latitude') is-invalid @enderror">
                                        @error('latitude')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 col-lg-6">
                                        <label class="block text-gray-700 text-sm font-bold mb-2" for="longitude">
                                            Longitude *
                                        </label>
                                        <input type="text" id="longitude" wire:model="longitude"
                                            class="form-control @error('longitude') is-invalid @enderror">
                                        @error('longitude')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>

                                 <div class="row">
                                    <div class="col-md-12 col-lg-12">
                                        <label class="block text-gray-700 text-sm font-bold mb-2" for="adresse">
                                           Adresse / Localisation
                                        </label>
                                        <input type="text" id="adresse" wire:model="adresse"
                                            class="form-control @error('adresse') is-invalid @enderror">
                                        @error('adresse')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                 </div>

                                <div class="row">
                                    <div class="col-md-6 col-lg-6">
                                        <label class="block text-gray-700 text-sm font-bold mb-2" for="heure_ouverture">
                                           Heure d'ouverture
                                        </label>
                                        <input type="time" id="heure_ouverture" wire:model="heure_ouverture"
                                            class="form-control @error('heure_ouverture') is-invalid @enderror">
                                        @error('heure_ouverture')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>


                                    <div class="col-md-6 col-lg-6">
                                        <label class="block text-gray-700 text-sm font-bold mb-2" for="heure_fermeture">
                                            Heure de fermeture *
                                        </label>
                                        <input type="time" id="heure_fermeture" wire:model="heure_fermeture"
                                            class="form-control @error('heure_fermeture') is-invalid @enderror">
                                        @error('heure_fermeture')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <br>

                                {{-- QUILLJS ÉDITEUR --}}
                                <div class="mb-3" wire:ignore>
                                    <label>Description du produit</label>
                                    <div id="quill-editor" style="height: 500px;">{!! $content !!}</div>
                                    <input type="hidden" id="quill-content">
                                    @error('content')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Statut -->
                                <div class="mb-4">
                                    <button type="submit" class="btn btn-primary" wire:target='saveMorgue'>
                                    <span wire:loading.remove wire:target="saveMorgue">
                                        <i class="bi bi-check-circle me-1"></i>Créé la morgue
                                    </span>
                                    <span wire:loading wire:target="saveMorgue">
                                        <span class="spinner-border spinner-border-sm" role="status"
                                            aria-hidden="true"></span>
                                        Création en cours...
                                    </span>
                                </button>
                                </div>
                            </div>
                        </div>


                    </div>

                </form>
            </div>
        </div>
    </div>

    {{-- QUILL SCRIPT --}}
    @push('scripts')
        <script>
            document.addEventListener('livewire:initialized', () => {
                var quill = new Quill('#quill-editor', {
                    theme: 'snow'
                });

                quill.on('text-change', function() {
                    const html = quill.root.innerHTML;
                    document.getElementById('quill-content').value = html;
                    @this.set('content', html);
                });

                // Mise à jour après validation Livewire
                Livewire.hook('morph.updated', () => {
                    const serverContent = @this.get('content');
                    if (serverContent && quill.root.innerHTML !== serverContent) {
                        quill.root.innerHTML = serverContent;
                    }
                });
            });
        </script>
    @endpush
</div>
