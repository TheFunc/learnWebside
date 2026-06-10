<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ExternalType extends Model
{
    protected $guarded = [];

    public function externals(): HasMany
    {
        return $this->hasMany(ExternalInfo::class, 'type', 'type');
    }
}
