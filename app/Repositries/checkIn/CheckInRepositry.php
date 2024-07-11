<?php
namespace App\Repositries\checkIn;

use App\Http\Helpers\Helper;

use App\Models\Admin;
use App\Models\LoadType;
use App\Models\OrderCheckIn;
use App\Models\OrderContacts;
use App\Models\WareHouse;
use App\Models\WhDock;
use App\Repositries\appointment\AppointmentRepositry;
use App\Repositries\orderContact\OrderContactRepositry;
use App\Traits\HandleFiles;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use DataTables;
use function Symfony\Component\Translation\t;


class CheckInRepositry implements CheckInInterface {
    protected $checkInFilePath = 'checkin-media/';
    use HandleFiles;
    public function getCheckinList($request)
    {
        try {

            $data['totalRecords'] = OrderCheckIn::count();

            $qry = OrderCheckIn::query();
            $qry =$qry->with('orderContact','order.dock.loadType.eqType','status');

            $qry=$qry->when($request->s_name, function ($query, $name) {
                return $query->whereRelation('order','order_id', 'LIKE', "%{$name}%");
            });
            $qry=$qry->when($request->s_status, function ($query, $status) {
                return $query->where('status_id',$status);
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
    public function checkinSave($request,$id)
    {

        try {
            DB::beginTransaction();
            $validator = Validator::make($request->all(), [
                'order_contact_id' => 'required',
                'order_id' => 'required',
                'whDoors' => 'required',
                'container_no' => 'required',
                'seal_no' => 'required',
                'do_signature' => 'required',
            ]);

            if ($validator->fails())
                return Helper::errorWithData($validator->errors()->first(), $validator->errors());



            $checkin = OrderCheckIn::updateOrCreate(
                [
                    'order_contact_id' => $id
                ],
                [
                    'order_id' =>$request->order_id,
                    'door_id' =>$request->whDoors,
                    'order_contact_id' => $request->order_contact_id,
                    'container_no' => $request->container_no,
                    'seal_no' => $request->seal_no,
                    'delivery_order_signature' => $request->do_signature,
                    'other_document' => $request->other_doc,
                    'status_id' => 12,

                ]
            );
            if($checkin)
            {
                $fileableId = $checkin->id;
                $fileableType = 'App\Models\OrderCheckIn';

                $imageSets = [
                    'containerImages' => $request->file('containerImages', []),
                    'sealImages' => $request->file('sealImages', []),
                    'do_signatureImages' => $request->file('do_signatureImages', []),
                    'other_docImages' => $request->file('other_docImages', []),
                ];

                $media =  Helper::uploadMultipleMedia($imageSets,$fileableId,$fileableType,$this->checkInFilePath);

                $orderContact = new OrderContactRepositry();
                $orderContact->changeStatus($checkin->order_contact_id, 12);

            }

            DB::commit();

            return Helper::success($checkin, $message=__('translation.record_created'));

        } catch (ValidationException $validationException) {
            return Helper::errorWithData($validationException->errors()->first(), $validationException->errors());
        } catch (\Exception $e) {
            return Helper::errorWithData($e->getMessage(),[]);
        }

    }
    public function findCheckIn($id)
    {
        try {
            $qry= OrderCheckIn::query();
            $qry= $qry->with('orderContact','order.dock.loadType.eqType','status','door');
            $data =$qry->where('id',$id)->first();
            return Helper::success($data, $message="Record found");
        } catch (\Exception $e) {
            return Helper::errorWithData($e->getMessage(),[]);
        }
    }
    public function changeStatus($id,$status)
    {
        try {
            $order= OrderCheckIn::find($id);
            $order->status_id = $status;
            $order->save();
            return Helper::success($order,'Status updated');
        } catch (\Exception $e) {
            return Helper::errorWithData($e->getMessage(),[]);

        }
    }
    public function getOrderCheckinList($limit=null)
    {
        try {
            $qry= OrderCheckIn::query();
            $qry= $qry->with('orderContact','order.dock.loadType.eqType','status','door');
            $qry =$qry->where('status_id','!=',10);
            ($limit!=null)?$qry->take($limit):'';
            $qry =$qry->orderByDesc('id');
            $data =$qry->get();
            return Helper::success($data, $message="Record found");
        } catch (\Exception $e) {
            return Helper::errorWithData($e->getMessage(),[]);
        }
    }

}





