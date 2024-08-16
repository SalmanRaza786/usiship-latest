<?php

namespace Database\Seeders;

use App\Models\Carriers;
use App\Models\Inventory;
use App\Models\LoadType;
use App\Models\User;
use App\Models\WhLocation;
use App\Models\WorkOrder;
use App\Models\WorkOrderItem;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WorkOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            DB::beginTransaction();
            $client = User::first();
            $loadType = LoadType::first();
            $carrier = Carriers::first();
            $loc = WhLocation::inRandomOrder()->first();

            $today = Carbon::now();
            $dateWithAddedDays = $today->addDays(10);

            $workOrder = WorkOrder::updateOrCreate(

                ['id' => 0],
                [

                    'client_id' => $client->id,
                    'ship_method' => 'TCS',
                    'order_date' => $today,
                    'ship_date' => $dateWithAddedDays,
                    'load_type_id' => $loadType->id,
                    'carrier_id' => $carrier->id,
                    'order_reference' => 'ORD-8561',
                    'status_code' => 201,
                ]);


            $randomRecords = Inventory::inRandomOrder()->take(3)->get();
            if ($randomRecords->count() > 0) {

                foreach ($randomRecords as $row) {
                    $workOrderItem = WorkOrderItem::updateOrCreate(

                        ['id' => 0],
                        [

                            'work_order_id' => $workOrder->id,
                            'inventory_id' => $row->id,
                            'loc_id' => $loc->id,
                            'qty' => 10,
                            'pallet_number' => 'PLT-59584',
                            'auth_id' => 1,

                        ]);
                }
            }
            DB::commit();


        } catch (\Exception $e) {
            DB::rollBack();
        }
    }
}
