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
    public function saveResolveItems($request)
    {

        try {
            DB::beginTransaction();
            $validator = Validator::make($request->all(), [
                'itemId.*' => 'required',
            ]);
            if ($validator->fails())
                return Helper::errorWithData($validator->errors()->first(), $validator->errors());


            $workOrderPicker= WorkOrderPicker::updateOrCreate(
                [
                    'work_order_id' =>0,
                ],
                [
                    'work_order_id' => $request->w_order_id,
                    'picker_id' => $request->staff_id,
                    'status_code' => $request->status_code,
                    'auth_id' =>Auth::user()->id,
                ]
            );

            foreach ($request->itemId as $key => $val) {

                $values = explode(',', $val);

//                    $inventoryId= $values[0];
//                    $wOrderItemId= $values[1];


                    $pickedItems= PickedItem::updateOrCreate(
                        [
                            'id' =>0
                        ],
                        [
                            'picker_table_id' =>$workOrderPicker->id,
                            'w_order_item_id' =>$values[1],
                            'inventory_id' =>$values[0],
                            'loc_id' =>$request->newLocId[$key],
                            'order_qty' =>$request->resolveQty[$key],
                        ]
                    );




                if ($pickedItems) {
                    $fileableId = $pickedItems->id;
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

                    if ($request->hasFile("newLocationItemImages.$key")) {

                        $uploadedFiles = $request->file("newLocationItemImages.$key");

                        $imageSets = [
                            'newLocationItemImages' => $uploadedFiles
                        ];

                        if (!empty($imageSets['newLocationItemImages'])) {
                            $media = Helper::uploadMultipleMedia($imageSets, $fileableId, $fileableType, $this->pickedItemFilePath);
                        }
                    }
                }
            }

            $missedTable=MissedItem::find($request->missed_id);
            $missedTable->end_time=Carbon::now();
            $missedTable->status_code=22;
            $missedTable->save();

            $message = __('Missing item resolve successfully');
            DB::commit();


            return Helper::success($workOrderPicker,$message);
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
