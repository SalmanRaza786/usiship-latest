<?php

namespace Database\Seeders;

use App\Models\LTDirection;
use App\Models\LTEquipmentType;
use App\Models\LTOperation;
use App\Models\LTTransportaionMode;
use App\Models\NotificationTemplate;
use App\Models\OrderStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Notifications\Notification;

class OrderNotificationContant extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $orderStatuses = [
            [
                'status_id' => 1,
                'mail_content' => 'Order accepted Successfully',
                'sms_content' =>'Order accepted Successfully',
                'notify_content'=>'Order accepted Successfully',
                'created_at' => now(),
            ],
            [
                'status_id' => 2,
                'mail_content' => 'Order rejected Successfully',
                'sms_content' =>'Order rejected Successfully',
                'notify_content'=>'Order rejected Successfully',
                'created_at' => now(),
            ],
            [
                'status_id' => 3,
                'mail_content' => 'Order Inprogress Successfully',
                'sms_content' =>'Order Inprogress Successfully',
                'notify_content'=>'Order Inprogress Successfully',
                'created_at' => now(),
            ],
            [
                'status_id' => 4,
                'mail_content' => 'Order delivered Successfully',
                'sms_content' =>'Order delivered Successfully',
                'notify_content'=>'Order delivered Successfully',
                'created_at' => now(),
            ],
            [
                'status_id' => 5,
                'mail_content' => 'Order arrived Successfully',
                'sms_content' =>'Order arrived Successfully',
                'notify_content'=>'Order arrived Successfully',
                'created_at' => now(),
            ],
            [
                'status_id' => 6,
                'mail_content' => 'Order Created Successfully',
                'sms_content' =>'Order Created Successfully',
                'notify_content'=>'Order Created Successfully',
                'created_at' => now(),
            ],
            [
                'status_id' => 7,
                'mail_content' => 'Order canceled Successfully',
                'sms_content' =>'Order canceled Successfully',
                'notify_content'=>'Order canceled Successfully',
                'created_at' => now(),
            ],
            [
                'status_id' => 8,
                'mail_content' => 'Order Packaging List Requested Successfully',
                'sms_content' =>'Order Packaging List Requested Successfully',
                'notify_content'=>'Order Packaging List Requested Successfully',
                'created_at' => now(),
            ],
            [
                'status_id' => 9,
                'mail_content' => 'Order Carrier Arrived Successfully',
                'sms_content' =>'Order Carrier Arrived Successfully',
                'notify_content'=>'Order Carrier Arrived Successfully',
                'created_at' => now(),
            ],
            [
                'status_id' => 10,
                'mail_content' => 'Order Completed Successfully',
                'sms_content' =>'Order Completed Successfully',
                'notify_content'=>'Order Completed Successfully',
                'created_at' => now(),
            ],
            [
                'status_id' => 11,
                'mail_content' => 'Order Package List Received Successfully',
                'sms_content' =>'Order Package List Received Successfully',
                'notify_content'=>'Order Package List Received Successfully',
                'created_at' => now(),
            ],
            [
                'status_id' => 12,
                'mail_content' => 'Order Check In  Successfully',
                'sms_content' =>'Order Check In Successfully',
                'notify_content'=>'Order Check In Successfully',
                'created_at' => now(),
            ],
            [
                'status_id' => 13,
                'mail_content' => 'Order Off Loading Successfully',
                'sms_content' =>'Order Off Loading Successfully',
                'notify_content'=>'Order Off Loading Successfully',
                'created_at' => now(),
            ],
            [
                'status_id' => 14,
                'mail_content' => 'Order Item Put Away Successfully',
                'sms_content' =>'Order Item Put Away Successfully',
                'notify_content'=>'Order Item Put Away Successfully',
                'created_at' => now(),
            ],
        ];
        foreach ($orderStatuses as $status){
            NotificationTemplate::updateOrCreate(
                ['status_id' =>$status['status_id']],
                [
                    'status_id' => $status['status_id'],
                    'mail_content' => $status['mail_content'],
                    'sms_content' => $status['sms_content'],
                    'notify_content' => $status['notify_content'],
                    'created_at' =>now(),
                ]);
        }
    }
}
