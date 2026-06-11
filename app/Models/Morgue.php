<?php

namespace App\Models;

use App\Models\Commentaire;
use App\Models\GaleriePhoto;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Morgue extends Model
{
    protected $guarded = [];

    public function ville()
    {
        return $this->belongsTo(Ville::class);
    }

     public function commentaires(): HasMany
    {
        return $this->hasMany(Commentaire::class)->orderBy('created_at', 'desc');
    }

    public function services(): HasMany
    {
        return $this->hasMany(ServiceMorgue::class);
    }

    public function galerie(): HasMany
    {
        return $this->hasMany(GaleriePhoto::class);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
