<?php

use App\Models\UserBooking;
use Illuminate\Support\Facades\Config;

function cdn($url = null)
{
    $url = (string) $url;
    if (empty($url)) {
        throw new Exception('URL missing');
    }

    $pattern = '|^http[s]{0,1}://|i';
    if (preg_match($pattern, $url)) {
        throw new Exception(
            'Invalid URL. ' .
                'Use: /image.jpeg instead of full URI: ' .
                'https://www.zoylee.com/image.jpeg.'
        );
    }

    $pattern = '|^/|';
    if (!preg_match($pattern, $url)) {
        $url = '/' . $url;
    }

    if (!Config::get('app.cdn_enabled')) {
        return $url;
    } else {
        return Config::get('app.cdn_protocol') . '://' . Config::get('app.cdn_domain') . $url;
    }
}

function getPreArtistNameGF($booking)
{
    $getBooking = UserBooking::where('user_id', $booking->user_id)
        ->where('order_id', '!=', $booking->order_id)
        ->where('service_status', true)
        ->where('type', 'wah')
        ->orderByDesc('created_at')
        ->first();
    if ($getBooking) {
        return $getBooking->artist->name ?? 'N/A - ' . $getBooking->order_id;
    }
    return false;
}
