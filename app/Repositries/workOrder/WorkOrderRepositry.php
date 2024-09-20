<?php

namespace App\Repositries\workOrder;

use App\Http\Helpers\Helper;
use App\Models\CustomerCompany;
use App\Models\Inventory;
use App\Models\PickedItem;
use App\Models\User;
use App\Models\WhLocation;
use App\Models\WorkOrder;
use App\Models\WorkOrderItem;
use App\Models\WorkOrderPicker;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class WorkOrderRepositry implements WorkOrderInterface
{



    public function getWorkOrderList($request)
    {
        try {
            $data['totalRecords'] = WorkOrder::count();
            $qry= WorkOrder::query();
            $qry= $qry->with('client:id,name','status:id,status_title,order_by');
            $qry=$qry->when($request->start, fn($q)=>$q->offset($request->start));
            $qry=$qry->when($request->length, fn($q)=>$q->limit($request->length));
            $data['data'] =$qry->orderByDesc('id')->get();
            return Helper::success($data, $message="Record found");

        } catch (\Exception $e) {
            return Helper::errorWithData($e->getMessage(),[]);
        }

    }

    public function savePickerAssign($request)
    {
        try {

            DB::beginTransaction();
            $workOrderPicker= WorkOrderPicker::updateOrCreate(
                [
                    'work_order_id' =>$request->w_order_id,
                ],
                [
                    'work_order_id' => $request->w_order_id,
                    'picker_id' => $request->staff_id,
                    'status_code' => $request->status_code,
                    'auth_id' =>Auth::user()->id,
                ]
            );


            $items=WorkOrderItem::where('work_order_id',$request->w_order_id)->get();
            if($items->count() > 0){
                foreach ($items as $row){

                    $pickedItems= PickedItem::updateOrCreate(
                        [
                            'w_order_item_id' =>$row->id,
                        ],
                        [
                            'picker_table_id' =>$workOrderPicker->id,
                            'w_order_item_id' =>$row->id,
                            'inventory_id' =>$row->inventory_id,
                            'loc_id' =>$row->loc_id,
                            'order_qty' =>$row->qty,
                        ]
                    );
                }
            }

            $workOrder=WorkOrder::find($request->w_order_id);
            $workOrder->status_code=202;
            $workOrder->save();


            DB::commit();
            return Helper::success($workOrderPicker,'Job assigned successfully');

        } catch (\Exception $e) {
            DB::rollBack();
            return Helper::errorWithData($e->getMessage(),[]);
        }

    }
    public function importWorkOrder($orders)
    {
        try {

            DB::beginTransaction();
            foreach($orders as $order){
                $datetime = Carbon::parse($order['created_date'])->format('Y-m-d H:i:s');
                $company = CustomerCompany::updateOrCreate(
                    [
                        'title'=>$order['customer']['name'],
                    ],
                    [
                        'title'=>$order['customer']['name'],
                        'email'=>$company->email ?? 'abc@gmail.com',
                    ]);

                $client = User::updateOrCreate(
                    [
                        'name' =>  $company->title,
                    ],
                   [
                       'name' => $company->title,
                       'email' => $company->email,
                       'password' => Hash::make('iub12345678'),
                       'company_id' => $company->id,
                       'company_name' => $company->title,
                       'status' => 2,
                   ]
                );

                $workOrder = WorkOrder::updateOrCreate(
                    ['order_reference' => $order['reference_id']],
                    [
                        'client_id' =>$client->id,
                        'ship_method' => $order['shipping_method'],
                        'order_date' =>$datetime,
                        'ship_date' =>$datetime,
                        'load_type_id' => 1,
                        'carrier_id' => 1,
                        'order_reference' => $order['reference_id'],
                        'status_code' => 201,
                    ]);
                foreach ($order['line_items'] as $item) {
                    foreach ($item['inventory'] as $product) {
                        $inventory = Inventory::updateOrCreate(
                            [
                                'sku' => $product['sku'],
                                'warehouse_customer_id' => $product['warehouse_customer_id'],

                            ],
                            [
                                'sku' => $product['sku'],
                                'item_name' => $product['name'],
                                'product_id' => $product['id'],
                                'warehouse_customer_id' => $product['warehouse_customer_id'],
                            ]);

                        foreach ($product['locations'] as $location) {

                            $myloc = WhLocation::where('wms_location_id',$location['location_id'])->first();

                            $workOrderItem = WorkOrderItem::updateOrCreate(
                                ['id' => 0],
                                [
                                    'work_order_id' => $workOrder->id,
                                    'inventory_id' => $inventory->id,
                                    'loc_id' => $myloc->id,
                                    'qty' =>  $location['quantity'],
                                    'pallet_number' => $order['type'],
                                    'auth_id' => 1,
                                ]);
                        }
                    }
                }
            }

            DB::commit();
            return Helper::success($workOrder,'Order Imported successfully');

        } catch (\Exception $e) {
            DB::rollBack();
            return Helper::errorWithData($e->getMessage(),[]);
        }

    }

    public function getAllWorkOrderList()
    {
        try {

            $qry= WorkOrder::query();
            $qry= $qry->with('client:id,name','status:id,status_title,order_by');
            $data =$qry->orderByDesc('id')->get();
            return Helper::success($data, $message="Out bound orders list");

        } catch (\Exception $e) {
            return Helper::errorWithData($e->getMessage(),[]);
        }

    }
}
