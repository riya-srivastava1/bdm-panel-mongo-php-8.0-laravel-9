<?php

namespace App\Http\Controllers\TraitClass;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


trait NotificationTraitBusiness
{
    public  function pushIosNotification($device_token, $title, $body, $payload)
    {
        $url = "https://fcm.googleapis.com/fcm/send";
        $token = $device_token;
        $serverKey = 'AAAAB6BoOBE:APA91bGQQJfqOuj7CC8D0yc4yNhGkPZiIMP7TE485sLYFcKGwfpdKjaJ_VEHHqCalUz317AynwvoPc9dnZEVU9PRvO-H1vaGSqf1y7kAj2I_kSkkepX0zDOCYWtQ0F3dA2KwTIp4Cfuy';
        $notification = array('title' => $title, 'text' => $body, 'sound' => 'default', 'badge' => '1');
        $data = array(
            "to" => $token,
            "notification" => array(
                "title" => $title,
                "body" =>  $body,
                "sound" => "default"
            ),
            "mutable_content" => true,
            "data" => array("targetScreen" => "detail", 'notification' => $notification, 'payload' => $payload),
            "priority" => 10
        );
        $json = json_encode($data);
        $headers = array();
        $headers[] = 'Content-Type: application/json';
        $headers[] = 'Authorization: key=' . $serverKey;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        //Send the request
        $response = curl_exec($ch);
        // Close request
        if ($response === FALSE) {
            die('FCM Send Error: ' . curl_error($ch));
        }
        curl_close($ch);
        return $response;
    }


    public function notification($token, $title, $body, $payload = '')
    {
        $fcmUrl = 'https://fcm.googleapis.com/fcm/send';
        $notification = [
            'title' => $title,
            "body" => $body,
            'sound' => true,
        ];
        $extraNotificationData = ["message" => $notification, "payload" => $payload, 'push_type' => 'list'];
        $fcmNotification = [
            //'registration_ids' => $tokenList, //multple token array
            'to'        => $token, //single token
            'notification' => $notification,
            'data' => $extraNotificationData
        ];
        $headers = [
            'Authorization: key=AAAAB6BoOBE:APA91bGQQJfqOuj7CC8D0yc4yNhGkPZiIMP7TE485sLYFcKGwfpdKjaJ_VEHHqCalUz317AynwvoPc9dnZEVU9PRvO-H1vaGSqf1y7kAj2I_kSkkepX0zDOCYWtQ0F3dA2KwTIp4Cfuy',
            'Content-Type: application/json'
        ];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $fcmUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
        $response = curl_exec($ch);
        if ($response === FALSE) {
            die('FCM Send Error: ' . curl_error($ch));
        }
        curl_close($ch);
        return $response;
    }
}
