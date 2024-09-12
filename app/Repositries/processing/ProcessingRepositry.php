<?php

namespace App\Repositries\processing;

use App\Http\Helpers\Helper;
use App\Models\MissedItem;
use App\Models\MissedItemDetail;
use App\Models\OrderItemPutAway;
use App\Models\OrderProcessing;
use App\Models\PickedItem;
use App\Models\QcDetailWorkOrder;
use App\Models\QcWorkOrder;
use App\Models\WorkOrder;
use App\Models\WorkOrderItem;
use App\Models\WorkOrderPicker;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class ProcessingRepositry implements ProcessingInterface
{

    protected $pickedItemFilePath = 'picked-item-media/';
    public function getProcessList($request)
    {
        try {
            $data['totalRecords'] = OrderProcessing::publish()->count();
            $qry= OrderProcessing::query();
            $qry= $qry->with('workOrder.client','workOrder.loadType.direction','workOrder.loadType.eqType','status');
            $qry= $qry->publish();
//            $qry= $qry->where('status_code',205);
            $qry=$qry->when($request->start, fn($q)=>$q->offset($request->start));
            $qry=$qry->when($request->length, fn($q)=>$q->limit($request->length));
            $data['data'] =$qry->orderByDesc('id')->get();
            return Helper::success($data, $message="Record found");

        } catch (\Exception $e) {
            return Helper::errorWithData($e->getMessage(),[]);
        }

    }
    public function getProcessInfo($id)
    {
        try {

            $qry= OrderProcessing::query();
            $qry= $qry->with('workOrder.client','workOrder.loadType.eqType','qcWorkOrder');
            $data =$qry->find($id);
            return Helper::success($data, $message="Record found");

        } catch (\Exception $e) {
            return Helper::errorWithData($e->getMessage(),[]);
        }

    }
    public function updateStartProcess($request)
    {
        try {

            $qry= OrderProcessing::find($request->process_id);
            if(!$qry){
                return Helper::error('Invalid Processing Id');
            }
            ($request->updateType==1)?$qry->start_time=Carbon::now():$qry->end_time=Carbon::now();
            ($request->updateType==2)?$qry->status_code=$request->status_code:'';
            if($request->updateType ==1)
            {
                ($request->carton_label_req)?$qry->carton_label_req=1:$qry->carton_label_req=2;
                ($request->pallet_label_req)?$qry->pallet_label_req=1:$qry->pallet_label_req=2;
                ($request->other_reqs)?$qry->other_require=$request->other_reqs:null;
            }
            $qry->save();
            return Helper::success($qry, ($request->updateType==1)?"Processing start successfully":"Processing close successfully");

        } catch (\Exception $e) {
            return Helper::errorWithData($e->getMessage(),[]);
        }

    }
    public function getProcessItems($qcId)
    {
        try {

            $qry= QcDetailWorkOrder::query();
            $qry= $qry->with('workOrderItem.inventory','workOrderItem.location','media');
            $qry =$qry->where('qc_parent_id',$qcId);
            $data =$qry->get();

            return Helper::success($data, $message="Record found");

        } catch (\Exception $e) {
            return Helper::errorWithData($e->getMessage(),[]);
        }

    }
    //savePickedItems
    public function createProcessItems($request)
    {

        try {

            DB::beginTransaction();

              $workOrderId=$request->workOrderId;
                $pickerId=WorkOrderPicker::where('work_order_id',$workOrderId)->pluck('id');

//            $pickedItems = PickedItem::whereIn('picker_table_id', $pickerId)
//                ->selectRaw('inventory_id, w_order_item_id, SUM(picked_qty) as total_picked_qty')
//                ->groupBy('inventory_id', 'w_order_item_id')
//                ->where('picked_qty','>',0)
//                ->get();



            $workOrderItem=WorkOrderItem::where('work_order_id',$workOrderId)->get();
            if($workOrderItem->count() > 0) {

                $qcWorkOrder = QcWorkOrder::updateOrCreate(
                    [
                        'work_order_id' => $workOrderId,
                    ],
                    [
                        'work_order_id' => $workOrderId,
                        'status_code' => 205,
                        'auth_id' => Auth::user()->id,
                    ]
                );

                    foreach ($workOrderItem as $row){

                        $totalPickedQty = PickedItem::whereIn('picker_table_id', $pickerId)
                            ->where('inventory_id', $row->inventory_id)
                            ->sum('picked_qty');

                    $qcDetail = QcDetailWorkOrder::class::updateOrCreate(
                        [
                            'qc_parent_id' => $qcWorkOrder->id,
                            'w_order_item_id' => $row->id,
                        ],
                        [
                            'qc_parent_id' => $qcWorkOrder->id,
                            'w_order_item_id' => $row->id,
                            'picked_qty' => $totalPickedQty,
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
    public function getAllProcessForApi()
    {
        try {

            $qry= QcWorkOrder::query();
            $qry= $qry->with('workOrder.client','workOrder.loadType.direction','workOrder.loadType.eqType','status');
//            $qry= $qry->where('status_code',205);
            $qry= $qry->publish();
            $data =$qry->orderByDesc('id')->get();
            return Helper::success($data, $message="Record found");

        } catch (\Exception $e) {
            return Helper::errorWithData($e->getMessage(),[]);
        }

    }
    public function updateProcessItems($request)
    {
        try {
            foreach ($request->hidden_id as $key=>$val){
                $qcDetail = QcDetailWorkOrder::class::updateOrCreate(
                        [
                            'id' => $request->hidden_id[$key],
                        ],
                        [
                            'qc_picked_qty' => $request->qcQty[$key],
                        ]
                    );
                if ($qcDetail) {
                    $fileableId = $qcDetail->id;
                    $fileableType = 'App\Models\QcDetailWorkOrder';

                    // Handle multiple file uploads for each row
                    if ($request->hasFile("qcItemImages.$key")) {
                        $uploadedFiles = $request->file("qcItemImages.$key");
                        $imageSets = [
                            'qcItemImages' => $uploadedFiles
                        ];
                        if (!empty($imageSets['qcItemImages'])) {
                            $media = Helper::uploadMultipleMedia($imageSets, $fileableId, $fileableType, $this->pickedItemFilePath);
                        }
                    }

                }
                }
            return Helper::success($qcDetail,'Qc updated successfully');
        }  catch (\Exception $e) {
            return Helper::errorWithData($e->getMessage(),[]);
        }
    }


}
