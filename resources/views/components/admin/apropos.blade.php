<?php

use App\Models\About;
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
    public $about;

    public function mount($page,$about)
    {
        $this->trixId = 'trix-' . Str::random(8);
        $this->about = $about;
        $this->page = $page;
        $this->content = $this->about != null ? $this->about->description : "";
    }


    public function save()
    {
        $this->validate([
            'image'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3000',
            'content'      => 'required|min:50',
        ]);


        $image = $this->image;
        if($image )
        {
            $image_name = time() . '-apropos-' . Auth::guard('admin')->user()->id . '.' . $image->getClientOriginalExtension();
            // Version 4 - Utilisez decode() au lieu de make()
            $image_resize = Image::decode($image->getRealPath());
            //$image_resize->scale(width: null, height: 300); // Redimensionnement (ajustez selon vos besoins)

            // Sauvegarde de l'image
            $image_resize->save('storage/images/' . $image_name);
        }
        if(!empty($this->about))
        {
            $this->about->update([
                'admin_id'      => Auth::guard('admin')->user()->id,
                'description'   => $this->content,
                'image'         => $image != null ? "storage/images/{$image_name}" : $this->about->image,
                'status'        => 1,
            ]);
        }
        else
        {
            $about = new About();
            $about->admin_id = Auth::guard('admin')->user()->id;
            $about->description = $this->content;
            if ($image != null) {
                "storage/images/{$image_name}";
            }
            elseif(!empty($this->about->image))
            {
                $this->about->image;
            }
            $about->save();
        }



        return redirect()->route('admin.apropos')->with('success', 'Aide ajouté avec succès');
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
                            @if(!empty($this->about->image))
                                <div class="form-group">
                                    <img src="{{ asset($this->about->image) }}" style="width: 150px !important;height:200px !important;">
                                </div>
                            @endif
                        @endif
                        @error('image')
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
