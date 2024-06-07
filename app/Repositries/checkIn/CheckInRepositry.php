<?php
namespace App\Repositries\checkIn;

use App\Http\Helpers\Helper;

use App\Models\Admin;
use App\Models\LoadType;
use App\Models\OrderCheckIn;
use App\Models\OrderContacts;
use App\Models\WareHouse;
use App\Models\WhDock;
use App\Traits\HandleFiles;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use DataTables;


class CheckInRepositry implements CheckInInterface {
    protected $checkInFilePath = 'checkin-media/';
    use HandleFiles;
    public function getCheckinList($request)
    {
        try {

                $data['totalRecords'] = OrderCheckIn::count();


            $qry = OrderCheckIn::query();
          //  $qry =$qry->with('carrier','order');

//            $qry=$qry->when($request->s_name, function ($query, $name) {
//
//                return $query->whereRelation('carrier','value', 'LIKE', "%{$name}%")
//                    ->orWhereRelation('order','value', 'LIKE', "%{$name}%");
//
//            });


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
                    'order_contact_id' => $request->order_contact_id,
                    'container_no' => $request->container_no,
                    'seal_no' => $request->seal_no,
                    'delivery_order_signature' => $request->do_signature,
                    'other_document' => $request->other_doc,
                    'status_id' => 14,

                ]
            );
            if($checkin)
            {
                $fileableId = $checkin->id;
                $fileableType = 'App\Model\OrderCheckIn';

                $imageSets = [
                    'containerImages' => $request->file('containerImages', []),
                    'sealImages' => $request->file('sealImages', []),
                    'do_signatureImages' => $request->file('do_signatureImages', []),
                    'other_docImages' => $request->file('other_docImages', []),
                ];

                $media =  Helper::uploadMultipleMedia($imageSets,$fileableId,$fileableType,$this->checkInFilePath);

            }

            DB::commit();

            return Helper::success($checkin, $message=__('translation.record_created'));

        } catch (ValidationException $validationException) {
            return Helper::errorWithData($validationException->errors()->first(), $validationException->errors());
        } catch (\Exception $e) {
            return Helper::errorWithData($e->getMessage(),[]);
        }

    }

}





