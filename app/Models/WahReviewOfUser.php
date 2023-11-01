<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class WahReviewOfUser extends Model
{

    protected $fillable = [
        'user_id',
        'order_id',
        'wah_artist_id',
        'rating',
        'comment',
        'status',
    ];
}
