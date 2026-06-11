<?php

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use App\Models\Banniere;
use Intervention\Image\Laravel\Facades\Image;

new class extends Component
{
    use WithFileUploads;
    public $page,$title, $bannieres;
    public $text_bouton,$image,$date_debut,$date_fin,$petit_text,$grand_text,$lien;
    public $text_bouton_edite,$image_show,$image_edite,$date_debut_edite,$date_fin_edite,$petit_text_edite,$grand_text_edite,$lien_edite;
    public $bannierId;

    public function mount($page,$title)
    {
        $this->page = $page;
        $this->title = $title;
        $this->loadAllImages();
    }

    public function loadAllImages()
    {
        $this->bannieres = Banniere::all();
    }

    public function save()
    {
        $this->validate([
            "image"=>"required|image|mimes:png,jpg,jpeg,webp,gif,svg|max:2999",
            "date_debut"=>"nullable|date",
            "date_fin"=>"nullable|date",
            "text_bouton"=>"nullable|min:5",
            "petit_text"=>"nullable|min:5",
            "grand_text"=>"nullable|min:5",
            "lien"=>"nullable|url"
        ]);

        $image = $this->image;
        $image_name = time() . '-banniere-' . Auth::guard('admin')->user()->id . '.' . $image->getClientOriginalExtension();

        // Version 4 - Utilisez decode() au lieu de make()
        $image_resize = Image::decode($image->getRealPath());
        //$image_resize->scale(width: null, height: 300); // Redimensionnement (ajustez selon vos besoins)

        // Sauvegarde de l'image
        $image_resize->save('storage/images/' . $image_name);

        Banniere::create([
            "admin_id"=> Auth::guard('admin')->user()->id,
            "image"=>"storage/images/{$image_name}",
            "date_debut"=> date("d/m/Y", strtotime($this->date_debut)),
            "date_fin"=> date("d/m/Y", strtotime($this->date_fin)),
            "petit_text"=> $this->petit_text,
            "grand_text"=>$this->grand_text,
            "text_bouton"=>$this->text_bouton,
            "lien"=>$this->lien,
            "status"=>"1"
        ]);

        return redirect($this->page)->with("success", "Banniere ajouter avec succès");
    }

    public function showModalInformation($idBanniere)
    {
        $ban = Banniere::where('id',$idBanniere)->first();
        $this->bannierId = $ban->id;
        $this->image_show = $ban->image;
        $this->date_debut_edite = date('d-m-Y', strtotime($ban->date_debut));
        $this->date_fin_edite = $ban->date_fin;
        $this->petit_text_edite = $ban->petit_text;
        $this->grand_text_edite = $ban->grand_text;
        $this->lien_edite = $ban->lien;
        $this->text_bouton_edite = $ban->text_bouton;
    }

    public function edite($idBanniere)
    {
        $ban = Banniere::where('id',$idBanniere)->first();

        $this->validate([
            "image_edite"=>"nullable|image|mimes:png,jpg,jpeg,webp,gif,svg|max:2999",
            "date_debut_edite"=>"nullable|date",
            "date_fin_edite"=>"nullable|date",
            "petit_text_edite"=>"nullable|min:5",
            "grand_text_edite"=>"nullable|min:5",
            "text_bouton"=>"nullable|min:5",
            "lien_edite"=>"nullable|url"
        ]);

        if($this->image_edite != null)
        {
            $image = $this->image_edite;
            $image_name = time() . '-banniere-' . Auth::guard('admin')->user()->id . '.' . $image->getClientOriginalExtension();
            $image_resize = Image::decode($image->getRealPath());
            //$image_resize->scale(width: null, height: 300); // Redimensionnement (ajustez selon vos besoins)
            $image_resize->save('storage/images' . $image_name);

            $ban->update([
                "image"=>"storage/images/{$image_name}",
                "date_debut"=> date("d/m/Y", strtotime($this->date_debut_edite)),
                "date_fin"=> date("d/m/Y", strtotime($this->date_fin_edite)),
                "petit_text"=> $this->petit_text_edite,
                "grand_text"=>$this->grand_text_edite,
                "lien"=>$this->lien_edite,
                "text_bouton"=>$this->text_bouton_edite
            ]);
        }
        else
        {
            $ban->update([
                "date_debut"=> date("d/m/Y", strtotime($this->date_debut_edite)),
                "date_fin"=> date("d/m/Y", strtotime($this->date_fin_edite)),
                "petit_text"=> $this->petit_text_edite,
                "grand_text"=>$this->grand_text_edite,
                "lien"=>$this->lien_edite,
                "text_bouton"=>$this->text_bouton_edite
            ]);
        }

        return redirect($this->page)->with("success", "Banniere Modifier avec succès");
    }

    public function deleteBanniere($idBanniere)
    {
        $ban = Banniere::where('id',$idBanniere)->first();
        $ban->delete();
        return redirect($this->page)->with("success", "Banniere Supprimer Avec succès");
    }
};
?>

