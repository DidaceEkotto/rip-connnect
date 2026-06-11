<?php

use Livewire\Component;
use Intervention\Image\Laravel\Facades\Image;
use App\Models\Dece;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

new class extends Component
{

    use WithFileUploads;
    public $page,$dece,$title;
    public $nom = '';
    public $prenom = '';
    public $genre = '';
    public $age = '';
    public $date_naissance = '';
    public $date_dece = '';
    public $cause_deces = '';
    public $lieux_deces = '';
    public $content = '';
    public $photo,$photo_edite;
    public $photo_show;
    public $date_leve;
    public $heure_leve;
    public $trixId;

    public function mount($page,$dece,$title)
    {
        $this->title = $title;
        $this->dece = $dece;
        $this->page = $page;
        $this->trixId = 'trix-' . Str::random(8);
        $this->nom = $this->dece->nom;
        $this->prenom = $this->dece->prenom;
        $this->genre = $this->dece->genre;
        $this->age = $this->dece->age;
        $this->date_naissance = $this->dece->date_naissance;
        $this->date_dece = $this->dece->date_dece;
        $this->cause_deces = $this->dece->cause_deces;
        $this->lieux_deces = $this->dece->lieux_deces;
        $this->content = $this->dece->description;
        $this->photo_show = $this->dece->photo;
        $this->date_leve = $this->dece->date_leve;
        $this->heure_leve = $this->dece->heure_leve;
    }

    public function editeDece()
    {
        $this->validate([
            'nom'          => 'required|min:2',
            'prenom'       => 'nullable|min:2',
            'genre'        => 'required|in:Masculin,Féminin',
            'age'          => 'required|numeric',
            'photo_edite'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3000',
            'date_naissance' => 'required|date|before:date_dece',
            'date_dece'    => 'required|date|after:date_naissance',
            'date_leve'    => 'nullable|date|',
            'heure_leve'    => 'nullable',
            'cause_deces'  => 'required|min:10',
            'content'      => 'required|min:50',
        ]);

        if($this->photo_edite)
        {
            $image = $this->photo_edite;
            $image_name = time() . '-banniere-' . Auth::guard('admin')->user()->id . '.' . $image->getClientOriginalExtension();
            // Version 4 - Utilisez decode() au lieu de make()
            $image_resize = Image::decode($image->getRealPath());
            //$image_resize->scale(width: null, height: 300); // Redimensionnement (ajustez selon vos besoins)
            // Sauvegarde de l'image
            $image_resize->save('storage/images/' . $image_name);

        }

        $this->dece->update([
            'nom'           => $this->nom,
            'prenom'        => $this->prenom,
            'genre'         => $this->genre,
            'age'           => $this->age,
            'date_naissance'=> $this->date_naissance,
            'date_dece'     => $this->date_dece,
            'cause_deces'   => $this->cause_deces,
            'lieux_deces'   => $this->lieux_deces,
            'date_leve'     => $this->date_leve,
            'heure_leve'     => $this->heure_leve,
            'description'   => $this->content,
            'photo'         => $this->photo_edite != null ? "storage/images/{$image_name}" :$this->dece->photo,
        ]);

        return redirect()->route('admin.dece.liste')->with('success', 'Décès modifier avec succès');
    }
};
?>

<div>
    <div class="card">
        <div class="card-body">
            <form wire:submit.prevent="editeDece">

                {{-- Photo --}}
                <div class="row">
                    <div class="col-md-12">
                        <label for="photo_edite">Choisir une image</label>
                        <input type="file" wire:model='photo_edite' class="form-control" accept=".jpg,.png,.jpeg,.webp">

                        @if($this->photo_edite)
                            <div class="form-group">
                                <img src="{{ $photo_edite->temporaryUrl() }}" style="width: 150px !important;height:200px !important;">
                            </div>
                        @else
                            <div class="form-group">
                                <img src="{{ asset($this->dece->photo) }}" style="width: 150px !important;height:200px !important;">
                            </div>
                        @endif
                        @error('photo_edite')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="mb-3"></div>

                {{-- Nom & Prénom --}}
                <div class="row">
                    <div class="col-md-6">
                        <label>Nom</label>
                        <input type="text" wire:model='nom' class="form-control">
                        @error('nom')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label>Prénom</label>
                        <input type="text" wire:model='prenom' class="form-control">
                        @error('prenom')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="mb-3"></div>

                {{-- Genre & Âge --}}
                <div class="row">
                    <div class="col-md-6">
                        <label>Genre</label>
                        <select wire:model='genre' class="form-control">
                            <option value="">Sélectionner</option>
                            <option value="Masculin">Masculin</option>
                            <option value="Féminin">Féminin</option>
                        </select>
                        @error('genre')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label>Âge</label>
                        <input type="text" wire:model='age' class="form-control">
                        @error('age')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="mb-3"></div>

                {{-- Dates --}}
                <div class="row">
                    <div class="col-md-6">
                        <label>Date de naissance</label>
                        <input type="date" wire:model='date_naissance' class="form-control">
                        @error('date_naissance')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label>Date de décès</label>
                        <input type="date" wire:model='date_dece' class="form-control">
                        @error('date_dece')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="mb-3"></div>
                <div class="row">
                    <div class="col-md-6 col-lg-6">
                        <label>Date de la lévé</label>
                        <input type="date" wire:model='date_leve' class="form-control">
                        @error('date_leve')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6 col-lg-6">
                        <label>Heure de la levè</label>
                        <input type="time" wire:model='heure_leve' class="form-control">
                        @error('heure_leve')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="mb-3"></div>
                {{-- Cause de décès --}}
                <div class="row">
                    <div class="col-md-12 col-lg-12">
                        <label>Cause de décès</label>
                        <input type="text" wire:model='cause_deces' class="form-control">
                        @error('cause_deces')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="mb-3"></div>

                {{-- QUILLJS ÉDITEUR --}}
                <div class="mb-3" wire:ignore>
                    <label>Description / Biographie</label>

                    <!-- Éditeur Quill -->
                    <div id="quill-editor" style="height: 200px;">{!! $content !!}</div>

                    <!-- Champ caché contenant le HTML -->
                    <input type="hidden" id="quill-content">

                    @error('content')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary mt-3">
                    Modification
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
