<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class WahArtistEquipment extends Eloquent
{
    protected $fillable = [
        'name',
    ];
}
