<?php

namespace App\Http\Controllers;

use App\Http\Controllers\TraitClass\ArtistLogTrait;
use App\Http\Controllers\TraitClass\SMSTrait;
use App\Mail\BookingCompleteMail;
use App\User;
use App\UserBooking;
use App\UserPushNotification;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class WahBookingActionController extends Controller
{

    use NotificationTraitUser;
    use NotificationTraitArtist;
    use ArtistLogTrait;
    use SMSTrait;

    private function getBdmUserName()
    {
        return Auth::guard('bdm')->user()->name;
    }

    private function proceedAction($order_id)
    {
        $userBooking = UserBooking::where('order_id', $order_id)->first();
        $user = $userBooking->user;
        if ($userBooking && $userBooking->count()) {
            $userBooking->wah_action_status = 'proceed';
            $userBooking->save();
            $title = 'Yay! Artist is On The Way!';
            $body = "Yay! The artist is on his way and will reach your place at the scheduled time. Kindly bear with us. ";
            $this->notificationUser($user->device_token, $title, $body, 'home', $order_id, [], 'wah');

            // Log
            $title = 'Proceed Booking Action';
            $name = $this->getBdmUserName();
            $description = "<strong>BDT</strong> | Booking proceed by <strong>$name</strong> | <strong>$order_id</strong>";
            $this->UpdateArtistLog($userBooking->wah_artist_id, $title, $description, 'lightgreen');
            // End Log
        } else {
            return back()->with('info', 'Something went wrong');
        }
        return back()->with('success', 'Successfully Updated');
    }

    private function startAction($order_id)
    {
        $userBooking = UserBooking::where('order_id', $order_id)->first();
        $artist  = $userBooking->artist;
        if ($userBooking && $userBooking->count()) {
            $userBooking->wah_action_status = 'start';
            $userBooking->save();

            try {
                $title = 'Service Started';
                $body = "The service has started. We request you to mark the service completed after completion. ";
                $this->notificationArtist($artist->device_token, $title, $body, 'home', $order_id, [], 'wah');

                // Log
                $name = $this->getBdmUserName();
                $title = 'Service Started';
                $description = "<strong>BDT</strong> | Service started by <strong>$name</strong> | $order_id";
                $this->UpdateArtistLog($userBooking->wah_artist_id, $title, $description, 'lightgreen');
                // End Log
            } catch (Exception $ex) {
                report($ex);
            }
        }
        return back()->with('success', 'Successfully Updated');
    }

    private function reachedAction($order_id)
    {
        $userBooking = UserBooking::where('order_id', $order_id)->first();
        if ($userBooking && $userBooking->count()) {
            $userBooking->wah_action_status = 'reached';
            $userBooking->save();
            try {
                $user = $userBooking->user;
                $title = 'Artist Arrived';
                $body = " Yayy!!! Your Zoylee Artist has arrived at your doorstep.";
                $this->notificationUser(
                    $user->device_token,
                    $title,
                    $body,
                    'my_booking',
                    $order_id,
                    []
                );

                // Log
                $title = 'Reached Booking Action';
                $name = $this->getBdmUserName();
                $description = "<strong>BDT</strong> | Reached client location <strong>$name</strong> | $order_id";
                $this->UpdateArtistLog($userBooking->wah_artist_id, $title, $description, 'lightgreen');
                // End Log
            } catch (Exception $ex) {
                report($ex);
            }
        } else {
            return back()->with('info', 'Something went wrong');
        }
        return back()->with('success', 'Successfully Updated');
    }

    private function completeBookingAction($order_id)
    {
        $userBooking  = UserBooking::where('order_id', $order_id)->first();
        $artist = $userBooking;
        $user = $userBooking->user;
        $userBooking->service_status = true;
        $userBooking->wah_action_status = 'completed';
        $userBooking->save();

        // Artist notification
        $artistSms = "Hey $artist->name,\r\nThank you for successfully completing the booking. Good Job.\r\nTeam Zoylee";
        $this->sendSimpleMsg($artist->phone, $artistSms, '1007573200082791659');
        $this->notificationArtist($artist->device_token, 'Booking Completed', "Thank you for successfully completing the booking. Good Job.", 'my_booking', []);
        // delete prevoius android
        UserPushNotification::where('ref', $userBooking->id)->where('type', 'wah')->delete();
        // end artist notification

        $userUserNotification = new UserPushNotification();
        $title = "Booking Completed";
        $body = "Woohoo. You service is completed and we hope you enjoyed as much as we did.";
        $userUserNotification->user_id = $user->user_id;
        $userUserNotification->title = $title;
        $userUserNotification->description = $body;
        $userUserNotification->action = 'my_booking';
        $userUserNotification->ref = $userBooking->id;
        $userUserNotification->type = 'wah';
        $userUserNotification->payload = [];
        $userUserNotification->device_token = $user->device_token;
        $userUserNotification->save();

        if (!empty($user->device_token)) {
            $this->notificationUser($user->device_token, $title, $body, 'my_booking', $userBooking->id, [], 'wah');
        }
        $sms = "Woohoo, we hope you enjoyed the service. Thank you for choosing us for your grooming. Would like to serve you again soon.\r\n\r\nTeam Zoylee";
        $this->sendSimpleMsg($user->phone, $sms, '1007066798069823943');

        // CEO Mail
        $user_count =  UserBooking::where(['user_id' => $user->user_id, 'type' => 'wah', 'wah_action_status' => 'completed'])->count();
        if ($user_count == 1) {
            if ($user->email) {
                Mail::to($user->email)->send(new BookingCompleteMail($user->name, ''));
            }
        }


        // Log
        $title = 'Booking Completed';
        $name = $this->getBdmUserName();
        $description = "<strong>BDT</strong> | Booking Completed by <strong>$name</strong> | $userBooking->order_id";
        $this->UpdateArtistLog($userBooking->wah_artist_id, $title, $description, 'lightgreen');
        // End Log

        return back()->with('success', 'Successfully Updated');
    }


    public function updateArtistAction(Request $request, $order_id)
    {
        if ($request->artist_action == 'proceed') {
            return $this->proceedAction($order_id);
        } elseif ($request->artist_action == 'reached') {
            return $this->reachedAction($order_id);
        } elseif ($request->artist_action == 'start') {
            return $this->startAction($order_id);
        } elseif ($request->artist_action == 'complete') {
            return $this->completeBookingAction($order_id);
        } else {
            return back();
        }
    }

    public function cancelBooking($order_id)
    {
        $userBooking  = UserBooking::where('order_id', $order_id)->first();
        $user = $userBooking->user;
        $userBooking->is_canceled = true;
        $userBooking->service_status = false;
        $userBooking->canceled_by = $this->getBdmUserName();
        if ($userBooking->save()) {
            $user = User::where('user_id', $userBooking->user_id)->first();
            $user->wallet_amount = $user->wallet_amount + $userBooking->wallet_discount;
            $user->save();
        }

        $sms = "Sorry. Your appointment is cancelled as all artists are engaged at the moment. We have initiated your refund, which may take 5-7 Business Days to get reflected in your account.\r\nTeam Zoylee";
        $this->sendSimpleMsg($user->phone, $sms, '1007815786098844043');

        // delete prevoius android
        UserPushNotification::where('ref', $userBooking->id)->where('type', 'wah')->delete();
        // end artist notification

        $userUserNotification = new UserPushNotification();
        $title = "Booking Cancelled";
        $body = "Sorry. Your appointment is cancelled as all artists are engaged at the moment. We have initiated your refund, which may take 5-7 Business Days to get reflected in your account.\r\nTeam Zoylee";
        $userUserNotification->user_id = $user->user_id;
        $userUserNotification->title = $title;
        $userUserNotification->description = $body;
        $userUserNotification->action = 'my_booking';
        $userUserNotification->ref = $userBooking->id;
        $userUserNotification->type = 'wah';
        $userUserNotification->payload = [];
        $userUserNotification->device_token = $user->device_token;
        $userUserNotification->save();

        if (!empty($user->device_token)) {
            $this->notificationUser($user->device_token, $title, $body, 'my_booking', $userBooking->id, [], 'wah');
        }

        // Log
        $title = 'Booking Cancelled';
        $name = $this->getBdmUserName();
        $description = "<strong>BDT</strong> | Booking Cancelled by <strong>$name</strong> | $userBooking->order_id";
        $this->UpdateArtistLog($userBooking->wah_artist_id, $title, $description, 'orange');
        // End Log
        return back()->with('success', 'Successfully Updated');
    }

    public function updateBookingAction(Request $request, $order_id)
    {
        if ($request->booking_action == 'Complete') {
            return $this->completeBookingAction($order_id);
        } elseif ($request->booking_action == 'Cancel') {
            return $this->cancelBooking($order_id);
        } elseif ($request->booking_action == 'in_progress') {
            $userBooking  = UserBooking::where('order_id', $order_id)->first();
            $userBooking->service_status = false;
            $userBooking->is_canceled = false;
            $userBooking->wah_action_status = 'in_progress';
            $userBooking->save();
            return back()->with('success', 'Successfully Updated');
        } else {
            return back();
        }
    }
}
