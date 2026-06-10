<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExternalInfo extends Model
{
    protected $guarded = [];

    public function externalType(): BelongsTo
    {
        return $this->belongsTo(ExternalType::class, 'type', 'type');
    }
}
