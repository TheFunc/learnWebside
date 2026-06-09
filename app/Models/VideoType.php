<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class VideoType extends Model
{
    protected $guarded = [];

    public function videos(): HasMany
    {
        return $this->hasMany(VideoInfo::class, 'TypeID', 'TypeID');
    }
}
