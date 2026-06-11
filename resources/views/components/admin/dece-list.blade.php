<?php

use Livewire\Component;
use App\Models\Dece;

new class extends Component
{
    public $page,$deces;
    public function mount($page,$deces)
    {
        $this->page = $page;
        $this->deces = $deces;
    }

    public function mettePromotion($deceId)
    {
        $deceExists = Dece::where('promotion','1')->update([
            "promotion"=>null
        ]);

        $promotion = Dece::where('id',$deceId)->update([
            "promotion"=>1
        ]);
        return redirect($this->page)->with("success", "Promotion ajouter avec succès");
    }
};
?>

<div>
    <div class="col-md-12 col-lg-12">
                                @if ($deces->count() > 0)
                                    <div class="card">
                                        <div class="table-responsive">
                                            <table class="table table-vcenter card-table">
                                                <thead>
                                                    <tr>
                                                        <th>Image</th>
                                                        <th>Nom & prenom</th>
                                                        <th>Cause de décé</th>
                                                        <th>Date</th>
                                                        <th>Age</th>
                                                        <th></th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($deces as $dece)
                                                        <tr>
                                                            <td>
                                                                <div class="d-flex py-1 align-items-center">
                                                                    <img src="{{ asset($dece->photo) }}"
                                                                        style="width:50px !important;height:50px !important;">
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <p>{{ $dece->nom . ' ' . $dece->prenom }}</p>
                                                            </td>

                                                            <td>
                                                                {{ $dece->cause_deces }}
                                                            </td>

                                                            <td>
                                                                {{ date('d/m/Y', strtotime($dece->date_naissance)) . ' - ' . date('d/m/Y', strtotime($dece->date_dece)) }}
                                                            </td>
                                                            <td>
                                                                <p>{{ $dece->age }} Ans</p>
                                                            </td>
                                                            <td>
                                                                <a
                                                                    href="{{ route('admin.dece.edite', ['id' => $dece->id]) }}">Modifier</a>&nbsp;
                                                                <a
                                                                    href="{{ route('admin.dece.photos', ['id' => $dece->id]) }}">Photo</a>&nbsp;
                                                                <a
                                                                    href="{{ route('admin.dece.programme', ['id' => $dece->id]) }}">Programe</a>&nbsp;
                                                            </td>
                                                            <td>
                                                                @if($dece->promotion == 1)
                                                                    <button class="btn btn-success">Promo</button>
                                                                @endif
                                                                @if($dece->promotion == null)
                                                                     <a href="javascript:void(0);" data-bs-toggle="modal"
                                                                    data-bs-target="#modal-edite{{ $dece->id }}">Promotion</a>


                                                                    <div wire:ignore.self class="modal modal-blur fade"
                                                                        data-bs-backdrop="static"
                                                                        id="modal-edite{{ $dece->id }}" tabindex="-1"
                                                                        role="dialog" aria-hidden="true">
                                                                        <div class="modal-dialog modal-sm modal-dialog-centered"
                                                                            role="document">
                                                                            <div class="modal-content">
                                                                                <div class="modal-body">
                                                                                    <div class="modal-title">Est-vous sûr?
                                                                                    </div>
                                                                                    <div>
                                                                                        Voulez-vous vraiment mettre ce décè en promotion

                                                                                    </div>
                                                                                </div>
                                                                                <div class="modal-footer">
                                                                                    <button type="button"
                                                                                        class="btn btn-link link-secondary me-auto"
                                                                                        data-bs-dismiss="modal">Fermer</button>
                                                                                    <button
                                                                                        wire:click='mettePromotion({{ $dece->id }})'
                                                                                        class="btn btn-success">Oui
                                                                                        mettre</button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                            <td>
                                                            {{-- <td>
                                                                <a href="javascript:void(0);" data-bs-toggle="modal"
                                                                    data-bs-target="#modal-edite"
                                                                    wire:click='showUpdate({{ $organisme->id }})'>Modifier</a>
                                                            </td>
                                                            <td>
                                                                @if ($organisme->status == '0')
                                                                    <a href="javascript:void(0);" data-bs-toggle="modal"
                                                                        data-bs-target="#modal-small-{{ $organisme->id }}"
                                                                        style="color:green">Activer</a>
                                                                    <div wire:ignore.self class="modal modal-blur fade"
                                                                        data-bs-backdrop="static"
                                                                        id="modal-small-{{ $organisme->id }}" tabindex="-1"
                                                                        role="dialog" aria-hidden="true">
                                                                        <div class="modal-dialog modal-sm modal-dialog-centered"
                                                                            role="document">
                                                                            <div class="modal-content">
                                                                                <div class="modal-body">
                                                                                    <div class="modal-title">Est-vous sûr?
                                                                                    </div>
                                                                                    <div>
                                                                                        Voulez-vous vraiment activer
                                                                                        l'organisation
                                                                                        : {{ $organisme->name }}
                                                                                    </div>
                                                                                </div>
                                                                                <div class="modal-footer">
                                                                                    <button type="button"
                                                                                        class="btn btn-link link-secondary me-auto"
                                                                                        data-bs-dismiss="modal">Fermer</button>
                                                                                    <button
                                                                                        wire:click='showOrganisme({{ $organisme->id }})'
                                                                                        class="btn btn-success"
                                                                                        data-bs-dismiss="modal">Oui
                                                                                        activer</button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @else
                                                                    <a href="javascript:void(0);" data-bs-toggle="modal"
                                                                        data-bs-target="#modal-small-{{ $organisme->id }}"
                                                                        style="color:red !important;">Désactiver</a>
                                                                    <div wire:ignore.self class="modal modal-blur fade"
                                                                        data-bs-backdrop="static"
                                                                        id="modal-small-{{ $organisme->id }}"
                                                                        tabindex="-1" role="dialog" aria-hidden="true">
                                                                        <div class="modal-dialog modal-sm modal-dialog-centered"
                                                                            role="document">
                                                                            <div class="modal-content">
                                                                                <div class="modal-body">
                                                                                    <div class="modal-title">Est-vous sûr?
                                                                                    </div>
                                                                                    <div>
                                                                                        Voulez-vous vraiment désactiver
                                                                                        l'organisme:
                                                                                        {{ $organisme->name }}
                                                                                    </div>
                                                                                </div>
                                                                                <div class="modal-footer">
                                                                                    <button type="button"
                                                                                        class="btn btn-link link-secondary me-auto"
                                                                                        data-bs-dismiss="modal">Fermer</button>
                                                                                    <button
                                                                                        wire:click='hideOrganisme({{ $organisme->id }})'
                                                                                        class="btn btn-danger"
                                                                                        data-bs-dismiss="modal">Oui
                                                                                        désactiver</button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endif

                                                            </td> --}}
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                @else
                                    <div class="card">
                                        <div class="card-body">
                                            Pas d'avis et décé pour le moment
                                        </div>
                                    </div>
                                @endif
                            </div>
</div>
