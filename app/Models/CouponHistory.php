<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\SoftDeletes;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class CouponHistory extends Eloquent
{
    use SoftDeletes;
    protected $fillable = [
        'user_id',
        'order_id',
        'promotion_code',
        'value',
        'status'
    ];
}
