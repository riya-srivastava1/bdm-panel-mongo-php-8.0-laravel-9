<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;


class WahServicePrice extends Eloquent
{
    protected $fillable = [
        'wah_sub_service_id',
        'location',
        'list_price',
        'zoylee_product_charge',
        'artist_price',
    ];
}
