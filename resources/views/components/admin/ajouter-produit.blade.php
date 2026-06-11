<?php

use App\Models\Image as ImageProduct;
use App\Models\Product;
use Livewire\Component;
use Intervention\Image\Laravel\Facades\Image;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;

new class extends Component
{
    use WithFileUploads;
    public $page;
    public $identifiant;
    public $sku;
    public $name;
    public $slug;
    public $type_product;
    public $prix;
    public $content = '';
    public $status = '0';

    // Images
    public $images = [];
    public $imageInputs = [0]; // Au moins un champ requis

    // Validation
    protected $rules = [
        'identifiant' => 'required|string|max:255',
        'sku' => 'required|string|max:255|unique:products',
        'name' => 'required|string|max:255',
        'type_product' => 'required|in:cerceuil,marbrerie',
        'prix' => 'required|string|max:255',
        'content' => 'nullable|string',
        'status' => 'required|in:0,1',
        'images.*' => 'required|image|max:2048', // 2MB max
    ];

    protected $messages = [
        'identifiant.required' => 'L\'identifiant est obligatoire.',
        'sku.required' => 'Le SKU est obligatoire.',
        'name.required' => 'Le nom est obligatoire.',
        'type_product.required' => 'Le type de produit est obligatoire.',
        'prix.required' => 'Le prix est obligatoire.',
        'content.required' => 'La description est obligatoire.',
        'status.required' => 'Le statut est obligatoire.',
        'images.*.required' => 'Une image est obligatoire.',
        'images.*.image' => 'Le fichier doit être une image.',
        'images.*.max' => 'L\'image ne doit pas dépasser 2MB.',
    ];

    public function mount()
    {
        $this->sku = 'SKU-' . strtoupper(Str::random(6));
        $this->identifiant = 'ID-' . strtoupper(Str::random(6));
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

    public function save()
    {
        $this->validate();

        try {
            // Créer le produit
            $product = Product::create([
                'identifiant' => $this->identifiant,
                'sku' => $this->sku,
                'admin_id' => Auth::guard('admin')->user()->id,
                'name' => $this->name,
                'slug' => Str::slug($this->name),
                'type_product' => $this->type_product,
                'prix' => $this->prix,
                'content' => $this->content,
                'status' => "1",
            ]);

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
                        'product_id' => $product->id,
                        'path' => "storage/images/{$photo_name}",
                        'status' => '1', // active par défaut
                    ]);
                }
            }

           return redirect()->route('admin.produits.liste')->with('success', 'Produit créé avec succès!');

            // Réinitialiser le formulaire
            // $this->reset();
            // $this->imageInputs = [0];
            // $this->mount();

        } catch (\Exception $e) {
            session()->flash('error', 'Erreur lors de la création du produit: ' . $e->getMessage());
        }
    }
};
?>

