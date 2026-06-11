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

    public $trixId;

    public $nom = '';
    public $prenom = '';
    public $genre = '';
    public $age = '';
    public $date_naissance = '';
    public $date_dece = '';
    public $cause_deces = '';
    public $lieux_deces = '';
    public $content = '';
    public $photo;
    public $date_leve;
    public $heure_leve;

    public function mount()
    {
        $this->trixId = 'trix-' . Str::random(8);
    }


    public function save()
    {
        $this->validate([
            'nom'          => 'required|min:2',
            'prenom'       => 'nullable|min:2',
            'genre'        => 'required|in:Masculin,Féminin',
            'age'          => 'required|numeric',
            'photo'        => 'required|image|mimes:jpg,jpeg,png,webp,gif|max:3000',
            'date_naissance' => 'required|date|before:date_dece',
            'date_dece'    => 'required|date|after:date_naissance',
            'date_leve'    => 'nullable|date|',
            'cause_deces'  => 'required|min:10',
            'content'      => 'required|min:50',
            'heure_leve'      => 'nullable',
        ]);


        $image = $this->photo;
        $image_name = time() . '-banniere-' . Auth::guard('admin')->user()->id . '.' . $image->getClientOriginalExtension();
        // Version 4 - Utilisez decode() au lieu de make()
        $image_resize = Image::decode($image->getRealPath());
        //$image_resize->scale(width: null, height: 300); // Redimensionnement (ajustez selon vos besoins)

        // Sauvegarde de l'image
        $image_resize->save('storage/images/' . $image_name);


        Dece::create([
            'identifiant'   => 'd-' . rand(1000, 999999),
            'admin_id'      => Auth::guard('admin')->id(),
            'nom'           => $this->nom,
            'prenom'        => $this->prenom,
            'genre'         => $this->genre,
            'age'           => $this->age,
            'date_naissance'=> $this->date_naissance,
            'date_dece'     => $this->date_dece,
            'cause_deces'   => $this->cause_deces,
            'lieux_deces'   => $this->lieux_deces,
            'description'   => $this->content,
            'date_leve'     => $this->date_leve,
            'heure_leve'     => $this->heure_leve,
            'photo'         => "storage/images/{$image_name}",
            'status'        => 1,
        ]);

        return redirect()->route('admin.dece.liste')->with('success', 'Décès ajouté avec succès');
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
                        <label for="photo">Choisir une image</label>
                        <input type="file" wire:model='photo' class="form-control" accept=".jpg,.png,.jpeg,.webp">
                         @if ($photo)
                                                    <div class="form-group">
                                                        <img src="{{ $photo->temporaryUrl() }}"
                                                            style="width: 150px !important;height:200px !important;">
                                                    </div>
                                                @endif
                        @error('photo')
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
