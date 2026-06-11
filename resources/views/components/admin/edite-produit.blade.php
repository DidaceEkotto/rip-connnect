<?php

use App\Models\Product;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;
use App\Models\Image as ImageProduct;

new class extends Component
{
    use WithFileUploads;


    public $product,$page;
    public $productId;

    // Champs du produit
    public $identifiant;
    public $sku;
    public $name;
    public $slug;
    public $type_product;
    public $prix;
    public $description;
    public $status;
    public $content;

    // Images
    public $images = [];
    public $imageInputs = [0];
    public $existingImages = [];
    public $imagesToDelete = [];

    // Validation
    protected $rules = [
        'identifiant' => 'required|string|max:255',
        'sku' => 'required|string|max:255|unique:products,sku',
        'name' => 'required|string|max:255',
        'slug' => 'required|string|max:255|unique:products,slug',
        'type_product' => 'required|in:cerceuil,marbrerie',
        'prix' => 'required|string|max:255',
        'status' => 'required|in:0,1',
        'content' => 'nullable|string',
        'images.*' => 'nullable|image|max:2048',
    ];

    protected $messages = [
        'images.*.image' => 'Le fichier doit être une image.',
        'images.*.max' => 'L\'image ne doit pas dépasser 2MB.',
    ];

    public function mount($productId, $page)
    {
        $this->productId = $productId;
        $this->product = Product::with('images')->findOrFail($productId);
        $this->page = $page;

        // Charger les données du produit
        $this->identifiant = $this->product->identifiant;
        $this->sku = $this->product->sku;
        $this->name = $this->product->name;
        $this->slug = $this->product->slug;
        $this->type_product = $this->product->type_product;
        $this->prix = $this->product->prix;
        $this->status = $this->product->status;
        $this->content = $this->product->content;

        // Charger les images existantes
        $this->existingImages = $this->product->images->toArray();
    }

    public function updatedName($value)
    {
        $this->slug = Str::slug($value);
    }

    public function addImageInput()
    {
        $this->imageInputs[] = count($this->imageInputs);
    }

    public function removeImageInput($index)
    {
        if (count($this->imageInputs) > 1) {
            unset($this->imageInputs[$index]);
            unset($this->images[$index]);
            $this->imageInputs = array_values($this->imageInputs);
            $this->images = array_values($this->images);
        }
    }

    public function deleteExistingImage($imageId)
    {
        $image = ImageProduct::find($imageId);
        if ($image) {
            // Ajouter à la liste des images à supprimer
            $this->imagesToDelete[] = $imageId;

            // Retirer de la liste des images existantes affichées
            $this->existingImages = array_filter($this->existingImages, function($img) use ($imageId) {
                return $img['id'] != $imageId;
            });
            $this->existingImages = array_values($this->existingImages);
        }
    }

    public function restoreImage($imageId)
    {
        // Retirer de la liste des images à supprimer
        $this->imagesToDelete = array_filter($this->imagesToDelete, function($id) use ($imageId) {
            return $id != $imageId;
        });
        $this->imagesToDelete = array_values($this->imagesToDelete);

        // Remettre dans la liste des images existantes
        $image = ImageProduct::find($imageId);
        if ($image) {
            $this->existingImages[] = $image->toArray();
        }
    }

    public function updateProduct()
    {
        // Ajuster la validation pour le SKU et slug en excluant le produit actuel
        $this->rules['sku'] = 'required|string|max:255|unique:products,sku,' . $this->productId;
        $this->rules['slug'] = 'required|string|max:255|unique:products,slug,' . $this->productId;

        $this->validate();

        try {
            // Mettre à jour le produit
            $this->product->update([
                'identifiant' => $this->identifiant,
                'sku' => $this->sku,
                'name' => $this->name,
                'slug' => $this->slug,
                'type_product' => $this->type_product,
                'prix' => $this->prix,
                'content' => $this->content,
                'status' => $this->status,
            ]);

            // Supprimer les images marquées pour suppression
            foreach ($this->imagesToDelete as $imageId) {
                $image = ImageProduct::find($imageId);
                if ($image) {
                    // Supprimer le fichier physique
                   // Storage::disk('public')->delete($image->path);
                    // Supprimer l'enregistrement
                    $image->delete();
                }
            }

            // Ajouter les nouvelles images
            // Traiter les images
            $i = 1;
            foreach ($this->images as $index => $image) {
                if ($image) {

                    $photo = $image;
                    $photo_name = $i++.'-'.time() . '-product-' . auth()->id() . '.' . $photo->getClientOriginalExtension();

                    // Version 4 - Utilisez decode() au lieu de make()
                    $image_resize = Image::decode($photo->getRealPath());
                    //$image_resize->scale(width: null, height: 300); // Redimensionnement (ajustez selon vos besoins)
                    // Sauvegarde de l'image
                    $image_resize->save('storage/images/' . $photo_name);
                    // Créer l'enregistrement image
                    ImageProduct::create([
                        'product_id' => $this->productId,
                        'path' => "storage/images/{$photo_name}",
                        'status' => '1', // active par défaut
                    ]);
                }
            }

            return redirect()->route('admin.produits.liste')->with('success', 'Produit mis à jour avec succès!');


        } catch (\Exception $e) {
            session()->flash('error', 'Erreur lors de la mise à jour du produit: ' . $e->getMessage());
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
                            <h3 class="text-lg font-semibold mb-4">Informations du produit</h3>

                            <div class="">
                                <div class="row">
                                    <div class="col-md-6 col-lg-6">
                                        <label class="block text-gray-700 text-sm font-bold mb-2" for="identifiant">
                                            Identifiant *
                                        </label>
                                        <input type="text" id="identifiant" wire:model="identifiant"
                                            class="form-control @error('identifiant') is-invalid @enderror">
                                        @error('identifiant')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 col-lg-6">
                                        <label class="block text-gray-700 text-sm font-bold mb-2" for="sku">
                                            SKU *
                                        </label>
                                        <input type="text" id="sku" wire:model="sku"
                                            class="form-control @error('sku') is-invalid @enderror">
                                        @error('sku')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 col-lg-12">
                                        <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                                            Nom *
                                        </label>
                                        <input type="text" id="name" wire:model="name"
                                            class="form-control @error('name') is-invalid @enderror">
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 col-lg-6">
                                        <label class="block text-gray-700 text-sm font-bold mb-2" for="type_product">
                                            Type de produit *
                                        </label>
                                        <select id="type_product" wire:model="type_product"
                                            class="form-control @error('type_product') is-invalid @enderror">
                                            <option value="">Choisir une option</option>
                                            <option value="cerceuil">Cerceuil</option>
                                            <option value="marbrerie">Marbrerie</option>
                                            <option value="vehicules">Vehicules</option>
                                            <option value="gerbes_fleurs">gerbes de fleurs</option>
                                        </select>
                                        @error('type_product')
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
