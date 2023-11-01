<?php

namespace App\Http\Controllers;

use App\Models\UserBooking;
use Illuminate\Http\Request;

class UserBookingController extends Controller
{
    public function index()
    {
        $bookings = UserBooking::where('type', 'wah')
            ->where('status', '!=', 'pending')
            ->where('status', '!=', 'failed')
            ->whereIn('booking_date', [now()->format('d-m-Y'), now()->addDay()->format('d-m-Y')])
            ->get();

        $compleated  = $bookings->where('wah_action_status', 'completed')->count();
        $rescheduled = $bookings->where('is_rescheduled', true)->count();
        $canceled    = $bookings->where('is_canceled', true)->count();
        $pending     = $bookings->where('service_status', false)->where('is_canceled', false)->count();
        $pending_payments = UserBooking::where('type', 'wah')
            ->where('status', '!=', 'complete')
            ->whereIn('booking_date', [now()->format('d-m-Y'), now()->addDay()->format('d-m-Y')])
            ->paginate(20);

        return view('wah.userBooking.index', compact('bookings', 'compleated', 'rescheduled', 'canceled', 'pending', 'pending_payments'));
    }
}
