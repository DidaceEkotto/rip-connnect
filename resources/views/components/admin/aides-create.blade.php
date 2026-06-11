<?php

use App\Models\Aide;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;
use Livewire\Component;
use Livewire\WithFileUploads;


new class extends Component
{

    use WithFileUploads;
    public $trixId;

    public $titre = '';
    public $image;
    public $content;

    public function mount()
    {
        $this->trixId = 'trix-' . Str::random(8);
    }


    public function save()
    {
        $this->validate([
            'titre'          => 'required|min:5|unique:aides,titre',
            'image'        => 'required|image|mimes:jpg,jpeg,png,webp,gif|max:3000',
            'content'      => 'required|min:50|unique:aides,content',
        ]);


        $image = $this->image;
        $image_name = time() . '-aides-' . Auth::guard('admin')->user()->id . '.' . $image->getClientOriginalExtension();
        // Version 4 - Utilisez decode() au lieu de make()
        $image_resize = Image::decode($image->getRealPath());
        //$image_resize->scale(width: null, height: 300); // Redimensionnement (ajustez selon vos besoins)

        // Sauvegarde de l'image
        $image_resize->save('storage/images/' . $image_name);
        Aide::create([
            'admin_id'      => Auth::guard('admin')->id(),
            'titre'           => $this->titre,
            'slug'        => Str::slug($this->titre),
            'content'   => $this->content,
            'image'         => "storage/images/{$image_name}",
            'status'        => 1,
        ]);

        return redirect()->route('admin.aides.liste')->with('success', 'Aide ajouté avec succès');
    }
};
?>

<div>
    <div class="card">
        <div class="card-body">
            <form wire:submit.prevent="save">

                {{-- Photo --}}
                <div class="row">
                    <div class="col-md-6">
                        <label for="image">Choisir une image</label>
                        <input type="file" wire:model='image' class="form-control" accept=".jpg,.png,.jpeg,.webp">
                        @if ($image)
                            <div class="form-group">
                                <img src="{{ $image->temporaryUrl() }}" style="width: 150px !important;height:200px !important;">
                            </div>
                        @endif
                        @error('image')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label>titre</label>
                        <input type="text" wire:model='titre' class="form-control">
                        @error('titre')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="mb-3"></div>

                {{-- QUILLJS ÉDITEUR --}}
                <div class="mb-3" wire:ignore>
                    <label>Description </label>

                    <!-- Éditeur Quill -->
                    <div id="quill-editor" style="height: 400px;">{!! $content !!}</div>

                    <!-- Champ caché contenant le HTML -->
                    <input type="hidden" id="quill-content">

                    @error('content')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary mt-3">
                    Enregistrer
                </button>
            </form>

            @if (session()->has('message'))
                <div class="alert alert-success mt-3">
                    {{ session('message') }}
                </div>
            @endif
        </div>
    </div>

    {{-- QUILL CSS --}}


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
