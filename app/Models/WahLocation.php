<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class WahLocation extends Model
{
    protected $fillable = [
        'city',
        'zipcode',
        'map_place_id',
        'address',
        'lat',
        'lng',
        'coordinates'
    ];
}