<div>
    <div class="container-fluid p-4">
        <div class="card">

            <div class="card-body">
                @if (session()->has('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session()->has('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        {{ session('error') }}
                    </div>
                @endif

                <form wire:submit.prevent="save" enctype="multipart/form-data" autocomplete="off">
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
                                            class="form-control @error('identifiant') border-red-500 @enderror">
                                        @error('identifiant')
                                            <p style="color:red !important;" class="text-xs italic mt-1">{{ $message }}
                                            </p>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 col-lg-6">
                                        <label class="block text-gray-700 text-sm font-bold mb-2" for="sku">
                                            SKU *
                                        </label>
                                        <input type="text" id="sku" wire:model="sku"
                                            class="form-control @error('sku') border-red-500 @enderror">
                                        @error('sku')
                                            <p style="color:red !important;" class="text-xs italic mt-1">{{ $message }}
                                            </p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 col-lg-12">
                                        <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                                            Nom *
                                        </label>
                                        <input type="text" id="name" wire:model="name"
                                            class="form-control @error('name') border-red-500 @enderror">
                                        @error('name')
                                            <p style="color:red !important;" class="text-xs italic mt-1">{{ $message }}
                                            </p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-lg-6">
                                        <label class="block text-gray-700 text-sm font-bold mb-2" for="type_product">
                                            Type de produit *
                                        </label>
                                        <select id="type_product" wire:model="type_product"
                                            class="form-control @error('type_product') border-red-500 @enderror">
                                            <option value="">Choisir une option</option>
                                            <option value="cerceuil">Cerceuil</option>
                                            <option value="marbrerie">Marbrerie</option>
                                            <option value="vehicules">Vehicules</option>
                                            <option value="gerbes_fleurs">gerbes de fleurs</option>
                                        </select>
                                        @error('type_product')
                                            <p style="color:red !important;" class="text-xs italic mt-1">{{ $message }}
                                            </p>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 col-lg-6">
                                        <label class="block text-gray-700 text-sm font-bold mb-2" for="prix">
                                            Prix *
                                        </label>
                                        <input type="text" id="prix" wire:model="prix"
                                            class="form-control @error('prix') border-red-500 @enderror">
                                        @error('prix')
                                            <p style="color:red !important;" class="text-xs italic mt-1">{{ $message }}
                                            </p>
                                        @enderror
                                    </div>
                                </div>
                                <br>

                                {{-- QUILLJS ÉDITEUR --}}
                                <div class="mb-3" wire:ignore>
                                    <label>Description du produit</label>

                                    <!-- Éditeur Quill -->
                                    <div id="quill-editor" style="height: 200px;">{!! $content !!}</div>

                                    <!-- Champ caché contenant le HTML -->
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
                                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('status') border-red-500 @enderror">
                                        <option value="0">Non visible</option>
                                        <option value="1">Visible</option>
                                    </select>
                                    @error('status')
                                        <p style="color:red !important;" class="text-xs italic mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                        </div>
                        <!-- Images -->
                        <div class="col-md-5 col-lg-5">
                            <h3 class="text-lg font-semibold mb-4">Images du produit</h3>

                            <div class="mb-4">
                                <p class="text-sm text-gray-600 mb-4">
                                    <span class="text-red-500">*</span> Au moins une image est obligatoire
                                </p>

                                @foreach ($imageInputs as $index => $input)
                                    <div class="flex items-center gap-4 mb-4"
                                        wire:key="image-input-{{ $index }}">
                                        <div class="flex-1">
                                            <input type="file" wire:model="images.{{ $index }}"
                                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('images.' . $index) border-red-500 @enderror"
                                                accept=".jpeg,.png,.jpg,.webp">
                                            @error('images.' . $index)
                                                <p style="color:red !important;" class="text-xs italic mt-1">
                                                    {{ $message }}</p>
                                            @enderror

                                            @if (isset($images[$index]) && $images[$index])
                                                <div class="mt-2">
                                                    <img src="{{ $images[$index]->temporaryUrl() }}" alt="Preview"
                                                        class="w-32 h-32 object-cover rounded">
                                                </div>
                                            @endif
                                        </div>
                                        <div class="mb-2"></div>
                                        <div class="flex gap-2">
                                            @if (count($imageInputs) > 1)
                                                <button type="button"
                                                    wire:click="removeImageInput({{ $index }})"
                                                    class="btn btn-danger">
                                                    <i class="bi bi-trash me-1"></i>
                                                    Retirer
                                                </button>
                                            @endif

                                            @if ($loop->last)
                                                <button type="button" wire:click="addImageInput"
                                                    class="btn btn-primary">
                                                    <i class="bi bi-plus me-1"></i>
                                                    Ajouter
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <!-- Boutons d'action -->
                        <div class="flex items-center justify-end gap-4">
                            <button type="submit" class="btn btn-primary" wire:target='save'>
                                <span wire:loading.remove wire:target="save">
                                    <i class="bi bi-check-circle me-1"></i> Ajouter le produit
                                </span>
                                <span wire:loading wire:target="save">
                                    <span class="spinner-border spinner-border-sm" role="status"
                                        aria-hidden="true"></span>
                                    Ajout en cours...
                                </span>

                            </button>
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

                // Initialisation de Quill
                var quill = new Quill('#quill-editor', {
                    theme: 'snow'
                });

                // Mise à jour quand l'utilisateur tape
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
