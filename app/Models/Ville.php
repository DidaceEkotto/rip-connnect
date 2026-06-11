<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ville extends Model
{
    protected $guarded = [];

    public function morgues()
    {
        return $this->hasMany(Morgue::class);
    }
}
