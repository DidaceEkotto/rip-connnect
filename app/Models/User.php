<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

#[Fillable(['name', 'email', 'password', 'is_active','last_login_ip','last_login_at',])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable,HasRoles;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'last_login_at'     => 'datetime',
            'locked_until'      => 'datetime',
            'is_active'         => 'boolean',
        ];
    }

    /**
     * Vérifie si le compte est verrouillé (brute-force protection)
     */
    public function isLocked(): bool
    {
        return $this->locked_until && $this->locked_until->isFuture();
    }

    /**
     * Incrémente les tentatives échouées et verrouille si nécessaire
     */
    public function incrementFailedAttempts(): void
    {
        $this->increment('failed_login_attempts');

        if ($this->failed_login_attempts >= 5) {
            $this->update(['locked_until' => now()->addMinutes(15)]);
        }
    }

    /**
     * Réinitialise les tentatives après connexion réussie
     */
    public function resetLoginAttempts(string $ip): void
    {
        $this->update([
            'failed_login_attempts' => 0,
            'locked_until'          => null,
            'last_login_at'         => now(),
            'last_login_ip'         => $ip,
        ]);
    }
}
