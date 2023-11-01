<?php

namespace App\Http\Controllers\TraitClass;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

trait SMSTraitOLD
{
    public function sendSimpleMsg($phone, $sms)
    {
        $sms_user_id = config('app.SMS_USER_ID');
        $sms_password = config('app.SMS_PASSWORD');
        $sms_sender_id = config('app.SMS_SENDER_ID');
        $sms = urlencode($sms);
        $number = '91' . $phone;
        $apiKey = 3692639122615781989;
        $cTime = urlencode(now()->addMinutes(2));
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://www.smsgateway.center/SMSApi/rest/send",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "userId=${sms_user_id}&password=${sms_password}&senderId=${sms_sender_id}&sendMethod=simpleMsg&msgType=text&mobile=${number}&msg=${sms}&duplicateCheck=true&format=json",
            CURLOPT_HTTPHEADER => array(
                "apikey: ${apiKey}",
                "cache-control: no-cache",
                "content-type: application/x-www-form-urlencoded"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        if($err){
            \Log::error($err);
            return ['status'=>false,'msg'=>$err];
        }
        curl_close($curl);
        $response = json_decode($response, true);
        return ['status'=>false,'msg'=>$response];
    }

}
