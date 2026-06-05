<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VideoInfo extends Model
{
    protected $guarded = [];

    public function cover()
    {
        return $this->belongsTo(VideoCover::class, 'GroupID', 'GroupID');
    }

    public function type()
    {
        return $this->belongsTo(VideoType::class, 'TypeID', 'TypeID');
    }
}
