<?php

namespace App\Http\Controllers;
use Exception;
use App\Models\User;
use App\Models\WahArtist;
use App\Models\UserBooking;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Models\WahUserComment;
use App\Models\WahReviewOfUser;
use App\Models\WahArtistComment;
use App\Models\WahPreBookingImage;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\TraitClass\SMSTrait;
use App\Http\Controllers\TraitClass\ArtistLogTrait;

class ArtistController extends Controller
{

    use SMSTrait;
    use ArtistLogTrait;
    use NotificationTraitUser;

    public function showAllArtistInMap()
    {
        $artists = WahArtist::where('status', true)->get();
        $mapData = [];
        $i = 1;
        foreach ($artists as $item) {
            $lat = doubleval($item->coordinates['coordinates'][1] ?? 0);
            $lng = doubleval($item->coordinates['coordinates'][0] ?? 0);
            $name = $item->name;
            $mapData = Arr::prepend($mapData, [
                $name, $lat, $lng, $i
            ]);
            $i++;
        }
        $mapData = array_reverse($mapData);
        // dd( $mapData );
        // return $mapData;
        return view('wah.show-all-artist-in-map', compact(['mapData', 'artists']));
    }

    public function index()
    {
        $bookings = UserBooking::where('type', 'wah')
            ->where('status', '!=', 'pending')
            ->where('status', '!=', 'failed')
            ->whereIn('booking_date', [date('d-m-Y'), date('d-m-Y', strtotime(now()->addDay(1)))])
            ->get();
        $data =  collect($bookings);
        $compleated  = $data->where('wah_action_status', 'completed')->count();
        $rescheduled = $data->where('is_rescheduled', true)->count();
        $canceled    = $data->where('is_canceled', true)->count();
        $pending    = $data->where('service_status', false)->where('is_canceled', false)->count();
        $pending_payments =  UserBooking::where('type', 'wah')
            ->where('status', '!=', 'complete')
            ->whereIn('booking_date', [date('d-m-Y'), date('d-m-Y', strtotime(now()->addDay(1)))])
            ->paginate(20);

        return view('wah.index', compact(
            [
                'bookings',
                'compleated',
                'rescheduled',
                'canceled',
                'pending',
                'pending_payments'
            ]
        ));
    }
    public function index1()
    {
        // return "ok";
        $bookings = UserBooking::where('type', 'wah')
            ->where('status', '!=', 'pending')
            ->where('status', '!=', 'failed')
            ->whereIn('booking_date', [date('d-m-Y'), date('d-m-Y', strtotime(now()->addDay(1)))])
            ->get();
        $data =  collect($bookings);
        $compleated  = $data->where('wah_action_status', 'completed')->count();
        $rescheduled = $data->where('is_rescheduled', true)->count();
        $canceled    = $data->where('is_canceled', true)->count();
        $pending    = $data->where('service_status', false)->where('is_canceled', false)->count();
        $pending_payments =  UserBooking::where('type', 'wah')
            ->where('status', '!=', 'complete')
            ->whereIn('booking_date', [date('d-m-Y'), date('d-m-Y', strtotime(now()->addDay(1)))])
            ->paginate(20);

        return view('wah.index', compact(
            [
                'bookings',
                'compleated',
                'rescheduled',
                'canceled',
                'pending',
                'pending_payments'
            ]
        ));
    }

    public function bookings(Request $request)
    {
        // $request['page'] = '2';
        // return UserBooking::where('type', 'wah')->where('status', '!=' ,'pending')->where('booking_date', '=',  '02-04-2023')->paginate();
        // -----------------

        $bookings = (new UserBooking())->newQuery();
        $bookings->where('type', 'wah')
            ->where('status', '=', 'complete');
        // ->where('booking_date', '!=', date('d-m-Y'))
        if (!empty($request->wah_artist_id)) {
            $bookings->where('wah_artist_id', $request->wah_artist_id);
        }
        $bookings = $bookings->orderByDesc('booking_date_dbf')
            ->paginate(50);
        if ($request->ajax()) {
            // $bookings = UserBooking::where('type', 'wah')
            //     ->where('status', '!=', 'pending')
            //     ->where('booking_date', '!=', date('d-m-Y'))
            //     ->orderByDesc('booking_date_dbf')
            //     ->paginate(20);
            return view('wah.wah-filter', compact(['bookings']));
        }
        return view('wah.user-bookings', compact(['bookings']));
    }

