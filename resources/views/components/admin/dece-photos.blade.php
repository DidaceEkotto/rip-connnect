<?php

use App\Models\Photo;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Intervention\Image\Laravel\Facades\Image;
use Livewire\WithFileUploads;

new class extends Component
{
   use WithFileUploads;

    public $page, $photo,$dece,$allPhotos;

    public function mount($page, $dece, $allPhotos)
    {
        $this->page = $page;
        $this->dece = $dece;
        $this->allPhotos = $allPhotos;
    }


    public function storeImage()
    {
        $this->validate([
            "photo"=>"required|mimes:png,jpg,jpeg,webp|max:2999"
        ]);



        $image = $this->photo;
        $image_name = time() . '-banniere-' . Auth::guard('admin')->user()->id . '.' . $image->getClientOriginalExtension();
        // Version 4 - Utilisez decode() au lieu de make()
        $image_resize = Image::decode($image->getRealPath());
        //$image_resize->scale(width: null, height: 300); // Redimensionnement (ajustez selon vos besoins)

        // Sauvegarde de l'image
        $image_resize->save('storage/images/' . $image_name);


        $photo = new Photo();
        $photo->admin_id = Auth::guard("admin")->user()->id;
        $photo->dece_id = $this->dece->id;
        $photo->photo = "storage/images/{$image_name}";
        $photo->type = "dece";
        $photo->save();
        return redirect($this->page)->with("success", "Photo ajouter avec succès");
    }

    public function deletePhoto($photoId)
    {
        $photo = Photo::where('id', $photoId)->first();
        $photo->delete();
        return redirect($this->page)->with("success", "Photo supprimer avec succès");
    }
};
?>

<div>

    <!-- debut du contenue -->
    <div class="mt-5"></div>
    <div class="container-fluid">

        <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#createCategorie"
            class="btn btn-primary d-none d-sm-inline-block mb-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <path d="M12 5l0 14"></path>
                <path d="M5 12l14 0"></path>
            </svg>
            Ajouter une photo
        </a>

        <div wire:ignore.self class="modal fade" id="createCategorie" data-bs-backdrop="static" data-bs-keyboard="false"
            tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <form wire:submit.prevent='storeImage()' autocomplete="off">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="staticBackdropLabel"> Ajouter une photo </h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12 col-lg-12">
                                    <label for="photo">Image du féfunt</label>
                                    <input type="file" class="form-control" wire:model="photo" id="photo"
                                        accept=".jpg,.jpeg,.webp,.png">
                                    @error('photo')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    @if ($photo)
                                        <div class="mt-2">
                                            <img src="{{ $photo->temporaryUrl() }}" width="120" height="120"
                                                alt="Preview de l'image">
                                        </div>
                                    @endif
                                </div>

                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                            <button type="submit" wire:target="storeImage" class="btn btn-primary">
                                <span wire:loading.remove wire:target="storeImage">Enregister</span>
                                <span wire:loading wire:target="storeImage">
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

    <div class="mt-2"></div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-7">
                <div class="card">
                    <div class="card-header">
                        <p>Ajouter des photos à {{ $this->dece->nom . ' ' . $this->dece->prenom }}</p>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach ($allPhotos as $photo)
                                <div class="col-md-4 col-lg-4">
                                    <p class="mt-2">
                                        <img src="{{ asset($photo->photo) }}">
                                    </p>
                                    <a href="javascript:void(0);" class="" data-bs-toggle="modal"
                                        data-bs-target="#supprimerPhoto{{ $photo->id }}"
                                        style="color: red !important;">
                                        Supprimer
                                    </a>
                                    <div wire:ignore.self class="modal fade" id="supprimerPhoto{{ $photo->id }}"
                                        data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                                        aria-labelledby="desactiverCategoryLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="desactiverCategoryLabel">
                                                        Supprimer la photo
                                                    </h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Voulez-vous vraiment supprimer cette photo ?</p>
                                                    <img src="{{ asset($photo->photo) }}"
                                                        style="width: 200px !important;height:300px !important;">
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Fermer</button>

                                                    <button type="submit"
                                                        wire:click="deletePhoto({{ $photo->id }})"
                                                        wire:target="deletePhoto({{ $photo->id }})"
                                                        class="btn btn-success">
                                                        <span wire:loading.remove
                                                            wire:target="deletePhoto({{ $photo->id }})">Supprimer</span>
                                                        <span wire:loading
                                                            wire:target="deletePhoto({{ $photo->id }})">
                                                            <span class="spinner-border spinner-border-sm"
                                                                role="status" aria-hidden="true"></span>
                                                            Suppression en cours...
                                                        </span>
                                                    </button>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
