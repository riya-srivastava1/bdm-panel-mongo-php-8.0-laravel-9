<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserPayment;
use App\Models\CouponHistory;
use App\Models\WalletHistory;
use App\Models\UserBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Paytm\PaytmChecksum;

class PaymentController extends Controller
{

    public function index(Request $request)
    {
        $order_id = $request->id ?? '';
        return view('paytm.index', compact('order_id'));
    }
    public function checkpaymentStatus(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'order_id' => 'required|max:255',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'data' => $validator->messages(),
            ]);
        }

        $order_id  = $request->order_id;
        $paytm_merchant_key          = 'Pd6#E%n7wYFH3yXr';

        /**
         * import checksum generation utility
         * You can get this utility from https://developer.paytm.com/docs/checksum/
         */
        /* initialize an array */
        $paytmParams = array();

        /* body parameters */
        $paytmParams["body"] = array(

            /* Find your MID in your Paytm Dashboard at https://dashboard.paytm.com/next/apikeys */
            "mid" => "STjkXC18094287248734",

            /* Enter your order id which needs to be check status for */
            "orderId" => $order_id,
        );

        /**
         * Generate checksum by parameters we have in body
         * Find your Merchant Key in your Paytm Dashboard at https://dashboard.paytm.com/next/apikeys
         */
        $checksum = PaytmChecksum::generateSignature(json_encode($paytmParams["body"], JSON_UNESCAPED_SLASHES), $paytm_merchant_key);

        /* head parameters */
        $paytmParams["head"] = array(

            /* put generated checksum value here */
            "signature"    => $checksum
        );

        /* prepare JSON string for request */
        $post_data = json_encode($paytmParams, JSON_UNESCAPED_SLASHES);

        /* for Staging */
        // $url = "https://securegw-stage.paytm.in/v3/order/status";
        $url = "https://securegw.paytm.in/v3/order/status";

        /* for Production */
        // $url = "https://securegw.paytm.in/v3/order/status";

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        $response = json_decode('[' . curl_exec($ch) . ']');

        $data = $response[0]->body;
        $userPayment = new UserPayment();
        $userPayment->order_id              = $order_id ?? null;
        $userPayment->amount                = $data->txnAmount ?? null;
        $userPayment->transaction_id        = $data->txnId ?? null;
        $userPayment->payment_mode          = $data->paymentMode ?? '' ?? null;
        $userPayment->payment_time          = $data->txnDate ?? null;
        $userPayment->getway_name           = $data->gatewayName ?? null;
        $userPayment->bank_transaction_id   = $data->bankTxnId ?? null;
        $userPayment->bank_name             = $data->bankName ?? null;
        $userPayment->check_sum_hash        = $checksum ?? null;
        $userPayment->status                = $data->resultInfo->resultStatus ?? null;
        $userPayment->status_code           = $data->resultInfo->resultCode ?? null;
        $userPayment->status_message        = $data->resultInfo->resultMsg ?? null;
        $userPayment->panel                 = 'BDM';
        $userPayment->updated_by            = Auth::guard('bdm')->user()->name ?? null;
        $userPayment->save();

        $txn_status = $data->resultInfo->resultStatus;
        $message = $data->resultInfo->resultMsg;
        $booking = UserBooking::where('order_id', $request->order_id)->first();
        if ($txn_status == 'TXN_SUCCESS') {
            $status = 'complete';
        } else if ($txn_status == 'TXN_FAILURE') {
            $status = 'failed';
            if ($booking) {
                if ($booking->status != 'failed') {
                    // If coupon is applied
                    if ($booking->coupon_history_id !== "0" && $booking->coupon_discount !== 0) {
                        $coupon_history = CouponHistory::where(
                            [
                                'order_id' =>   $request->order_id,
                            ]
                        )->first();
                        if ($coupon_history) {
                            $coupon_history->status = false;
                            $coupon_history->save();
                            $coupon_history->delete();
                        }
                    }
                    // !! If coupon is applied

                    // If Zoylee point is applied

                    if ($booking->wallet_history_id !== "0" || $booking->wallet_discount !== 0) {
                        $user = User::where('user_id', $booking->user_id)->first();
                        $user->wallet_amount = $user->wallet_amount + $booking->wallet_discount;
                        $user->save();
                    }
                }
                // !! If Zoylee point is applied
            }
        } else if ($txn_status == 'PENDING') {
            $status = 'pending';
        }
        if ($booking) {
            UserBooking::where('order_id', $request->order_id)
                ->update(
                    [
                        'status' => $status,
                        'payment_message' => $message
                    ]
                );
        }

        return response()->json([
            'status' => true,
            'data' => $response,
        ]);
    }

    public function updatePaymentStatus(Request $request)
    {
        return $request;
    }
}
