<?php

namespace App\Repositries\workOrder;

use App\Http\Helpers\Helper;
use App\Models\Carriers;
use App\Models\Company;
use App\Models\CustomerCompany;
use App\Models\Inventory;
use App\Models\PickedItem;
use App\Models\User;
use App\Models\WhLocation;
use App\Models\WorkOrder;
use App\Models\WorkOrderItem;
use App\Models\WorkOrderPicker;

use App\Repositries\appointment\AppointmentRepositry;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class WorkOrderRepositry implements WorkOrderInterface
{
    protected $workOrderFilePath = 'work-order-media/';


    public function getWorkOrderList($request)
    {
        try {
            $data['totalRecords'] = WorkOrder::count();
            $qry= WorkOrder::query();
            $qry= $qry->with('client:id,title','status:id,status_title,order_by','carrier');

            $qry = $qry->when($request->s_title, function ($query, $name) {
                    $query->where('order_reference', 'LIKE', "%{$name}%");
            });

            $qry=$qry->when($request->status, function ($query, $status) {
                return $query->where('status_code',$status);
            });
            $qry=$qry->when($request->start, fn($q)=>$q->offset($request->start));
            $qry=$qry->when($request->length, fn($q)=>$q->limit($request->length));
            $data['data'] =$qry->orderByDesc('id')->get();

            if (!empty($request->get('s_title')) ) {
                $data['totalRecords']=$qry->count();
            }
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

    public function saveUploadBOL($request)
    {
        try {

            DB::beginTransaction();
            $validator = Validator::make($request->all(), [
                'BOLDocument' => 'required',
            ]);
            if ($validator->fails())
                return Helper::errorWithData($validator->errors()->first(), $validator->errors());

            $workOrder=WorkOrder::find($request->w_order_id);

            $fileableId = $workOrder->id;
            $fileableType = 'App\Models\WorkOrder';
            $order = new AppointmentRepositry();

            if($request->file('BOLDocument')){
                $BOLDocFileName = $order->handleFiles($request->file('BOLDocument'), $this->workOrderFilePath);
                $order->mediaUpload($BOLDocFileName,'Doc',$fileableId,$fileableType,1,"BOLDocument");
            }

            DB::commit();

            return Helper::success($workOrder,'BOL Document uploaded successfully');

        } catch (\Exception $e) {
            DB::rollBack();
            return Helper::errorWithData($e->getMessage(),[]);
        }

    }

    public function importWorkOrder($orders)
    {
        try {

            DB::beginTransaction();
            foreach ($orders as $order) {
                $datetime = Carbon::parse($order['created_date'])->format('Y-m-d H:i:s');
                $datetimeupdated = Carbon::parse($order['updated_date'])->format('Y-m-d H:i:s');

                $workOrder = WorkOrder::where("wms_transaction_id", $order['id'])->first();
                if (!$workOrder || $workOrder->wms_updated_at != $datetimeupdated) {

                    $company = $this->createOrUpdateCompany($order['customer']);

                    $carrier = $this->createOrUpdateCarrier($order['shipping_method']);
                    $workOrder = $this->createOrUpdateWorkOrder($order, $company, $carrier, $datetime, $datetimeupdated);
                    foreach ($order['line_items'] as $item) {
                        foreach ($item['inventory'] as $product) {
                            foreach ($product['locations'] as $location) {
                                $this->createOrUpdateWorkOrderItem($workOrder, $product, $location);
                            }
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
    public function createOrUpdateCompany($customer) {
        return CustomerCompany::updateOrCreate(
            ['wms_customer_id' => $customer['id']],
            ['title' => $customer['name'], 'email' => $customer['email'] ?? null]
        );
    }

    public function createOrUpdateCarrier($shipping_method) {
        if (!$shipping_method) return null;

        $carrierCompany = Company::updateOrCreate(
            ['company_title' => $shipping_method],
            ['company_title' => $shipping_method]
        );

        if ($carrierCompany) {
            return Carriers::updateOrCreate(
                ['carrier_company_name' => $carrierCompany->company_title, 'company_id' => $carrierCompany->id],
                ['email' => 'test@gmail.com', 'contacts' => '+00000000000']
            );
        }

        return null;
    }

    public function createOrUpdateWorkOrder($order, $company, $carrier, $datetime, $datetimeupdated) {
        return WorkOrder::updateOrCreate(
            ['order_reference' => $order['reference_id'], 'wms_transaction_id' => $order['id']],
            [
                'wms_transaction_id' => $order['id'],
                'client_id' => $company->id,
                'ship_method' => $order['shipping_method'],
                'order_date' => $datetime,
                'ship_date' => $datetime,
                'load_type_id' => null,
                'carrier_id' => $carrier->id ?? null,
                'order_reference' => $order['reference_id'],
                'wms_order_status' => $order['status'],
                'wms_created_at' => $datetime,
                'wms_updated_at' => $datetimeupdated,
                'status_code' => 201
            ]
        );
    }

    public  function createOrUpdateWorkOrderItem($workOrder, $product, $location) {
        $inventory = Inventory::updateOrCreate(
            ['sku' => $product['sku'], 'warehouse_customer_id' => $product['warehouse_customer_id']],
            ['item_name' => $product['name'], 'product_id' => $product['id']]
        );

        $myloc = WhLocation::where('wms_location_id', $location['location_id'])->first();

        if ($myloc) {
            return WorkOrderItem::updateOrCreate(
                ['work_order_id' => $workOrder->id, 'loc_id' => $myloc->id],
                [
                    'inventory_id' => $inventory->id,
                    'loc_id' => $myloc->id,
                    'qty' => $location['quantity'],
                    'pallet_number' => $workOrder->order_reference,
                    'auth_id' => 1
                ]
            );
        }
    }

    public function getAllWorkOrderList()
    {
        try {
            $qry= WorkOrder::query();
            $qry= $qry->with('client:id,title','status:id,status_title,order_by');
            $data =$qry->orderByDesc('id')->get();
            return Helper::success($data, $message="Out bound orders list");

        } catch (\Exception $e) {
            return Helper::errorWithData($e->getMessage(),[]);
        }

    }

    public function getWorkOrder($request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'work_order_id' => 'required',
            ]);

            if ($validator->fails())
                return Helper::errorWithData($validator->errors()->first(), $validator->errors());

            $workOrderId = $request->work_order_id;
            $res = WorkOrder::with('loadType','client')->where('id', $workOrderId)->first();
            return Helper::success($res, $message='Record found');
        }  catch (\Exception $e) {
            return Helper::errorWithData($e->getMessage(),[]);
        }
    }
}
