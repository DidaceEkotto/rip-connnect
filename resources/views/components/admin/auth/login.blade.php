<?php
// resources/views/components/admin/auth/⚡login.blade.php

use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Validate;
use Livewire\Component;

// ⚠️  Pas de #[Layout] ni #[Title] ici — le composant est EMBARQUÉ dans ta vue Blade existante
new class extends Component
{
    #[Validate('required|email|max:255')]
    public string $email = '';

    #[Validate('required|string|min:6')]
    public string $password = '';

    public bool $remember = false;

    public function login(): void
    {
        $this->validate();

        $throttleKey = 'admin|' . Str::lower($this->email) . '|' . request()->ip();

        if (RateLimiter::tooManyAttempts($throttleKey, 3)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            throw ValidationException::withMessages([
                'email' => "Trop de tentatives. Réessayez dans {$seconds} secondes.",
            ]);
        }

        $admin = Admin::where('email', $this->email)->withoutTrashed()->first();

        if ($admin?->isLocked()) {
            throw ValidationException::withMessages([
                'email' => 'Compte administrateur temporairement verrouillé. Réessayez dans quelques minutes.',
            ]);
        }

        if (! Auth::guard('admin')->attempt(
            ['email' => $this->email, 'password' => $this->password],
            $this->remember
        )) {
            RateLimiter::hit($throttleKey, 60);
            $admin?->incrementFailedAttempts();
            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        RateLimiter::clear($throttleKey);
        Auth::guard('admin')->user()->resetLoginAttempts(request()->ip());

        session()->regenerate();

        $this->redirect(route('admin.dashboard'), navigate: false);
    }
};
?>

{{-- Alpine gère uniquement le toggle show/hide — aucun aller-retour serveur --}}
<div x-data="{ showPassword: false }">

    {{-- Alerte erreur session (ex: compte désactivé) --}}
    @if (session('error'))
        <div class="alert alert-danger d-flex align-items-center gap-2 mb-3" role="alert">
            <i class="bi bi-exclamation-triangle-fill flex-shrink-0"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <form wire:submit="login" novalidate autocomplete="off">

        {{-- Email --}}
        <div class="mb-3">
            <div class="input-group">
                <span class="input-group-text">
                    <i class="bi bi-envelope"></i>
                </span>
                <input
                    wire:model="email"
                    type="email"
                    id="email"
                    class="form-control @error('email') is-invalid @enderror"
                    placeholder="Adresse email"
                    autocomplete="email"
                    autofocus
                >
                {{-- invalid-feedback doit être frère direct de l'input dans input-group --}}
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        {{-- Mot de passe avec toggle show/hide --}}
        <div class="mb-3">
            <div class="input-group">
                <span class="input-group-text">
                    <i class="bi bi-lock"></i>
                </span>

                {{-- ✅ wire:model sur le champ password + :type Alpine pour le toggle --}}
                <input
                    wire:model="password"
                    :type="showPassword ? 'text' : 'password'"
                    id="password"
                    class="form-control @error('password') is-invalid @enderror"
                    placeholder="Mot de passe"
                    autocomplete="current-password"
                >

                {{-- Bouton toggle — type="button" obligatoire pour ne pas soumettre le form --}}
                <button
                    type="button"
                    class="btn btn-outline-secondary"
                    @click="showPassword = !showPassword"
                    :aria-label="showPassword ? 'Masquer le mot de passe' : 'Afficher le mot de passe'"
                    :title="showPassword ? 'Masquer' : 'Afficher'"
                    tabindex="-1"
                >
                    {{-- Œil ouvert : mot de passe masqué → cliquer pour afficher --}}
                    <i x-show="!showPassword" class="bi bi-eye"></i>
                    {{-- Œil barré : mot de passe visible → cliquer pour masquer --}}
                    <i x-show="showPassword" class="bi bi-eye-slash"></i>
                </button>

                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        {{-- Ligne : Se souvenir + Bouton connexion --}}
        <div class="row align-items-center mt-4">
            <div class="col-5">
                <div class="form-check">
                    <input
                        wire:model="remember"
                        class="form-check-input"
                        type="checkbox"
                        id="remember"
                    >
                    <label class="form-check-label" for="remember">
                        Rester connecté
                    </label>
                </div>
            </div>

            <div class="col-7">
                <div class="d-grid">
                    <button
                        type="submit"
                        class="btn btn-primary"
                        wire:loading.attr="disabled"
                    >
                        {{-- État chargement --}}
                        <span wire:loading wire:target="login">
                            <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
                            Connexion en cours...
                        </span>

                        {{-- État par défaut --}}
                        <span wire:loading.remove wire:target="login">
                            <i class="bi bi-box-arrow-in-right me-1"></i>
                            Connexion
                        </span>
                    </button>
                </div>
            </div>
        </div>

    </form>
</div>
