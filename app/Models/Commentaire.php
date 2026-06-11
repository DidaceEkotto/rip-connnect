<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Commentaire extends Model
{
    protected $guarded = [];

    protected $casts = [
        'note' => 'integer',
        'approuve' => 'boolean',
    ];

    public function morgue(): BelongsTo
    {
        return $this->belongsTo(Morgue::class);
    }
}
