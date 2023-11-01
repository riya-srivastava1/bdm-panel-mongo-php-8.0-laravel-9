<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;

class UserBooking extends Eloquent
{
    use SoftDeletes;

    protected $dates = ['booking_date_dbf'];
    protected $fillable = [
        'order_id',
        'user_id',
        'vendor_id',
        'plateform',

        'transaction_id',
        'payment_mode',
        'payment_time',
        'getway_name',
        'bank_transaction_id',
        'check_sum_hash',
        'bank_name',
        'status', //payment Status
        'booking_status',
        'service_status',

        'is_canceled',
        'is_rescheduled',
        'canceled_reason',
        'canceled_by',

        'total_services',
        'services',
        'booking_date',
        'booking_date_dbf',
        'booking_time',

        'pay_with',
        'amount',
        'gst',
        'coupon_discount',
        'wallet_discount',
        'booking_charge',
        'save_amount',
        'net_amount',
        'additional_amount',
        'ip',
        'user_address_id',
        'wah_action_status',
        'type'
    ];
    /**
     * @var mixed
     */

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
    public function vendorProfile()
    {
        return $this->belongsTo(VendorProfile::class, 'vendor_id', 'vendor_id');
    }
    public function getUserBookingsDetails()
    {
        return $this->hasMany(UserBookingDetail::class, 'order_no', 'order_no');
    }

    public function business()
    {
        return $this->belongsTo(Business::class, 'vendor_id', 'vendor_id');
    }
    public function refund()
    {
        return $this->hasOne(RefundCancellation::class, 'order_id', 'order_id');
    }

    public function userPayment()
    {
        return $this->hasOne(UserPayment::class, 'order_id', 'order_id');
    }

    public function userAddress()
    {
        return $this->hasOne(UserAddress::class, '_id', 'user_address_id');
    }

    public function artist()
    {
        return $this->hasOne(WahArtist::class, '_id', 'wah_artist_id');
    }



    // public function getBookingDateAttribute($data)
    // {
    //     return strtotime($data);
    // }
}
