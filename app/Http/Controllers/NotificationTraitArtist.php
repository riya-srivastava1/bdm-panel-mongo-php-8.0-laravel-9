<?php

namespace App\Http\Controllers;

trait NotificationTraitArtist
{

    public function notificationArtist($token, $title, $body, $action = '', $ref = '', $payload = '')
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
            // 'registration_ids' => $token, // multple token array
            "to"        => $token, //single token
            "notification" => [
                "title" => $title,
                "message" => $body,
                "body" => $body,
                'action' => $action,
                'ref' => $ref,
                'payload'      => $payload
            ],
            "data" => [
                "title" => $title,
                "message" => $body,
                "body" => $body,
                'action' => $action,
                'ref' => $ref,
                'payload'      => $payload
            ]
        ];
        $headers = [
            "Authorization: key=AAAAT6Z--aA:APA91bHbEnvo8lbjlB6-_7fMbinDlY20NqvZQFmQ3sRqijrF52DrCgmLhI2ROWaZvfzbUQCX2hQ0tFyyt_SCj5rVhjEKMFxk_Gq1SrlwYEhxz6HXkVA5otZPLTKYWF6654GCmCGtUSpE",
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
