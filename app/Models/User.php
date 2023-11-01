<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;
use PDO;

class User extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $path = 'uploads/user/profile/';
    protected $fillable = [
        'user_id',
        'phone',
        'name',
        'email',
        'password',
        'device_token',
        'image',
        'device_type',
        'login_type',
        'social_id',
        'is_mobile_verified',
        'is_email_verified',
        'wallet_amount',
        'referred_by', //user_id
        'referral_code',
        'api_token',
        'default',

        'alternate_no',
        'birthday',
        'gender',
        'lat',
        'lng',
        'map_place_id',
        'city',
        'created_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'default',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_mobile_verified' => 'boolean',
        'is_email_verified' => 'boolean',
    ];

    public function userPushNotificationCount()
    {
        return $this->hasMany(UserPushNotification::class, 'user_id', 'user_id')
            ->whereNull('is_read');
    }

    public function AauthAcessToken()
    {
        return $this->hasMany('\App\OauthAccessToken');
    }

    public function referralAmount()
    {
        return $this->hasMany(Referral::class, 'user_id', 'user_id')->where('status', true)->sum('sender_reward_point');
    }

    public function cart()
    {
        return $this->hasMany(Cart::class, 'user_id', 'user_id');
    }


    public function getImageAttribute($file)
    {
        $image = false;
        if (preg_match("/https/i", $file)) {
            $image =  $file;
        } else if (strpos($file, '.') > 0) {
            $image = cdn('tr:h-100,w-100/' . $this->path . $file);
        } else {
            $image = cdn('assets/images/vendor-logo/' . strtoupper(substr(trim($this->name), 0, 1)) . '.png');
        }
        return $image;
    }
    public function getDeviceTokenAttribute()
    {
        return date('Y-m', strtotime($this->created_at));
    }

    public function wahBooking($order_id)
    {
        return $this->hasMany(UserBooking::class, 'user_id', 'user_id')
            ->where('type', 'wah')
            ->where('order_id', '!=', $order_id)
            ->where('service_status', true)
            ->orderByDesc('created_at');
    }

    public function booking()
    {
        return $this->hasMany(UserBooking::class, 'user_id', 'user_id')
            ->where('service_status', true)
            ->where('booking_status', true)
            ->orderByDesc('created_at');
    }

    public function address()
    {
        return $this->hasMany(UserAddress::class, 'user_id', 'user_id');
    }
}
