<?php

namespace Database\Seeders;

use App\Models\LTDirection;
use App\Models\LTEquipmentType;
use App\Models\LTOperation;
use App\Models\LTTransportaionMode;
use App\Models\OrderStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $orderStatuses = [
            [
                'status_title' => 'Accepted',
                'class_name' => 'bg-soft-success',
                'order_by' => 11,
                'color_code' =>'#F06549',
                'text_class' =>'text-success',
            ],
            [
                'status_title' => 'Rejected',
                'class_name' => 'bg-soft-danger',
                'order_by' => 8,
                'color_code' =>'#F06549',
                'text_class' =>'text-danger',
            ],
            [
                'status_title' => 'In Progress',
                'class_name' => 'bg-soft-info',
                'order_by' => 14,
                'color_code' =>'#F06549',
                'text_class' =>'text-info',
            ],
            [
                'status_title' => 'Delivered',
                'class_name' => 'bg-soft-dark',
                'order_by' => 12,
                'color_code' =>'#F06549',
                'text_class' =>'text-dark',
            ],
            [
                'status_title' => 'Arrived',
                'class_name' => 'bg-soft-secondary',
                'order_by' => 13,
                'color_code' =>'#F06549',
                'text_class' =>'text-secondary',
            ],
            [
                'status_title' => 'Requested',
                'class_name' => 'bg-soft-primary',
                'order_by' => 10,
                'color_code' =>'#F06549',
                'text_class' =>'text-primary',
            ],

            [
                'status_title' => 'Cancel',
                'class_name' => 'bg-soft-warning',
                'order_by' => 9,
                'color_code' =>'#F06549',
                'text_class' =>'text-warning',
            ],
            [
                'status_title' => 'Packaging List Requested',
                'class_name' => 'bg-soft-secondary',
                'order_by' => 20,
                'color_code' =>'#F06549',
                'text_class' =>'text-dark',
            ],
            [
                'status_title' => 'Carrier Arrived',
                'class_name' => 'bg-soft-secondary',
                'order_by' => 21,
                'color_code' =>'#F06549',
                'text_class' =>'text-warning',
            ],

            [
                'status_title' => 'Completed',
                'class_name' => 'bg-soft-info',
                'order_by' => 22,
                'color_code' =>'#F06549',
                'text_class' =>'text-warning',
            ],

            [
                'status_title' => 'Package List Received',
                'class_name' => 'bg-soft-dark',
                'order_by' => 23,
                'color_code' =>'#F06549',
                'text_class' =>'text-dark',
            ],

            [
                'status_title' => 'Check In',
                'class_name' => 'bg-soft-light',
                'order_by' => 24,
                'color_code' =>'#F06549',
                'text_class' =>'text-dark',
            ],

            [
                'status_title' => 'Off Loading',
                'class_name' => 'bg-soft-warning',
                'order_by' => 25,
                'color_code' =>'#F06549',
                'text_class' =>'text-warning',
            ],

            [
                'status_title' => 'Item Put Away',
                'class_name' => 'bg-soft-success',
                'order_by' => 26,
                'color_code' =>'#F06549',
                'text_class' =>'text-success',
            ],
        ];
        foreach ($orderStatuses as $status){
            OrderStatus::updateOrCreate(
                ['status_title' =>$status['status_title']],
                [
                    'status_title' => $status['status_title'],
                    'class_name' => $status['class_name'],
                    'text_class' => $status['text_class'],
                    'order_by' => $status['order_by'],
                    'color_code' => $status['color_code'],
                ]);
        }
    }
}
