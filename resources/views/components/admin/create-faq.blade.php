<?php

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\Faq;

new class extends Component
{
    public $page,$question,$reponse,$title,$allFaqs;
    public $faqsId,$question_edite,$reponse_edite;

    public function mount($page,$title)
    {
        $this->page = $page;
        $this->title = $title;
        $this->loadFaqs();
    }

    public function loadFaqs()
    {
        $this->allFaqs = Faq::all();
    }

    public function saveFaq()
    {
        $this->validate([
            "question"=>"required|min:10|unique:faqs,question",
            "reponse"=>"required|min:10|unique:faqs,reponse",
        ]);

        $faqs = new Faq();
        $faqs->identifiant = uniqId();
        $faqs->admin_id = Auth::guard('admin')->user()->id;
        $faqs->question = $this->question;
        $faqs->reponse = $this->reponse;
        $faqs->status = "1";
        $faqs->save();
        return redirect($this->page)->with("success", "Faq ajouter avec succès");
    }

    public function showFaqs($idFaqs)
    {
        $faq = Faq::find($idFaqs);
        $this->faqsId = $idFaqs;
        $this->question_edite = $faq->question;
        $this->reponse_edite = $faq->reponse;
    }

    public function editeFaq()
    {
        $this->validate([
            "question_edite"=>"required|min:10|unique:faqs,question,".$this->faqsId,
            "reponse_edite"=>"required|min:10|unique:faqs,reponse,".$this->faqsId,
        ]);

        $faq = Faq::find($this->faqsId);
        $faq->update([
            "question" => $this->question_edite,
            "reponse" => $this->reponse_edite,
        ]);
        return redirect($this->page)->with("success", "Faq modifier avec succès");
    }

    public function deleteFaqs($idFaqs)
    {
        $faq = Faq::find($idFaqs);
        $faq->delete();
        return redirect($this->page)->with("success", "Faq supprimer avec succès");
    }
};
?>

<div>

    <!-- Page body -->
    <div class="page-body">
        <div class="container-fluid">
            <div class="row row-deck row-cards">
                <div class="col-md-7 col-lg-7">

                     <!-- Page title actions -->
                <div class="col-auto ms-auto d-print-none">
                    <br>
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
                            Ajouter une faq
                        </a>
                    </div>

                    <div wire:ignore.self class="modal modal-blur fade" id="modal-large" data-bs-backdrop="static"
                        tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                            <form wire:submit.prevent='saveFaq()' autocomplete="off">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Ajouter une faq</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">

                                            <div class="col-md-12 col-lg-12">
                                                <div class="form-group">
                                                    <label for="question">Question </label>
                                                    <textarea type="text" wire:model='question' id="question"
                                                        class="form-control" style="width: 100% !important;height:200px !important;resize:none !important;"></textarea>
                                                    {!! $errors->first('question', '<span style="color:red;font-weight:bold">:message</span>') !!}
                                                </div>
                                            </div>

                                            <div class="col-md-12 col-lg-12">
                                                <div class="form-group">
                                                    <label for="reponse">Reponse </label>
                                                    <textarea type="text" wire:model='reponse' id="reponse"
                                                        class="form-control" style="width: 100% !important;height:200px !important;resize:none !important;"></textarea>
                                                    {!! $errors->first('reponse', '<span style="color:red;font-weight:bold">:message</span>') !!}
                                                </div>
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
                <p style="clear: both !important;"></p>
                <br>

                    @if ($allFaqs->count() > 0)
                        <div class="card">
                            <div class="table-responsive">
                                <table class="table table-vcenter card-table">
                                    <thead>
                                        <tr>
                                            <th>Question</th>
                                            <th>reponse</th>
                                            <th>Statut</th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($allFaqs as $faq)
                                            <tr>

                                                <td>
                                                    <p>{{ $faq->question }}</p>
                                                </td>
                                                <td>
                                                    <p>{{ $faq->reponse }}</p>
                                                </td>
                                                <td>
                                                    <div>{{ $faq->status == '0' ? 'Inactif' : 'Actif' }}</div>
                                                </td>
                                                <td>
                                                    <a href="javascript:void(0);" data-bs-toggle="modal"
                                                        data-bs-target="#modal-edite"
                                                        wire:click='showFaqs({{ $faq->id }})'>Modifier</a>
                                                </td>
                                                <td>
                                                        <a href="javascript:void(0);" data-bs-toggle="modal"
                                                            data-bs-target="#modal-small-{{ $faq->id }}"
                                                            style="color:red">Supprimer</a>
                                                        <div wire:ignore.self class="modal modal-blur fade"
                                                            data-bs-backdrop="static"
                                                            id="modal-small-{{ $faq->id }}" tabindex="-1"
                                                            role="dialog" aria-hidden="true">
                                                            <div class="modal-dialog modal-sm modal-dialog-centered"
                                                                role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-body">
                                                                        <div class="modal-title">Est-vous sûr?</div>
                                                                        <div>
                                                                            Voulez-vous vraiment supprimer
                                                                            : {{ $faq->question }}
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button"
                                                                            class="btn btn-link link-secondary me-auto"
                                                                            data-bs-dismiss="modal">Fermer</button>
                                                                        <button
                                                                            wire:click='deleteFaqs({{ $faq->id }})'
                                                                            class="btn btn-danger">Oui supprimer</button>
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
                    @else
                        <div class="card">
                            <div class="card-body">
                               Aucune question, réponse pour le moment
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>


    {{-- debut du modal pour modifier les données  --}}

    <div wire:ignore.self class="modal modal-blur fade" id="modal-edite" data-bs-backdrop="static" tabindex="-1"
        role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <form wire:submit.prevent='editeFaq({{ $this->faqsId }})' autocomplete="off">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Modifier </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                                        <div class="row">

                                            <div class="col-md-12 col-lg-12">
                                                <div class="form-group">
                                                    <label for="question_edite">Question </label>
                                                    <textarea type="text" wire:model='question_edite' id="question_edite"
                                                        class="form-control" style="width: 100% !important;height:200px !important;resize:none !important;"></textarea>
                                                    {!! $errors->first('question_edite', '<span style="color:red;font-weight:bold">:message</span>') !!}
                                                </div>
                                            </div>

                                            <div class="col-md-12 col-lg-12">
                                                <div class="form-group">
                                                    <label for="reponse_edite">Reponse </label>
                                                    <textarea type="text" wire:model='reponse_edite' id="reponse_edite"
                                                        class="form-control" style="width: 100% !important;height:200px !important;resize:none !important;"></textarea>
                                                    {!! $errors->first('reponse_edite', '<span style="color:red;font-weight:bold">:message</span>') !!}
                                                </div>
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
</div>

