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
        $user = NotificationTemplate::updateOrCreate(
            ['status_id' =>6],
            [
                'status_id' => 6,
                'mail_content' => 'Order Created Successfully',
                'sms_content' =>'Order Created Successfully',
                'notify_content'=>'Order Created Successfully',
                'created_at' => now(),
            ]);
        $user = NotificationTemplate::updateOrCreate(
            ['status_id' =>1],
            [
                'status_id' => 1,
                'mail_content' => 'Order Accepted Successfully',
                'sms_content' =>'Order Accepted Successfully',
                'notify_content'=>'Order Accepted Successfully',
                'created_at' => now(),
            ]);
    }
}
