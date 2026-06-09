<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VideoInfo extends Model
{
    protected $guarded = [];

    public function cover(): BelongsTo
    {
        return $this->belongsTo(VideoCover::class, 'GroupID', 'GroupID');
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(VideoType::class, 'TypeID', 'TypeID');
    }
}
