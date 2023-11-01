<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model ;
class UserPayment extends Model
{
    protected $fillable = [
        'order_id',
        'amount',
        'transaction_id',
        'payment_mode',
        'payment_time',
        'getway_name',
        'bank_transaction_id',
        'bank_name',
        'check_sum_hash',
        'status',
        'panel',
        'updated_by'
    ];
}
