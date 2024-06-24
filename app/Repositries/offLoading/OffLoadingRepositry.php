<?php
namespace App\Repositries\offLoading;

use App\Http\Helpers\Helper;

use App\Models\Admin;
use App\Models\LoadType;
use App\Models\OrderCheckIn;
use App\Models\OrderContacts;
use App\Models\OrderOffLoading;
use App\Models\WareHouse;
use App\Models\WhDock;
use App\Repositries\appointment\AppointmentRepositry;
use App\Repositries\checkIn\CheckInRepositry;
use App\Repositries\offLoading\OffLoadingInterface;
use App\Repositries\orderContact\OrderContactRepositry;
use App\Traits\HandleFiles;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use DataTables;


class OffLoadingRepositry implements OffLoadingInterface {
    protected $offLoadingFilePath = 'off-loading-media/';
    use HandleFiles;
    public function getOffLoadingList($request)
    {
        try {

            $data['totalRecords'] = OrderCheckIn::count();

            $qry = OrderCheckIn::query();
            $qry =$qry->with('order.dock.loadType.eqType','status');

            $qry=$qry->when($request->s_name, function ($query, $name) {
                return $query->whereRelation('order','order_id', 'LIKE', "%{$name}%");
            });

            $qry=$qry->when($request->start, fn($q)=>$q->offset($request->start));
            $qry=$qry->when($request->length, fn($q)=>$q->limit($request->length));

            ///$qry=$qry->where('status','!=',2);
            $data['data']=$qry->orderByDesc('id')->get();

            return Helper::success($data, $message=__('translation.record_found'));

        } catch (ValidationException $validationException) {
            return Helper::errorWithData($validationException->errors()->first(), $validationException->errors());
        } catch (\Exception $e) {
            return Helper::errorWithData($e->getMessage(),[]);
        }

    }
    public function offLoadingSave($request,$id)
    {
        try {
            DB::beginTransaction();
            $validator = Validator::make($request->all(), [
                'order_checkin_id' => 'required',
                'order_id' => 'required',
            ]);

            if ($validator->fails())
                return Helper::errorWithData($validator->errors()->first(), $validator->errors());

            $offloading = OrderOffLoading::updateOrCreate(
                [
                    'order_check_in_id' => $id
                ],
                [
                    'order_id' =>$request->order_id,
                    'order_check_in_id' => $request->order_checkin_id,
                    'start_time' => now(),
                    'end_time' =>null,
                    'open_time' => now(),
                    'p_staged_location' => null,
                    'status_id' => 13,

                ]
            );
            $orderCheckIn = new CheckInRepositry();
            $orderCheckIn->changeStatus($offloading->order_check_in_id, 3);


            DB::commit();

            return Helper::success($offloading, $message="Off-Loading Start Successfully");

        } catch (ValidationException $validationException) {
            return Helper::errorWithData($validationException->errors()->first(), $validationException->errors());
        } catch (\Exception $e) {
            return Helper::errorWithData($e->getMessage(),[]);
        }

    }
    public function offLoadingUpdate($request,$id)
    {
        try {
            DB::beginTransaction();
            $validator = Validator::make($request->all(), [
                'id' => 'required',
                'order_id' => 'required',
            ]);

            if ($validator->fails())
                return Helper::errorWithData($validator->errors()->first(), $validator->errors());

            $offloading = OrderOffLoading::updateOrCreate(
                [
                    'id' => $id
                ],
                [
                    'order_id' =>$request->order_id,
                    'end_time' =>now(),
                    'status_id' => 14,
                ]
            );
            $orderCheckIn = new CheckInRepositry();
            $orderCheckIn->changeStatus($offloading->order_check_in_id, 10);


            DB::commit();

            return Helper::success($offloading, $message="Off-Loading Closed Successfully");

        } catch (ValidationException $validationException) {
            return Helper::errorWithData($validationException->errors()->first(), $validationException->errors());
        } catch (\Exception $e) {
            return Helper::errorWithData($e->getMessage(),[]);
        }

    }

