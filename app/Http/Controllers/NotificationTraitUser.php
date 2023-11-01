<?php

namespace App\Http\Controllers;

trait NotificationTraitUser
{

    public function notificationUser($token, $title, $body, $action = '', $ref = '', $payload = '')
    {
        $fcmUrl = 'https://fcm.googleapis.com/fcm/send';
        $notification = [
            "title" => $title,
            "body" => $body,
            'action' => $action,
            'ref' => $ref
        ];
        $extraNotificationData = ["message" => $notification, "payload" => $payload];
        $fcmNotification = [
            //'registration_ids' => $token, //multple token array
            "to"        => $token, //single token
            "notification" => [
                "title" => $title,
                "message" => $body,
                "body" => $body,
                'action' => $action,
                'ref' => $ref
            ],
            "data" => [
                "title" => $title,
                "message" => $body,
                "body" => $body,
                'action' => $action,
                'ref' => $ref
            ]
        ];
        $headers = [
            "Authorization: key=AAAApgKSNEI:APA91bFZ1WpdpLv8N4ePfijC_fasYGxGwq9v3fGAc2FuI9sm0Z2ygwmR1iVDaKgSZPMBSCM36bL9wydmYxBx2Tdpcv_rz-ROH_-R4buVxZlzVj1t-lSHrotg5bbjASoVwcaW_NOmA7Dl",
            "Content-Type: application/json"
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
