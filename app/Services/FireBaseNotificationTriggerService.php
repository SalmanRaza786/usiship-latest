<?php

namespace App\Services;

use App\Http\Helpers\Helper;
use App\Models\Admin;
use App\Models\User;
use App\Repositries\notification\NotificationRepositry;
use GuzzleHttp\Client;

class FireBaseNotificationTriggerService
{
public function fireBaseTrigger($type,$notifiableId)
{

    $notification=new NotificationRepositry();

    if($type==1){
        $notifyQuery= Helper::fetchOnlyData($notification->getUnreadNotifications($type,$notifiableId));
        $deviceId=Admin::where('id',$notifiableId)->pluck('device_id')->first();
    }

    if($type==2){
        $notifyQuery= Helper::fetchOnlyData($notification->getUnreadNotifications($type,$notifiableId));
        $deviceId=User::where('id',$notifiableId)->pluck('device_id')->first();
    }

    $notifyContent= $notifyQuery->first();

    $client = new Client();
    $headers = [
        'Content-Type' => 'application/json',
        'Authorization' => 'Bearer '.env('FIRE_BASE_ACCESS_TOKEN'),
    ];

    $body = [
        'message' => [
            'token' =>$deviceId,
            'notification' => [
                'body' =>$notifyContent['content'],
                'title' =>$notifyContent['content'],
            ],

            'data' => [
                'id' =>(string) $notifyContent['id'],
                'content' =>(string) $notifyContent['content'],
                'created_at' =>(string) $notifyContent['created_at'],
                'notifiType' =>(string) $notifyContent['notifiType'],
                'notifiableId' =>(string) $notifyContent['notifiableId'],
                'target_model_id' =>(string) $notifyContent['target_model_id'],
                'url' =>(string) $notifyContent['url'],
            ],
        ],
    ];

    $response = $client->post('https://fcm.googleapis.com/v1/projects/usi-ship/messages:send', [
        'headers' => $headers,
        'json' => $body,
    ]);

    echo $response->getBody();
}
}
