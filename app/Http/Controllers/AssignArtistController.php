<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\UserBooking;
use App\Models\WahArtist;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\AssignArtistResource;
use App\Http\Controllers\TraitClass\SMSTrait;
use App\Http\Controllers\TraitClass\ArtistLogTrait;

class AssignArtistController extends Controller
{
    use NotificationTraitArtist;
    use NotificationTraitUser;
    use SMSTrait;
    use ArtistLogTrait;
    public function __construct()
    {
        ini_set('max_execution_time', 0);
    }
    private function getArtists($booking)
    {

        $u_lat = $booking->address['lat'];
        $u_lng = $booking->address['lng'];

        // $u_lat = $booking->userAddress->coordinates['coordinates'][1];
        // $u_lng = $booking->userAddress->coordinates['coordinates'][0];

        // doubleval($booking->address['lng']), // longitude
        //                 doubleval($u_lat), // latitude
        // where('status', true)
        //     ->where('is_booking_accepted', true)
        //     ->



        // ... (previous code)

        $artists = WahArtist::where('gender', $booking->gender)
            ->whereNotNull('device_token')
            ->where('coordinates', 'near', [
                '$geometry' => [
                    'type' => 'Point',
                    'coordinates' => [
                        doubleval($u_lng), // longitude
                        doubleval($u_lat), // latitude
                    ],
                ],
                '$maxDistance' => 50000,
            ])->get();

        // Assuming you have some logic to transform the $artists collection here

        $artistsCollection = collect(AssignArtistResource::collection($artists));

        $grouped = $artistsCollection->groupBy('active_status_label');

        return $grouped->toArray();




        // $artists =  WahArtist::where('gender',  $booking->gender)
        //     ->whereNotNull('device_token')
        //     ->where('coordinates', 'near', [
        //         '$geometry' => [
        //             'type' => 'Point',
        //             'coordinates' => [
        //                 doubleval($u_lng), // longitude
        //                 doubleval($u_lat), // latitude
        //             ],
        //         ],
        //         '$maxDistance' => 50000,
        //     ])->get();

        // AssignArtistResource::$lat = $u_lat;
        // AssignArtistResource::$lng = $u_lng;
        // $artists =  collect(AssignArtistResource::collection($artists));
        // $grouped = $artists->groupBy('active_status_label');
        // return $grouped->toArray();
    }

    public function showArtist($order_id)
    {
        $booking = UserBooking::where('order_id', $order_id)->first();
        // if (!empty($booking->wah_artist_id)) {
        //     return redirect()->route('wah.dashboard')->with('success', 'Artist Alredy Assigned');
        // }

        $artists = $this->getArtists($booking);


        $mapData = [];
        $i = 1;

        foreach (collect($artists['active'] ?? []) as $item) {
            $name = $item['name'] . ' - ' . $item['distance'];
            $mapData = Arr::prepend($mapData, [
                $name, $item['a_lat'], $item['a_lng'], $i
            ]);
            $i++;
        }
        $mapData = array_reverse($mapData);
        return view('wah.show-artist-assign-data', compact(['artists', 'mapData', 'order_id', 'booking']));
    }

    public function cAAA($order_id)
    {
        $booking = UserBooking::where('order_id', $order_id)->first();
        if (empty($booking->wah_artist_id)) {
            $status = false;
            $message = "Artist Not Assigned";
        } else {
            $status = true;
            $message = "Artist Already Assigned";
        }
        return response()->json([
            'status' => $status,
            'message' => $message
        ]);
    }

    // Send Notification to artist for accept and reject booking
    public function sendNotification($order_id)
    {

        $booking = UserBooking::where('order_id', $order_id)->first();
        if (!empty($booking->wah_artist_id)) {
            return redirect()->route('wah.dashboard')->with('success', 'Artist Alredy Assigned');
        }

        $artists =  $this->getArtists($booking);
        if ($artists && count($artists)) {
            $title = "New Booking Request";
            $description = "You have new booking request.";
            $ref = 'today';
            $serviceData = collect($booking->services);
            foreach (collect($artists['active']) as $key => $artist) {
                // -----------
                $distance = $artist['distance'];
                // ---------------Update
                $data = [
                    'booking_id' => $booking->id,
                    'order_id' => $booking->order_id,
                    'services' => is_array($serviceData) ? '--' : $serviceData->pluck('name')->implode(','),
                    'price' => $booking->artist_price,
                    'time' => $booking->booking_time,
                    'address' => $booking->address['full_address'] ?? '',
                    'distance' => $distance,
                    'lat' => $artist['lat'],
                    'lng' => $artist['lng']
                ];
                // Uncommented
                $this->notificationArtist($artist['device_token'], $title, $description, 'my_booking', $ref, $data);
                // !!Uncommented
            }

            return back()->with('success', 'Successfully Sent');
        }
    }

    private function sendNotificationWhenAcceptBooking($userBooking, $user, $artist)
    {
        // Notify to user
        $date = date('D, M d', strtotime($userBooking->booking_date));
        if (!empty($user->device_token)) {
            $userPushMsg = "Your booking is confirmed. $artist->name will be at your doorstep at $date, $userBooking->booking_time. Have a Zoylee Experience.";
            $this->notificationUser(
                $user->device_token,
                "Artist assigned",
                $userPushMsg,
                'booking_details',
                $userBooking->order_id,
                [],
                'wah'
            );
        }
        $sms = "Hey $user->name,\r\nYour booking is confirmed. $artist->name will be at your doorstep at $userBooking->booking_time on $date.\r\n\r\nTeam Zoylee";

        $this->sendSimpleMsg($user->phone, $sms, '1007068033618968662');

        // Notify to artist
        if (!empty($artist->device_token)) {
            $artistPushMsg = "Thank you for confirming the booking request.";
            $this->notificationArtist(
                $artist->device_token,
                'Booking Accepted',
                $artistPushMsg,
                'no-action',
                []
            );
        }
        $bdt = $userBooking->booking_date . ', ' . $userBooking->booking_time;
        $artistSms = "Hello $artist->name,\r\nYou have accepted the booking request from $user->name for $bdt.\r\nTeam Zoylee";
        $this->sendSimpleMsg($artist->phone, $artistSms, '1007612666674624794');
    }


    public function assignCustomArtist($order_id, $wah_artist_id)
    {
        $artist = WahArtist::findOrFail($wah_artist_id);
        $booking  = UserBooking::where('order_id', $order_id)->first();
        $assign_label = empty($booking->wah_artist_id) ? 'Assign' : 'Re-assign';
        // Log
        $title = "Artist $assign_label";
        $name = Auth::guard('bdm')->user()->name;
        $description = "Artist $assign_label by $name | $artist->name  | $booking->order_id";
        $this->UpdateArtistLog($booking->wah_artist_id, $title, $description, 'blue');
        // End Log
        if (empty($booking->wah_artist_id) || true) {
            $booking->wah_artist_id = $wah_artist_id;
            $booking->assigned_platform = 'bdm';
            $booking->assigned_by = Auth::guard('bdm')->user()->email ?? '';
            $booking->save();
            try {
                $this->sendNotificationWhenAcceptBooking($booking, $booking->user, $artist);
            } catch (Exception $ex) {
                report($ex);
            }
            return redirect()->route('wah.dashboard')->with('success', 'Artist Assigned');
        }
        return redirect()->route('wah.dashboard')->with('success', 'Artist Already Assigned');
    }
}