    public function offLoadingImagesSave($request,$id)
    {
        try {
            DB::beginTransaction();

            if($request->product_staged_loc)
            {
                $offloading = OrderOffLoading::updateOrCreate(
                    [
                        'id' => $id,
                    ],
                    [
                        'p_staged_location' => $request->product_staged_loc,
                    ]
                );

            }

            $fileableId = $id;
            $fileableType = 'App\Models\OrderOffLoading';

            $imageSets = [
                'containerImages' => $request->file('containerImages', []),
                'sealImages' => $request->file('sealImages', []),
                'openTimeImages' => $request->file('openTimeImages', []),
                '1stHourImages' => $request->file('1stHourImages', []),
                '2ndHourImages' => $request->file('2ndHourImages', []),
                '3rdHourImages' => $request->file('3rdHourImages', []),
                '4thHourImages' => $request->file('4thHourImages', []),
                '5thHourImages' => $request->file('5thHourImages', []),
                '6thHourImages' => $request->file('6thHourImages', []),
                '7thHourImages' => $request->file('7thHourImages', []),
                '8thHourImages' => $request->file('8thHourImages', []),
                'productStagedLocImages' => $request->file('productStagedLocImages', []),
                'singedOffLoadingSlipImages' => $request->file('singedOffLoadingSlipImages', []),
                'palletsImages' => $request->file('palletsImages', []),
            ];

            $media =  Helper::uploadMultipleMedia($imageSets,$fileableId,$fileableType,$this->offLoadingFilePath);

            DB::commit();

            return Helper::success($media, $message="Images Uploaded Successfully");

        } catch (\Exception $e) {
            return Helper::errorWithData($e->getMessage(),[]);
        }

    }

    public function checkOrderCheckInId($request)
    {
        try {
                $validator = Validator::make($request->all(), [
                    'order_checkin_id' => 'required',
                ]);

                if ($validator->fails())
                    return Helper::errorWithData($validator->errors()->first(), $validator->errors());

            $orderCheckinId = $request->order_checkin_id;
            $res = OrderOffLoading::with('filemedia')->where('order_check_in_id', $orderCheckinId)->first();
            return Helper::success($res, $message='Record found');

        }  catch (\Exception $e) {
            return Helper::errorWithData($e->getMessage(),[]);
        }
    }


    public function findOffloadingByCheckInId($orderCheckinId)
    {
        try {
            $res = OrderOffLoading::with('checkin', 'order.packgingList.inventory','order.packgingList.filemedia', 'order.dock.loadType.eqType')->where('order_check_in_id', $orderCheckinId)->first();
            return Helper::success($res, $message = 'Record found');
        }  catch (\Exception $e) {
            return Helper::errorWithData($e->getMessage(), []);
        }
    }

    public function getOffLoadingListForPutAway($request)
    {
        try {

            $data['totalRecords'] = OrderOffLoading::count();
            $qry = OrderOffLoading::query();
            $qry = $qry->with('order:id,order_id','orderCheckIn:id,container_no','status:id,status_title,class_name,text_class');
            $qry=$qry->when($request->start, fn($q)=>$q->offset($request->start));
            $qry=$qry->when($request->length, fn($q)=>$q->limit($request->length));
            $data['data']=$qry->orderByDesc('id')->get();

            return Helper::success($data, $message=__('translation.record_found'));


        }  catch (\Exception $e) {
            return Helper::errorWithData($e->getMessage(),[]);
        }

    }


        public function getOffLoadingInfo($id)
    {
        try {

            $qry = OrderOffLoading::query();
            $qry = $qry->with('orderCheckIn.orderContact:id,arrival_time','order.loadType.transMode');
            $data=$qry->find($id);
            return Helper::success($data, $message=__('translation.record_found'));


        }  catch (\Exception $e) {
            return Helper::errorWithData($e->getMessage(),[]);
        }

    }


}





