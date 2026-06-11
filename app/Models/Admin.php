<?php
// app/Models/Admin.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes,HasRoles;

    /**
     * Le guard explicitement lié à ce model
     */
    protected string $guard = 'admin';

    protected $fillable = [
        'name',
        'email',
        'password',
        'is_active',
        'last_login_ip',
        'last_login_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'last_login_at'     => 'datetime',
            'locked_until'      => 'datetime',
            'password'          => 'hashed',
            'is_active'         => 'boolean',
        ];
    }

    public function isLocked(): bool
    {
        return $this->locked_until && $this->locked_until->isFuture();
    }

    public function incrementFailedAttempts(): void
    {
        $this->increment('failed_login_attempts');

        // Les admins sont verrouillés plus vite (3 tentatives)
        if ($this->failed_login_attempts >= 3) {
            $this->update(['locked_until' => now()->addMinutes(30)]);
        }
    }

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
