<?php

namespace App\Repositries\processing;

use App\Http\Helpers\Helper;
use App\Models\MissedItem;
use App\Models\MissedItemDetail;
use App\Models\OrderItemPutAway;
use App\Models\OrderProcessing;
use App\Models\PickedItem;
use App\Models\ProcessingDetail;
use App\Models\ProcessingTask;
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

    protected $pickedItemFilePath = 'processing-detail-media/';
    public function getProcessList($request)
    {
        try {
            $data['totalRecords'] = OrderProcessing::publish()->count();
            $qry= OrderProcessing::query();
            $qry= $qry->with('workOrder.client','workOrder.loadType.direction','workOrder.loadType.eqType','workOrder.carrier','status');
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
            if($request->updateType == 1 && $qry)
            {
                $work_order = WorkOrder::find($qry->work_order_id);
                $work_order->load_type_id= $request->load_type_id ?? 3;
                $work_order->save();
            }
            if($request->updateType == 2 && $qry)
            {
                $work_order = WorkOrder::find($qry->work_order_id);
                $work_order->status_code= 204;
                $work_order->save();
            }
            return Helper::success($qry, ($request->updateType==1)?"Processing start successfully":"Processing close successfully");

        } catch (\Exception $e) {
            return Helper::errorWithData($e->getMessage(),[]);
        }

    }
    public function getProcessItems($qcId)
    {
        try {

            $qry= ProcessingDetail::query();
            $qry = $qry->with('media');
            $qry =$qry->where('processing_id',$qcId);
            $data =$qry->get();

            return Helper::success($data, $message="Record found");

        } catch (\Exception $e) {
            return Helper::errorWithData($e->getMessage(),[]);
        }

    }
    public function getProcessTasks()
    {
        try {
            $qry= ProcessingTask::where('status',1);
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

                $prcessingItem = ProcessingDetail::updateOrCreate(
                    [
                        'work_order_id' => $request->work_order_id,
                        'id' => $request->processDetailId,
                    ],
                    [
                        'work_order_id' => $request->work_order_id,
                        'comment' => $request->comments,
                        'qty' => $request->qty,
                        'processing_id' =>$request->processId,
                        'task_id' => $request->itemId,
                        'status_code' => $request->status_code,
                        'auth_id' => Auth::user()->id,
                    ]
                );

            if ($prcessingItem) {
                $fileableId = $prcessingItem->id;
                $fileableType = 'App\Models\ProcessingDetail';

                // Handle multiple file uploads for each row
                if ($request->hasFile("processingItemImages")) {
                    $uploadedFiles = $request->file('processingItemImages', []);
                    $imageSets = [
                        'processingItemImages' => $uploadedFiles
                    ];
                    if (!empty($imageSets['processingItemImages'])) {
                        $media = Helper::uploadMultipleMedia($imageSets, $fileableId, $fileableType, $this->pickedItemFilePath);
                    }
                }

            }

            DB::commit();
            return Helper::success($prcessingItem,'Processing Item updated successfully');
        }  catch (\Exception $e) {
            DB::rollBack();
            return Helper::errorWithData($e->getMessage(),[]);
        }
    }
    public function getAllProcessForApi()
    {
        try {

            $qry= OrderProcessing::query();
            $qry= $qry->with('workOrder.client','workOrder.loadType.direction','workOrder.loadType.eqType','status');
//            $qry= $qry->where('status_code',205);
//            $qry= $qry->publish();
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


    public function deleteProcessItems($request)
    {
        try {
                $pdetail = ProcessingDetail::find($request->id);
                $pdetail->delete();

                return Helper::success($pdetail,'Items removed successfully');
        }  catch (\Exception $e) {
            return Helper::errorWithData($e->getMessage(),[]);
        }
    }
}
