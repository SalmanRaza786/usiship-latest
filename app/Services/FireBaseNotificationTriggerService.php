<?php

namespace App\Services;

use App\Http\Helpers\Helper;
use App\Models\Admin;
use App\Models\DeviceToken;
use App\Models\User;
use App\Repositries\notification\NotificationRepositry;
use Google\Auth\Credentials\ServiceAccountCredentials;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class FireBaseNotificationTriggerService
{

    protected $credentials;

    public function __construct()
    {
        $keyFilePath = public_path('service/usi-ship-ef242408d0be.json');
        $scopes = ['https://www.googleapis.com/auth/firebase.messaging'];

        $this->credentials = new ServiceAccountCredentials($scopes, $keyFilePath);
    }

    public function getAccessToken()
    {
        try {
            $this->credentials->fetchAuthToken(); // Ensure the token is fetched
            $accessToken = $this->credentials->getLastReceivedToken();
            return $accessToken['access_token'];
        } catch (RequestException $e) {
            // Handle the exception
            throw new \Exception('Failed to obtain access token: ' . $e->getMessage());
        }
    }
public function fireBaseTrigger($type,$notifiableId)
{

    $notification=new NotificationRepositry();
    $accessToken=$this->getAccessToken();

    if($type==1){
        $notifyQuery= Helper::fetchOnlyData($notification->getUnreadNotifications($type,$notifiableId));
        //$deviceId=Admin::where('id',$notifiableId)->pluck('device_id')->first();
        $deviceToken=DeviceToken::where('auth_id',$notifiableId)->where('auth_type','App\Models\Admin')->get();
    }


    if($type==2){
        $notifyQuery= Helper::fetchOnlyData($notification->getUnreadNotifications($type,$notifiableId));
       // $deviceId=User::where('id',$notifiableId)->pluck('device_id')->first();
        $deviceToken=DeviceToken::where('auth_id',$notifiableId)->where('auth_type','App\Models\User')->get();
    }
    $notifyContent= $notifyQuery->first();



    $client = new Client();
    $headers = [
        'Content-Type' => 'application/json',
        'Authorization' => 'Bearer '.$accessToken,
    ];

    foreach($deviceToken as $row) {

    $body = [
        'message' => [
            'token' => $row->device_token,
            'notification' => [
                'body' => $notifyContent['content'],
                'title' => $notifyContent['content'],
            ],

            'data' => [
                'id' => (string)$notifyContent['id'],
                'content' => (string)$notifyContent['content'],
                'created_at' => (string)$notifyContent['created_at'],
                'notifiType' => (string)$notifyContent['notifiType'],
                'notifiableId' => (string)$notifyContent['notifiableId'],
                'target_model_id' => (string)$notifyContent['target_model_id'],
                'url' => (string)$notifyContent['url'],
            ],
        ],
    ];

    $response = $client->post('https://fcm.googleapis.com/v1/projects/usi-ship/messages:send', [
        'headers' => $headers,
        'json' => $body,
    ]);

    //echo $response->getBody();
    }
    }
}
