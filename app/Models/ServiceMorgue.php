<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServiceMorgue extends Model
{
    protected $guarded = [];
    public function morgue(): BelongsTo
    {
        return $this->belongsTo(Morgue::class);
    }


}
