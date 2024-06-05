<?php

namespace Database\Seeders;

use App\Models\WareHouse;
use App\Models\WhDoor;
use App\Models\WhLocation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WhLocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if($wh=WareHouse::first()) {

            $orderStatuses = [
                [
                    'wh_id' => $wh->id,
                    'loc_title' => 'Loc A',
                    'status' => 1,
                ],
                [
                    'wh_id' => $wh->id,
                    'loc_title' => 'Loc B',
                    'status' => 1,
                ],
                [
                    'wh_id' => $wh->id,
                    'loc_title' => 'Loc C',
                    'status' => 1,
                ], [
                    'wh_id' => $wh->id,
                    'loc_title' => 'Loc D',
                    'status' => 1,
                ], [
                    'wh_id' => $wh->id,
                    'loc_title' => 'Loc E',
                    'status' => 1,
                ],

            ];
            foreach ($orderStatuses as $status) {
                WhLocation::updateOrCreate(
                    ['loc_title' => $status['loc_title']],
                    [
                        'loc_title' => $status['loc_title'],
                        'wh_id' => $status['wh_id'],
                        'status' => $status['status'],
                    ]);
            }
        }
    }
}
