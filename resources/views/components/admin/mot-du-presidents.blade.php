<?php

use App\Models\MotPresident;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;
use Livewire\Component;
use Livewire\WithFileUploads;

new class extends Component
{
    use WithFileUploads;
    public $trixId;
    public $page;
    public $titre = '';
    public $image;
    public $content,$nom,$poste;
    public $president;

    public function mount($page,$president)
    {
        $this->trixId = 'trix-' . Str::random(8);
        $this->president = $president;
        $this->page = $page;
        $this->content = $this->president != null ? $this->president->description : "";
        $this->nom = $this->president != null ? $this->president->nom : "";
        $this->poste = $this->president != null ? $this->president->poste : "";
    }


    public function save()
    {
        $this->validate([
            'nom'          => 'required|min:5|',
            'poste'          => 'required|min:5|',
            'image'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3000',
            'content'      => 'required|min:50',
        ]);


        $image = $this->image;
        if($image )
        {
            $image_name = time() . '-president-' . Auth::guard('admin')->user()->id . '.' . $image->getClientOriginalExtension();
            // Version 4 - Utilisez decode() au lieu de make()
            $image_resize = Image::decode($image->getRealPath());
            //$image_resize->scale(width: null, height: 300); // Redimensionnement (ajustez selon vos besoins)

            // Sauvegarde de l'image
            $image_resize->save('storage/images/' . $image_name);
        }
        if(!empty($this->president))
        {
            $this->president->update([
                'admin_id'      => Auth::guard('admin')->user()->id,
                'nom'      => $this->nom,
                'poste'     => $this->poste,
                'description'   => $this->content,
                'image'         => $image != null ? "storage/images/{$image_name}" : $this->president->image,
                'status'        => 1,
            ]);
        }
        else
        {
            $presi = new MotPresident();
            $presi->admin_id = Auth::guard('admin')->user()->id;
            $presi->nom = $this->nom;
            $presi->poste = $this->poste;
            $presi->description = $this->content;
            if ($image != null) {
                "storage/images/{$image_name}";
            }
            elseif(!empty($this->president->image))
            {
                $this->president->image;
            }
            $presi->save();
        }



        return redirect()->route('admin.mot_du_president')->with('success', 'Mot ajouté avec succès');
    }
};
?>

<div>
    <div class="card">
        <div class="card-body">
            <form wire:submit.prevent="save">

                {{-- Photo --}}
                <div class="row">
                    <div class="col-md-12">
                        <label for="image">Choisir une image</label>
                        <input type="file" wire:model='image' class="form-control" accept=".jpg,.png,.jpeg,.webp">
                        @if ($image)
                            <div class="form-group">
                                <img src="{{ $image->temporaryUrl() }}" style="width: 150px !important;height:200px !important;">
                            </div>
                        @else
                            @if(!empty($this->president->image))
                                <div class="form-group">
                                    <img src="{{ asset($this->president->image) }}" style="width: 150px !important;height:200px !important;">
                                </div>
                            @endif
                        @endif
                        @error('image')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                 <div class="mb-3"></div>
                <div class="row">
                    <div class="col-md-6">
                        <label>Nom complet</label>
                        <input type="text" wire:model='nom' class="form-control">
                        @error('nom')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label>Poste</label>
                        <input type="text" wire:model='poste' class="form-control">
                        @error('poste')
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
