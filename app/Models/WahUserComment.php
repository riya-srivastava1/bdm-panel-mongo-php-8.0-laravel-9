<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class WahUserComment extends Model
{
    // User comment to artist
    protected $fillable = [
        'user_id',
        'order_id',
        'wah_artist_id',
        'rating',
        'comment',
        'platform',
        'status'
    ];
}