    public function bookingAction($order_id)
    {
        $userCommentToZoylee = WahUserComment::where('order_id', $order_id)->first();
        $userCommentToArtist = WahArtistComment::where('order_id', $order_id)->first();
        $artistCommentToCustomer = WahReviewOfUser::where('order_id', $order_id)->first();
        $booking = UserBooking::where('order_id', $order_id)->first();

        return view('wah.booking-action', compact([
            'booking',
            'userCommentToZoylee',
            'userCommentToArtist',
            'artistCommentToCustomer'
        ]));
    }

    public function preBookingImage($order_id)
    {
        $image = WahPreBookingImage::where('order_id', $order_id)->first();
        if (!$image) {
            return back();
        }
        return view('wah.pre-booking-image', compact('image'));
    }

    private function getDate()
    {
        $currentDate = date('d-m-Y');
        $endDate = date('d-m-Y', strtotime($currentDate . ' + 7 days'));
        $start = strtotime($currentDate);
        $end = strtotime($endDate);
        $sendResponseData = [];
        while ($start <= $end) {
            $dateValue = date('d-m-Y', $start);
            $dateLabel = date('d-M', $start);
            $dayLabel = date('D', $start);

            $parentTimesArray = [
                'date_status' => true,
                'date' => $dateLabel,
                'date_value' => $dateValue,
                'day' => $dayLabel
            ];
            $sendResponseData = Arr::prepend($sendResponseData, $parentTimesArray);
            $currentDate = date('d-m-Y', strtotime($currentDate . ' + 1 days'));
            $start = strtotime($currentDate);
        }
        // return response()->json(['status' => true, "data" => array_reverse($sendResponseData)], 200);
        return array_reverse($sendResponseData);
    }


    private function time($request)
    {
        $start = 9;
        if ($request->date == date('d-m-Y')) {
            $start = date('H') < 9 ? 12 : date('H');
            if (date('i') > 21) {
                $start++;
            }
        } elseif (strtotime($request->date) < strtotime(date('d-m-Y'))) {
            return response()->json(['status' => false, 'message' => 'Invalid date!']);
        }


        $arr = [];
        while ($start <=   20) {
            $arr = Arr::prepend($arr, [
                'time_24' => date('H:i', strtotime(strval($start . ":00"))),
                'time' => date('h:i A', strtotime(strval($start . ":00"))),
                'status' => true,
            ]);
            $arr = Arr::prepend($arr, [
                'time_24' => date('H:i', strtotime(strval($start . ":30"))),
                'time' => date('h:i A', strtotime(strval($start . ":30"))),
                'status' => true,
            ]);
            $start++;
        }
        return array_reverse($arr);

        if (count($arr)) {
            return response()->json([
                'status' => true,
                'message' => 'Date loaded successfully',
                'date' => array_reverse($arr)
            ]);
        }
        return response()->json([
            'status' => false,
            'message' => 'Sorry. We are done for the day. Kindly book your appointment for the next day.',
            'date' => array_reverse($arr)
        ]);
    }
    public function rescheduleBooking(Request $request, $id)
    {
        $item = UserBooking::findOrFail($id);
        $date = $this->getDate();
        if (empty($request->date)) {
            $request['date'] = date('d-m-Y');
        }
        $time =  $this->time($request);
        return view('wah.user-bookings-reschedule', compact(['item', 'date', 'time']));
    }

