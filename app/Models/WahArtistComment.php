<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class WahArtistComment extends Model
{
    // Comment to artist
    protected $fillable = [
        'wah_artist_id',
        'order_id',
        'user_id',
        'rating',
        'comment',
        'platform',
        'status',
    ];
}
