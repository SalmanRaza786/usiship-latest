<?php

namespace Database\Seeders;

use App\Models\WareHouse;
use App\Models\WhDoor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WhDoorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if($wh=WareHouse::first()){
        $orderStatuses = [
            [
                'wh_id' => $wh->id,
                'door_title' =>'Door 1',
                'status' => 1,
            ],
            [
                'wh_id' => $wh->id,
                'door_title' =>'Door 2',
                'status' => 1,
            ],
            [
                'wh_id' => $wh->id,
                'door_title' =>'Door 3',
                'status' => 1,
            ],     [
                'wh_id' => $wh->id,
                'door_title' =>'Door 4',
                'status' => 1,
            ],     [
                'wh_id' => $wh->id,
                'door_title' =>'Door 5',
                'status' => 1,
            ],

        ];
        foreach ($orderStatuses as $status){
            WhDoor::updateOrCreate(
                ['door_title' =>$status['door_title']],
                [
                    'door_title' => $status['door_title'],
                    'wh_id' => $status['wh_id'],
                    'status' => $status['status'],
                ]);
        }
        }
    }
}