    public function updateRescheduleBooking(Request $request)
    {
        $userBooking = UserBooking::findOrFail($request->booking_id);
        // if ($userBooking->is_rescheduled) {
        //     return back()->with('error', 'Booking already Rescheduled.');
        // }
        $userBooking->booking_date      = $request->date;
        $userBooking->booking_date_dbf  = date('Y-m-d', strtotime($request->date));
        $userBooking->booking_time      = $request->time;
        $userBooking->is_rescheduled      = true;
        $userBooking->save();

        $user_name = $userBooking->user->name ?? '';
        $user_phone = $userBooking->user->phone ?? false;
        $device_token = $userBooking->user->device_token ?? false;
        try {
            if ($user_phone) {
                $sms = "Hi $user_name,\r\nYour appointment has been rescheduled to $request->date and $request->time\r\nWe appreciate your cooperation.\r\n\r\nTeam Zoylee\r\n\r\n";
                $this->sendSimpleMsg($user_phone, $sms, '1007417259800391425');

                $this->notificationUser($device_token, 'Booking Reschedule', $sms, '', '', []);
            }

            // Log
            $title = 'Booking Reschedule';
            $name = Auth::guard('bdm')->user()->name;
            $description = "Booking Reschedule by $name | $userBooking->order_id";
            $this->UpdateArtistLog($userBooking->wah_artist_id, $title, $description, 'blue');
            // End Log
        } catch (Exception $ex) {
            report($ex);
        }
        return back()->with('success', 'Successfully Updated');
    }


    public function userDetails($user_id)
    {
        $user = User::where('user_id', $user_id)->first();
        return view('wah.user-details', compact(['user']));
    }

    // WAH Booking Filter
    public function wahBookingFilter(Request $request)
    {
        // return $request;
        // pendding
        $userBooking = (new UserBooking)->newQuery();
        if ($request->type == 'booking-status') {
            if ($request->val == 'complete') {
                $userBooking->where('service_status', true);
            } else if ($request->val == 'cancelled') {
                $userBooking->where('is_canceled', true);
            } else if ($request->val == 'pending') {
                $userBooking->where('is_canceled', false);
                $userBooking->where('service_status', false);
            }
        } else if ($request->type == 'gender') {
             $userBooking->where('gender',  ucfirst($request->val));
        } else if ($request->type == 'order_id') {
            $userBooking->where('order_id', 'like', '%' . ucfirst($request->val) . '%');
        } else if ($request->type == 'artist-status') {
            $userBooking->where('wah_action_status', $request->val);
        } else if ($request->type == 'date') {
            $userBooking->where('booking_date', '=',  date('d-m-Y', strtotime($request->val)));
        } else if ($request->type == 'user') {
            $user_name = $request->val;
            $userBooking->whereHas('user', function ($query) use ($user_name) {
                $query->where('name', 'LIKE', '%' . $user_name . '%');
            });
        } else if ($request->type == 'artist') {
            $artist_name = $request->val;
            $userBooking->whereHas('artist', function ($query) use ($artist_name) {
                $query->where('name', 'LIKE', '%' . $artist_name . '%');
            });
        } else if ($request->type == 'price-range') {
            $price = explode('-', $request->val);
            $userBooking->whereBetween('net_amount', [(int)$price[0], (int)$price[1]]);
            // net_amount
        } else if ($request->type == 'booking-date') {
            $userBooking->orderBy('booking_date', $request->val);
        }

        if (!empty($request->wah_artist_id)) {
            $userBooking->where('wah_artist_id', $request->wah_artist_id);
        }


        $userBooking->where('status', '!=', 'pending')->where('status', '!=', 'failed');
        $userBooking->where('type', 'wah');
        // $userBooking->where('booking_date', '!=', date(''));
        if ($request->type == 'price-range') {
            $bookings = $userBooking->orderBy('net_amount', 'asc')->paginate(50);
        } else {
            $bookings = $userBooking->orderByDesc('created_at')->paginate(5);
        }
        $view = view('wah.wah-filter', compact(['bookings']))->render();
        return response()->json(['html' => $view]);
        // $bookings = $userBooking->orderByDesc('created_at')->paginate(10)->withPath('/wah/user/booking');
       // return view('wah.wah-filter', compact(['bookings']));
    }
}
