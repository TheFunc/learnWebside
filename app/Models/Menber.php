<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menber extends Model
{
    //
    protected $guarded = [];

    protected $casts = [
        'LoginTime' => 'datetime',
        'Permission' => 'integer',
        'Status' => 'integer',
    ];
}