<div>
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">

                <!-- Page title actions -->
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="javascript:void(0);" class="btn btn-primary d-none d-sm-inline-block"
                            data-bs-toggle="modal" data-bs-target="#modal-large">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M12 5l0 14"></path>
                                <path d="M5 12l14 0"></path>
                            </svg>
                            Ajouter une bannière
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br><br>

    <!-- Page header -->
    <div class="d-print-none">
        <div class="">
            <div class="row g-2 align-items-center">

                <!-- Page title actions -->
                <div class="col-auto ms-auto d-print-none">


                    <div wire:ignore.self class="modal modal-blur fade" id="modal-large" data-bs-backdrop="static"
                        tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                            <form wire:submit.prevent='save()' autocomplete="off">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Ajouter une bannière</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-6 col-lg-6">
                                                <div class="form-group">
                                                    <label for="image">Image</label>
                                                    <input type="file" wire:model='image'
                                                        accept=".jpg,.jpeg,.png,.webp,.gif,.svg " id="image"
                                                        class="form-control">
                                                    {!! $errors->first('image', '<span style="color:red;font-weight:bold">:message</span>') !!}
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-lg-6">
                                                <div class="form-group">
                                                    <label for="lien">Lien (Facultatif) </label>
                                                    <input type="text" wire:model='lien' id="lien"
                                                        class="form-control">
                                                    {!! $errors->first('lien', '<span style="color:red;font-weight:bold">:message</span>') !!}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="form-group">
                                                <label for="text_bouton">Text du button (Faculatatif)</label>
                                                <input type="text" wire:model='text_bouton' class="form-control"
                                                    id="text_bouton">
                                                {!! $errors->first('text_bouton', '<span style="color:red;font-weight:bold">:message</span>') !!}
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-md-6 col-lg-6">
                                                <div class="form-group">
                                                    <label for="date_debut">Date début (Facultatif)</label>
                                                    <input type="date" class="form-control" wire:model='date_debut'
                                                        id="date_debut">
                                                    {!! $errors->first('date_debut', '<span style="color:red;font-weight:bold">:message</span>') !!}
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-lg-6">
                                                <div class="form-group">
                                                    <label for="date_fin">Date fin (Facultatif)</label>
                                                    <input type="date" class="form-control" wire:model='date_fin'
                                                        id="date_fin">
                                                    {!! $errors->first('date_fin', '<span style="color:red;font-weight:bold">:message</span>') !!}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-md-12 col-lg-12">
                                                <label for="petit_text">Petite description (Facultatif)</label>
                                                <textarea class="form-control" wire:model='petit_text' id="petit_text"
                                                    style="resize: none !important;width:100% !important;height:100px !important;"></textarea>
                                                {!! $errors->first('petit_text', '<span style="color:red;font-weight:bold">:message</span>') !!}
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-md-12 col-lg-12">
                                                <label for="grand_text">Description (Facultatif)</label>
                                                <textarea class="form-control" wire:model='grand_text' id="grand_text"
                                                    style="resize: none !important;width:100% !important;height:100px !important;"></textarea>
                                                {!! $errors->first('grand_text', '<span style="color:red;font-weight:bold">:message</span>') !!}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn me-auto"
                                            data-bs-dismiss="modal">Fermer</button>
                                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- Page body -->
    <div class="page-body">
        <div class="">
            <div class="row row-deck row-cards">
                <div class="col-md-12 col-lg-12">

                        <div class="card">
                            <div class="table-responsive">
                                <table class="table table-vcenter card-table">
                                    <thead>
                                        <tr>
                                            <th>Image</th>
                                            <th>Text boutton</th>
                                            <th>Lien</th>
                                            <th>Date début</th>
                                            <th>Date fin</th>
                                            <th>Petite description</th>
                                            <th>Desciption</th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($bannieres as $banniere)
                                            <tr>
                                                <td>
                                                    <div class="d-flex py-1 align-items-center">
                                                        <img src="{{ asset($banniere->image) }}"
                                                            style="width:50px !important;height:50px !important;">
                                                    </div>
                                                </td>
                                                <td>
                                                    <p>{{ $banniere->text_bouton }}</p>
                                                </td>
                                                <td>
                                                    <p>{{ $banniere->lien }}</p>
                                                </td>
                                                <td>
                                                    <p>{{ date('d/m/Y', strtotime($banniere->date_debut)) }}</p>
                                                </td>
                                                <td>
                                                    <p>{{ date('d/m/Y', strtotime($banniere->date_fin)) }}</p>
                                                </td>
                                                <td>
                                                    <p>
                                                        {{ $banniere->petit_text }}
                                                    </p>
                                                </td>
                                                <td>
                                                    <p>
                                                        {{ $banniere->grand_text }}
                                                    </p>
                                                </td>
                                                <td>
                                                    <a href="javascript:void(0);" data-bs-toggle="modal"
                                                        data-bs-target="#modal-edite"
                                                        wire:click='showModalInformation({{ $banniere->id }})'>Modifier</a>
                                                    <a href="javascript:void(0);" data-bs-toggle="modal"
                                                        data-bs-target="#modal-supprimer"
                                                        style="color: red !important;">Supprimer</a>


                                                    <div wire:ignore.self class="modal modal-blur fade"
                                                        id="modal-supprimer" data-bs-backdrop="static" tabindex="-1"
                                                        role="dialog" aria-hidden="true">
                                                        <div class="modal-dialog modal-md modal-dialog-centered"
                                                            role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Suppression
                                                                    </h5>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal"
                                                                        aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <p class="text-center">
                                                                        Supprimer cette bannière de
                                                                        manière définitive
                                                                    </p>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn me-auto"
                                                                        data-bs-dismiss="modal">Non</button>
                                                                    <a href="javascript:void(0);"
                                                                        wire:click='deleteBanniere({{ $banniere->id }})'
                                                                        class="btn btn-danger">Oui</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </td>

                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                </div>
            </div>
        </div>
    </div>


    @if ($this->bannierId)
        {{-- debut du modal pour modifier les données  --}}

        <div wire:ignore.self class="modal modal-blur fade" id="modal-edite" data-bs-backdrop="static"
            tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <form wire:submit.prevent='showModalInformation({{ $this->bannierId }})' autocomplete="off">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Modifier l'organisme</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="image_edite">Image</label>
                                        <input type="file" wire:model='image_edite'
                                            accept=".jpg,.jpeg,.png,.webp,.gif,.svg " id="image_edite"
                                            class="form-control">
                                        {!! $errors->first('image_edite', '<span style="color:red;font-weight:bold">:message</span>') !!}
                                    </div>
                                    @if ($this->image_show)
                                        <div class="form-group">
                                            <img src="{{ url($this->image_show) }}"
                                                style="width: 100% !important;height:60px !important;">
                                        </div>
                                    @else
                                        <div class="form-group">
                                            <img src="{{ $image_edite->temporaryUrl() }}"
                                                style="width: 100% !important;height:60px !important;">
                                        </div>
                                    @endif
                                </div>
                                <div class="row mt-3">
                                    <div class="form-group">
                                        <label for="text_bouton_edite">Text du button (Faculatatif)</label>
                                        <input type="text" wire:model='text_bouton_edite' class="form-control"
                                            id="text_bouton_edite">
                                        {!! $errors->first('text_bouton_edite', '<span style="color:red;font-weight:bold">:message</span>') !!}
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="lien_edite">Lien (Facultatif) </label>
                                        <input type="text" wire:model='lien_edite' id="lien_edite"
                                            class="form-control">
                                        {!! $errors->first('lien_edite', '<span style="color:red;font-weight:bold">:message</span>') !!}
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="date_debut_fin">Date début (Facultatif)</label>
                                        <input type="date" class="form-control" wire:model='date_debut_fin'
                                            id="date_debut_fin">
                                        {!! $errors->first('date_debut_fin', '<span style="color:red;font-weight:bold">:message</span>') !!}
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="date_fin_edite">Date fin (Facultatif)</label>
                                        <input type="date" class="form-control" wire:model='date_fin_edite'
                                            id="date_fin_edite">
                                        {!! $errors->first('date_fin_edite', '<span style="color:red;font-weight:bold">:message</span>') !!}
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-12 col-lg-12">
                                    <label for="petit_text_edite">Petite description (Facultatif)</label>
                                    <textarea class="form-control" wire:model='petit_text_edite' id="petit_text_edite"
                                        style="resize: none !important;width:100% !important;height:100px !important;"></textarea>
                                    {!! $errors->first('petit_text_edite', '<span style="color:red;font-weight:bold">:message</span>') !!}
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-12 col-lg-12">
                                    <label for="grand_text_edite">Description (Facultatif)</label>
                                    <textarea class="form-control" wire:model='grand_text_edite' id="grand_text_edite"
                                        style="resize: none !important;width:100% !important;height:100px !important;"></textarea>
                                    {!! $errors->first('grand_text_edite', '<span style="color:red;font-weight:bold">:message</span>') !!}
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn me-auto" data-bs-dismiss="modal">Fermer</button>
                            <button type="submit" class="btn btn-primary">Modifier</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        {{-- fin du modal pour modifier les données  --}}
    @endif
</div>

