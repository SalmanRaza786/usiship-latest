<?php

namespace App\Repositries\qc;

use App\Http\Helpers\Helper;
use App\Models\MissedItem;
use App\Models\MissedItemDetail;
use App\Models\OrderItemPutAway;
use App\Models\PickedItem;
use App\Models\QcDetailWorkOrder;
use App\Models\QcWorkOrder;
use App\Models\WorkOrder;
use App\Models\WorkOrderPicker;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class QcRepositry implements QcInterface
{

    protected $pickedItemFilePath = 'picked-item-media/';

    public function getQcList($request)
    {
        try {
            $data['totalRecords'] = QcWorkOrder::count();
            $qry= QcWorkOrder::query();
            $qry= $qry->with('workOrder.client','workOrder.loadType.direction','workOrder.loadType.eqType','status');
            $qry= $qry->where('status_code',205);
            $qry=$qry->when($request->start, fn($q)=>$q->offset($request->start));
            $qry=$qry->when($request->length, fn($q)=>$q->limit($request->length));
            $data['data'] =$qry->orderByDesc('id')->get();
            return Helper::success($data, $message="Record found");

        } catch (\Exception $e) {
            return Helper::errorWithData($e->getMessage(),[]);
        }

    }

    public function getMissedInfo($id)
    {
        try {

            $qry= MissedItem::query();
            $qry= $qry->with('workOrder.client','workOrder.loadType.eqType','orderPicker');
            $data =$qry->find($id);
            return Helper::success($data, $message="Record found");

        } catch (\Exception $e) {
            return Helper::errorWithData($e->getMessage(),[]);
        }

    }
    public function updateStartResolve($request)
    {
        try {

            $qry= MissedItem::find($request->missedId);
            if(!$qry){
                return Helper::error('Invalid missing id');
            }
            ($request->updateType==1)?$qry->start_time=Carbon::now():$qry->end_time=Carbon::now();
            $qry->save();

            return Helper::success($qry, ($request->updateType==1)?"Missing resolve start success fully":"Missing resolve end success fully");

        } catch (\Exception $e) {
            return Helper::errorWithData($e->getMessage(),[]);
        }

    }
    public function getQcItems($qcId)
    {
        try {

            $qry= QcDetailWorkOrder::query();
            $qry= $qry->with('workOrderItem.inventory','workOrderItem.location');
            $qry =$qry->where('qc_parent_id',$qcId);
            $data =$qry->get();

            return Helper::success($data, $message="Record found");

        } catch (\Exception $e) {
            return Helper::errorWithData($e->getMessage(),[]);
        }

    }

    //savePickedItems
    public function saveQcItems($request)
    {

        try {

            DB::beginTransaction();

            $workOrderId=1;
            $pickerId=WorkOrderPicker::where('work_order_id',$workOrderId)->pluck('id');

            $pickedItems = PickedItem::whereIn('picker_table_id', $pickerId)
                ->selectRaw('inventory_id, w_order_item_id, SUM(picked_qty) as total_picked_qty')
                ->groupBy('inventory_id', 'w_order_item_id')
                ->get();

            if($pickedItems->count() > 0) {


                $qcWorkOrder = QcWorkOrder::updateOrCreate(
                    [
                        'work_order_id' => $workOrderId,
                    ],
                    [
                        'work_order_id ' => $workOrderId,
                        'status_code' => 205,
                        'auth_id' => Auth::user()->id,
                    ]
                );

                    foreach ($pickedItems as $row){
                    $qcDetail = QcDetailWorkOrder::class::updateOrCreate(
                        [
                            'qc_parent_id' => $qcWorkOrder->id,
                            'w_order_item_id' => $row->w_order_item_id,
                        ],
                        [
                            'qc_parent_id' => $qcWorkOrder->id,
                            'w_order_item_id' => $row->w_order_item_id,
                            'picked_qty' => $row->total_picked_qty,
                        ]
                    );
                }
            }

            DB::commit();
            return Helper::success($qcDetail,'Qc created successfully');
        }  catch (\Exception $e) {
            DB::rollBack();
            return Helper::errorWithData($e->getMessage(),[]);
        }
    }

    public function getAllMissingForApi()
    {
        try {

            $qry= MissedItem::query();
            $qry= $qry->with('workOrder.client','workOrder.loadType.direction','workOrder.loadType.eqType','status');
            $qry= $qry->where('status_code',205);
            $data['data'] =$qry->orderByDesc('id')->get();
            return Helper::success($data, $message="Record found");

        } catch (\Exception $e) {
            return Helper::errorWithData($e->getMessage(),[]);
        }

    }


}
