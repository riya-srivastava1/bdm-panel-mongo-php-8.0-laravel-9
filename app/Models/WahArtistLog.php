<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;
// use Illuminate\Database\Eloquent\Model;

class WahArtistLog extends Model
{
    use HasFactory;
    protected $fillable = [
        'wah_artist_id',
        'title',
        'description',
        'color_code'
    ];
}
