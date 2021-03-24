<?php

return [
    'driver' => env('FCM_PROTOCOL', 'http'),
    'log_enabled' => false,

    'http' => [
        'server_key' => env('FCM_SERVER_KEY', 'AAAA2jXeQgI:APA91bHMzmeIqc5a7SG0vvd3i-G-PLVYMDvL1i-njURFMufQgpjP3AkHe945WZdLoabbAWCrXqmyoCKqIkJCVFaB6Lse3_-FzpbvCyGS34HXJvoHibLIKgQ0o4tJSo2a-q42SufVbF9f'),
        'sender_id' => env('FCM_SENDER_ID', '937206628866'),
        'server_send_url' => 'https://fcm.googleapis.com/fcm/send',
        'server_group_url' => 'https://android.googleapis.com/gcm/notification',
        'timeout' => 30.0, // in second
    ],
];
