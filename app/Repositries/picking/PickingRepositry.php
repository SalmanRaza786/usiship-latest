<?php

namespace App\Repositries\picking;

use App\Http\Helpers\Helper;
use App\Models\MissedItem;
use App\Models\MissedItemDetail;
use App\Models\OrderItemPutAway;
use App\Models\PickedItem;
use App\Models\WorkOrder;
use App\Models\WorkOrderPicker;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class PickingRepositry implements PickingInterface
{

    protected $pickedItemFilePath = 'picked-item-media/';

    public function getAllPickers($request)
    {
        try {
            $data['totalRecords'] = WorkOrderPicker::publish()->count();
            $qry= WorkOrderPicker::query();
            $qry= $qry->with('workOrder.client','workOrder.carrier','workOrder.loadType.direction','workOrder.loadType.eqType','status');
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

    public function getPickerInfo($id)
    {
        try {

            $qry= WorkOrderPicker::query();
            $qry= $qry->with('workOrder.client','workOrder.loadType.eqType');
            $data =$qry->find($id);
            return Helper::success($data, $message="Record found");

        } catch (\Exception $e) {
            return Helper::errorWithData($e->getMessage(),[]);
        }

    }
    public function updateStartPicking($request)
    {
        try {

            DB::beginTransaction();

            $qry= WorkOrderPicker::find($request->pickerId);
            if(!$qry){
                return Helper::error('Invalid picker id');
            }
            ($request->updateType==2)?$qry->status_code=204:$qry->status_code=203;
            ($request->updateType==1)?$qry->start_time=Carbon::now():$qry->end_time=Carbon::now();
            $data['workOrder']=$qry->save();


            if($request->updateType==2) {
             $data['qc']=Helper::saveQcItems($request);
             MissedItem::where('picker_table_id',$request->pickerId)->update(['is_publish'=>1]);
            }

            DB::commit();
            return Helper::success($data, ($request->updateType==1)?"Picking start success fully":"Picking close success fully");

        } catch (\Exception $e) {
            DB::rollBack();
            return Helper::errorWithData($e->getMessage(),[]);
        }

    }
    public function getPickingItems($pickerId)
    {
        try {

            $qry= PickedItem::query();
            $qry= $qry->with('media','missedItem','inventory','location','wOrderItems');
            $qry =$qry->where('picker_table_id', $pickerId);
            $data =$qry->get();

            return Helper::success($data, $message="Record found");

        } catch (\Exception $e) {
            return Helper::errorWithData($e->getMessage(),[]);
        }

    }

    //savePickedItems


    public function savePickedItems($request)
    {

        try {
            DB::beginTransaction();
            $validator = Validator::make($request->all(), [
                'pickedLocId.*' => 'required',
            ]);
            if ($validator->fails())
                return Helper::errorWithData($validator->errors()->first(), $validator->errors());



            foreach ($request->hidden_id as $key => $val) {

                $pickedItem = PickedItem::find($request->hidden_id[$key]);
                $newPickedQty = $pickedItem->order_qty - $request->missedQty[$key];

                $item = PickedItem::updateOrCreate(
                    [
                        'id' =>$request->hidden_id[$key]
                    ],
                    [
                        'picked_loc_id' =>$request->pickedLocId[$key],
                        'picked_qty' =>$newPickedQty
                    ]
                );

                if($request->missedQty[$key] > 0){
                    $missedItem = MissedItem::updateOrCreate(
                        [
                            'picker_table_id' =>$pickedItem->picker_table_id,
                        ],
                        [
                            'picker_table_id' =>$pickedItem->picker_table_id,
                            'work_order_id' =>$request->work_order_id,
                            'auth_id' =>Auth::user()->id,
                            'is_publish' =>2,
                            'status_code' =>205
                        ]
                    );


                    $missedItemDetail = MissedItemDetail::updateOrCreate(
                        [
                            'missed_items_parent_id' =>$missedItem->id,
                            'picked_item_table_id' =>$item->id,
                        ],
                        [
                            'missed_items_parent_id' =>$missedItem->id,
                            'picked_item_table_id' =>$item->id,
                            'inventory_id' =>$item->inventory_id,
                            'missed_qty' =>$request->missedQty[$key]
                        ]
                    );
                }

                if ($item) {
                    $fileableId = $item->id;
                    $fileableType = 'App\Models\PickedItem';

                    // Handle multiple file uploads for each row
                    if ($request->hasFile("pickedItemImages.$key")) {
                        $uploadedFiles = $request->file("pickedItemImages.$key");

                        $imageSets = [
                            'pickedItemImages' => $uploadedFiles
                        ];

                        if (!empty($imageSets['pickedItemImages'])) {
                            $media = Helper::uploadMultipleMedia($imageSets, $fileableId, $fileableType, $this->pickedItemFilePath);
                        }
                    }
                }
            }



            $message = __('translation.record_created');
            DB::commit();


            return Helper::success($item,$message);
        }  catch (\Exception $e) {
            DB::rollBack();
            return Helper::errorWithData($e->getMessage(),[]);
        }
    }

    public function getAllPickersForApi()
    {
        try {

            $qry= WorkOrderPicker::query();
            $qry= $qry->with('workOrder.client','workOrder.carrier','workOrder.loadType.direction','workOrder.loadType.eqType','status');
            $qry= $qry->publish();
//            $qry= $qry->where('status_code',205);
            $data=$qry->orderByDesc('id')->get();
            return Helper::success($data, $message="Record found");

        } catch (\Exception $e) {
            return Helper::errorWithData($e->getMessage(),[]);
        }

    }


}
