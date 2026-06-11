<?php

use App\Models\Category;
use App\Models\User;
use App\Models\Ville;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;
use Livewire\Component;
use Livewire\WithFileUploads;
use Stevebauman\Location\Facades\Location;
use App\Models\Entreprise;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

new class extends Component
{
    use WithFileUploads;

    public $villes, $categories,$page,$name,$prenom,$logo,$longiture,$latitude,$numero_regitre_commerce,$numer_cni,$ville,$type_entreprise;
    public $email,$telephone;
    public function mount($page)
    {
        $this->page = $page;
        $this->loadCategories();
        $this->loadsVille();
    }
    public function loadCategories()
    {
        $this->categories = Category::all();
    }

    public function loadsVille()
    {
        $this->villes = Ville::get();
    }


    public function saveStrucutre()
    {
        $this->validate([
            "name" => "required|min:2",
            "prenom" => "nullable|min:2",
            "entreprise_name" => "required|unique:entreprises,entreprise_name|min:2",
            "logo" => "nullable|image|mimes:png,jpg,jpeg,webp|max:2999",
            "longitude" => "nullable|min:5",
            "latitude" => "nullable|min:5",
            "numero_regitre_commerce" => "nullable|string|min:5",
            "numer_cni" => "required|string|min:5|unique:users,numer_cni",
            "ville" => "required|exists:villes,id",
            "type_entreprise" => "required",
            "email" => "nullable|email|unique:users,email",
            "telephone" => "required|numeric|unique:users,telephone",
        ], [
            "name.required" => "Nom obligatoire",
            "name.min" => "Nom trop court (2 caractères minimum)",
            "prenom.min" => "Prénom trop court (2 caractères minimum)",
            "logo.image" => "Image incorrecte",
            "logo.mimes" => "Image doit être au format png, jpg, jpeg ou webp",
            "logo.max" => "Logo trop lourd (3 Mo maximum)",
        ]);

        DB::beginTransaction();

        try {

            $image_name = null;

            if ($this->logo) {

                $image_name = time()
                    . '-entreprise-'
                    . Auth::guard('admin')->id()
                    . '.'
                    . $this->logo->getClientOriginalExtension();

                $image_resize = Image::decode(
                    $this->logo->getRealPath()
                );

                $image_resize->save(
                    storage_path('app/public/images/' . $image_name)
                );
            }

            $position = Location::get();

            $user = User::create([
                "name" => $this->name,
                "prenom" => $this->prenom,
                "email" => $this->email,
                "telephone" => $this->telephone,
                "numer_cni" => $this->numer_cni,
                "password" => Hash::make("000000"),
                "last_login_ip" => request()->ip(),
                "last_login_at" => now(),
            ]);

            $entreprise = new Entreprise();

            $entreprise->user_id = $user->id;
            $entreprise->entreprise_name = $this->entreprise_name;
            $entreprise->slug = Str::slug($this->entreprise_name);
            $entreprise->type_entreprise = $this->type_entreprise;
            $entreprise->description = $this->description;
            $entreprise->logo = $image_name
                ? "storage/images/{$image_name}"
                : null;

            $entreprise->numero_regitre_commerce = $this->numero_regitre_commerce;
            $entreprise->ville_id = $this->ville;

            if ($position) {

                $entreprise->longitude = $position->longitude;
                $entreprise->latitude = $position->latitude;

                $entreprise->adresse =
                    $position->cityName . ', ' .
                    $position->regionName . ', ' .
                    $position->countryName;

                $entreprise->ville = $position->cityName;
            }

            $entreprise->save();

            DB::commit();

            return redirect($this->page)
                ->with('success', 'Entreprise enregistrée avec succès');

        } catch (\Exception $e) {

            DB::rollBack();

            if ($image_name && file_exists(storage_path('app/public/images/' . $image_name))) {
                unlink(storage_path('app/public/images/' . $image_name));
            }

            session()->flash(
                'error',
                'Erreur lors de l\'enregistrement : ' . $e->getMessage()
            );

            return;
        }
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

                <form wire:submit.prevent="updateProduct" enctype="multipart/form-data" autocomplete="off">
                    @csrf

                    <div class='row'>
                        <div class="col-md-7 col-lg-7">
                            <h3 class="text-lg font-semibold mb-4">Informations du partenaire</h3>

                            <div class="">
                                <div class="row">
                                    <div class="col-md-6 col-lg-6">
                                        <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                                            Nom *
                                        </label>
                                        <input type="text" id="name" wire:model="name"
                                            class="form-control @error('name') is-invalid @enderror">
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 col-lg-6">
                                        <label class="block text-gray-700 text-sm font-bold mb-2" for="prenom">
                                            Prenom *
                                        </label>
                                        <input type="text" id="prenom" wire:model="prenom"
                                            class="form-control @error('prenom') is-invalid @enderror">
                                        @error('prenom')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 col-lg-6">
                                        <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                                            Email (Optionel)
                                        </label>
                                        <input type="text" id="email" wire:model="email"
                                            class="form-control @error('email') is-invalid @enderror">
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 col-lg-6">
                                        <div class="row">
                                            <div class="col-md-3 col-lg-3">
                                                <label class="block text-gray-700 text-sm font-bold mb-2" for="entreprise_name">
                                                    Nom de la structure *
                                                </label>
                                                <input type="text" id="entreprise_name" wire:model="entreprise_name"
                                                    class="form-control @error('entreprise_name') is-invalid @enderror">
                                                @error('entreprise_name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-9 col-lg-9">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 col-lg-12">
                                        <label class="block text-gray-700 text-sm font-bold mb-2" for="entreprise_name">
                                            Nom de la structure *
                                        </label>
                                        <input type="text" id="entreprise_name" wire:model="entreprise_name"
                                            class="form-control @error('entreprise_name') is-invalid @enderror">
                                        @error('entreprise_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 col-lg-12">
                                        <label class="block text-gray-700 text-sm font-bold mb-2" for="numer_cni">
                                           Numéro de la CNI *
                                        </label>
                                        <input type="text" id="numer_cni" wire:model="numer_cni"
                                            class="form-control @error('numer_cni') is-invalid @enderror">
                                        @error('numer_cni')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 col-lg-6">
                                        <label class="block text-gray-700 text-sm font-bold mb-2" for="type_product">
                                            Choisir la ville *
                                        </label>
                                        <select id="villes" wire:model="ville"
                                            class="form-control @error('ville') is-invalid @enderror">
                                            <option value="">Choisir une ville</option>
                                            @foreach ($villes as $vil)
                                                <option value="{{ $vil->id }}">{{ $vil->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('ville')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 col-lg-6">
                                        <label class="block text-gray-700 text-sm font-bold mb-2" for="prix">
                                            Prix *
                                        </label>
                                        <input type="text" id="prix" wire:model="prix"
                                            class="form-control @error('prix') is-invalid @enderror">
                                        @error('prix')
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
                                    <label class="block text-gray-700 text-sm font-bold mb-2" for="status">
                                        Statut *
                                    </label>
                                    <select id="status" wire:model="status"
                                        class="form-control @error('status') is-invalid @enderror">
                                        <option value="0">Non visible</option>
                                        <option value="1">Visible</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Images -->
                        <div class="col-md-5 col-lg-5">
                            <h3 class="text-lg font-semibold mb-4">Images du produit</h3>

                            {{-- Images existantes --}}
                            @if (count($existingImages) > 0)
                                <div class="mb-4">
                                    <h5 class="mb-3">Images actuelles</h5>
                                    <div class="row">
                                        @foreach ($existingImages as $image)
                                            <div class="col-md-6 mb-3" wire:key="existing-image-{{ $image['id'] }}">
                                                <div class="position-relative">
                                                    <img src="{{ asset($image['path']) }}" alt="Product Image"
                                                        class="img-thumbnail w-100"
                                                        style="height: 150px; object-fit: cover;">

                                                    @if (in_array($image['id'], $imagesToDelete))
                                                        <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center"
                                                            style="background-color: rgba(0,0,0,0.5);">
                                                            <span class="badge bg-danger">À supprimer</span>
                                                        </div>
                                                        <button type="button"
                                                            wire:click="restoreImage({{ $image['id'] }})"
                                                            class="btn btn-sm btn-success position-absolute top-0 end-0 m-1">
                                                            <i class="bi bi-arrow-counterclockwise"></i>
                                                        </button>
                                                    @else
                                                        <button type="button"
                                                            wire:click="deleteExistingImage({{ $image['id'] }})"
                                                            class="btn btn-sm btn-danger position-absolute top-0 end-0 m-1">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            {{-- Nouvelles images --}}
                            <div class="mb-4">
                                <h5 class="mb-3">Ajouter de nouvelles images</h5>
                                <p class="text-sm text-gray-600 mb-4">
                                    Les nouvelles images s'ajouteront aux images existantes
                                </p>

                                @foreach ($imageInputs as $index => $input)
                                    <div class="mb-3" wire:key="image-input-{{ $index }}">
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="flex-grow-1">
                                                <input type="file" wire:model="images.{{ $index }}"
                                                    class="form-control @error('images.' . $index) is-invalid @enderror"
                                                    accept=".jpeg,.png,.jpg,.webp">
                                                @error('images.' . $index)
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror

                                                @if (isset($images[$index]) && $images[$index])
                                                    <div class="mt-2">
                                                        <img src="{{ $images[$index]->temporaryUrl() }}"
                                                            alt="Preview" class="img-thumbnail"
                                                            style="width: 100px; height: 100px; object-fit: cover;">
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="d-flex gap-1">
                                                @if (count($imageInputs) > 1)
                                                    <button type="button"
                                                        wire:click="removeImageInput({{ $index }})"
                                                        class="btn btn-sm btn-outline-danger">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                @endif

                                                @if ($loop->last)
                                                    <button type="button" wire:click="addImageInput"
                                                        class="btn btn-sm btn-outline-primary">
                                                        <i class="bi bi-plus"></i>
                                                    </button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    {{-- Boutons d'action --}}
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('admin.produits.liste') }}" class="btn btn-secondary">
                                    <i class="bi bi-arrow-left me-1"></i> Annuler
                                </a>
                                <button type="submit" class="btn btn-primary" wire:target='update'>
                                    <span wire:loading.remove wire:target="update">
                                        <i class="bi bi-check-circle me-1"></i> Mettre à jour
                                    </span>
                                    <span wire:loading wire:target="update">
                                        <span class="spinner-border spinner-border-sm" role="status"
                                            aria-hidden="true"></span>
                                        Mise à jour...
                                    </span>
                                </button>
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
