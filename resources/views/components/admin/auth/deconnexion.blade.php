<?php

use Livewire\Component;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

new class extends Component
{
    public function logout(Request $request)
    {

        sleep(2);
        // Déconnecte UNIQUEMENT le guard admin — le guard web n'est pas affecté
        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')->with('success', 'Déconnexion administrateur réussie.');
    }
};
?>

<div>
    <!-- Modal -->
                <div class="modal fade" id="deconnexionAdmin" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Déconnexion</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Voulez-vous vraiment vous déconnectez ? </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                        <a href="javascript:void(0);"
                            wire:click='logout' class="btn btn-primary"
                            wire:loading.attr="disabled"
                        >
                            <span wire:loading wire:target="logout">
                                <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
                                Déconnexion en cours...
                            </span>

                            {{-- État par défaut --}}
                            <span wire:loading.remove wire:target="logout">
                                <i class="bi bi-door-closed"></i>
                                Déconnexion
                            </span>
                        </a>
                    </div>
                    </div>
                </div>
                </div>

</div>
