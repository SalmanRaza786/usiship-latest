<?php

namespace App\Repositries\missing;

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


class MissingRepositry implements MissingInterface
{

    protected $pickedItemFilePath = 'picked-item-media/';

    public function getAllMissing($request)
    {
        try {
            $data['totalRecords'] = MissedItem::count();
            $qry= MissedItem::query();
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
            $qry= $qry->with('workOrder.client','workOrder.loadType.eqType');
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

            return Helper::success($qry, ($request->updateType==1)?"Picking start success fully":"Picking end success fully");

        } catch (\Exception $e) {
            return Helper::errorWithData($e->getMessage(),[]);
        }

    }
    public function getMissedItems($missedId)
    {
        try {

            $qry= MissedItemDetail::query();
            $qry= $qry->with('pickedItem.inventory','pickedItem.location');
            $qry =$qry->where('missed_items_parent_id', $missedId);
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
                            'work_order_id' =>$pickedItem->picker_table_id,
                            'auth_id' =>Auth::user()->id,
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

            $workOrderPicker=WorkOrderPicker::find($pickedItem->picker_table_id);
            $workOrderPicker->status_code=204;
            $workOrderPicker->save();

            $message = __('translation.record_created');
            DB::commit();


            return Helper::success($item,$message);
        }  catch (\Exception $e) {
            DB::rollBack();
            return Helper::errorWithData($e->getMessage(),[]);
        }
    }


}
