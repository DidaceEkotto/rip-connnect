<?php

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;

new class extends Component
{
    use WithFileUploads;

    public $page, $programme_obseque_pdf, $dece,$title;

    public function mount($page, $dece,$title)
    {
        $this->page = $page;
        $this->dece = $dece;
        $this->title = $title;
    }

    public function storePdf()
    {
        $this->validate([
            "programme_obseque_pdf" => "required|mimes:pdf,docx|max:7000"
        ]);

        // Génération nom
        $pdf_name = time() . '-' . Auth::guard('admin')->id() . '.' . $this->programme_obseque_pdf->extension();

        // Enregistrement du fichier
        $path = $this->programme_obseque_pdf->storeAs(
            'documents',
            $pdf_name,
            'public'
        );

        // Mise à jour DB
        $this->dece->update([
            "programme_obseque_pdf" => 'storage/' . $path
        ]);

        return redirect($this->page)->with("success", "Informations ajoutées avec succès.");
    }

};
?>

<div>
    <div class="mt-5">
        <div class="row">
            <div class="col-md-7 col-lg-7">
                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-3">Ajouter un programme obsèque (PDF)</h4>
                    </div>
                    <div class="card-body">
                        <form wire:submit.prevent="storePdf">

                            <div class="mb-3">
                                <label class="form-label">Programme obsèque (PDF ou DOCX)</label>
                                <input type="file" wire:model="programme_obseque_pdf" class="form-control"
                                    accept=".pdf,.docx">

                                @error('programme_obseque_pdf')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            @if ($dece->programme_obseque_pdf)
                                <p class="mt-2">
                                    <strong>Fichier actuel : </strong>
                                    <a href="{{ asset($dece->programme_obseque_pdf) }}" target="_blank"
                                        class="text-primary">
                                        Voir / Télécharger
                                    </a>
                                </p>
                            @endif

                            <button type="submit" class="btn btn-primary">
                                Enregistrer
                            </button>

                        </form>
                    </div>

                </div>
            </div>
        </div>



    </div>
</div>

