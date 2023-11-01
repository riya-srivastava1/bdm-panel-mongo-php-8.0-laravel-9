<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class WahArtistWwuRequest extends Eloquent
{

    protected $fillable = [
        "name",
        "email",
        "phone",
        'is_registered'
    ];
}
