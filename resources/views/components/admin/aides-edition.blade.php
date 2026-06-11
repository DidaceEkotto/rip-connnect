<?php

use Livewire\Component;
use Intervention\Image\Laravel\Facades\Image;
use App\Models\Aide;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

new class extends Component
{

    use WithFileUploads;
    public $page,$aide,$title;
    public $titre;
    public $description;
    public $image,$image_edite;
    public $image_show;
    public $content;
    public $trixId;

    public function mount($page,$aide,$title)
    {
        $this->title = $title;
        $this->aide = $aide;
        $this->page = $page;
        $this->trixId = 'trix-' . Str::random(8);
        $this->titre = $this->aide->titre;
        $this->content = $this->aide->content;
        $this->image_show = $this->aide->image;
    }

    public function editeDece()
    {
        $this->validate([
            'titre'          => 'required|min:5|unique:aides,titre,'.$this->aide->id,
            'image_edite'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3000',
            'content'      => 'required|min:50|unique:aides,content,'.$this->aide->id,
        ]);


        if($this->image_edite)
        {
            $image = $this->image_edite;
            $image_name = time() . '-aides-' . Auth::guard('admin')->user()->id . '.' . $image->getClientOriginalExtension();
            // Version 4 - Utilisez decode() au lieu de make()
            $image_resize = Image::decode($image->getRealPath());
            //$image_resize->scale(width: null, height: 300); // Redimensionnement (ajustez selon vos besoins)
            // Sauvegarde de l'image
            $image_resize->save('storage/images/' . $image_name);

        }

        $this->aide->update([
            'titre'           => $this->titre,
            'slug'        => Str::slug($this->titre),
            'content'   => $this->content,
            'status'        => 1,
            'image'         => $this->image_edite != null ? "storage/images/{$image_name}" :$this->aide->image,
        ]);

        return redirect()->route('admin.aides.liste')->with('success', 'Aides modifier avec succès');
    }

    public function deleteAide($idAide)
    {
        $aide = Aide::find($idAide);
        $aide->delete();
        return redirect()->route('admin.aides.liste')->with('success', 'Aide supprimer avec succès');
    }
};
?>

<div>
    <div class="card">
        <div class="card-body">
            <div>
                  <a href="javascript:void(0);" class="btn btn-danger" data-bs-toggle="modal"
                                                            data-bs-target="#modal-small-{{ $this->aide->id }}"
                                                           >Supprimer</a>
                                                        <div wire:ignore.self class="modal modal-blur fade"
                                                            data-bs-backdrop="static"
                                                            id="modal-small-{{ $this->aide->id }}" tabindex="-1"
                                                            role="dialog" aria-hidden="true">
                                                            <div class="modal-dialog modal-sm modal-dialog-centered"
                                                                role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-body">
                                                                        <div class="modal-title">Est-vous sûr?</div>
                                                                        <div>
                                                                            Voulez-vous vraiment supprimer
                                                                            : {{ $this->aide->titre }}
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button"
                                                                            class="btn btn-link link-secondary me-auto"
                                                                            data-bs-dismiss="modal">Fermer</button>
                                                                        <button
                                                                            wire:click='deleteAide({{ $this->aide->id }})'
                                                                            class="btn btn-danger">Oui supprimer</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

            </div>
            <form wire:submit.prevent="editeDece">

                {{-- Photo --}}
                <div class="row">
                    <div class="col-md-6">
                        <label for="image_edite">Choisir une image</label>
                        <input type="file" wire:model='image_edite' class="form-control" accept=".jpg,.png,.jpeg,.webp">

                        @if($this->image_edite)
                            <div class="form-group">
                                <img src="{{ $image_edite->temporaryUrl() }}" style="width: 150px !important;height:200px !important;">
                            </div>
                        @else
                            <div class="form-group">
                                <img src="{{ asset($this->image_show) }}" style="width: 150px !important;height:200px !important;">
                            </div>
                        @endif
                        @error('image_edite')
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
