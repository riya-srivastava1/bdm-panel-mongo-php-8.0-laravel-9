<?php

namespace App\Http\Controllers\TraitClass;

trait SMSTrait
{
    public function sendSimpleMsg($phone, $sms, $dltTemplateId)
    {
        $sid = config('app.KALEYRA_SID');
        $apiKey = config('app.KALEYRA_API_KEY');
        $sender_id = config('app.KALEYRA_SENDER_ID');
        $sms = urlencode($sms);
        $number = '91' . $phone;

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.kaleyra.io/v1/${sid}/messages",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "type=TXN&to=${number}&sender=${sender_id}&template_id=${dltTemplateId}&body=${sms}",
            CURLOPT_HTTPHEADER => array(
                "api-key: ${apiKey}",
                "Content-Type: application/x-www-form-urlencoded"
            ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            \Log::info($err);
        }
        return $response;
    }
}
