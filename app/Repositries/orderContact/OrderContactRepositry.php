<?php
namespace App\Repositries\orderContact;

use App\Http\Helpers\Helper;

use App\Models\Admin;
use App\Models\LoadType;
use App\Models\OrderContacts;
use App\Models\WareHouse;
use App\Models\WhDock;
use App\Repositries\orderContact\OrderContactInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use DataTables;


class OrderContactRepositry implements OrderContactInterface {

    public function getOrderContactList($request)
    {
        try {

            $data['totalRecords'] = OrderContacts::count();

            $qry = OrderContacts::query();
            $qry =$qry->with('carrier','order.dock.loadType.eqType','status');
            $qry =$qry->where('status_id','!=',12);

            $qry=$qry->when($request->s_name, function ($query, $name) {

                return $query->whereRelation('order','value', 'LIKE', "%{$name}%")
                    ->orWhereRelation('carrier','value', 'LIKE', "%{$name}%");
            });
            $qry=$qry->when($request->s_status, function ($query, $status) {
                return $query->where('status',$status);
            });
            $qry=$qry->when($request->start, fn($q)=>$q->offset($request->start));
            $qry=$qry->when($request->length, fn($q)=>$q->limit($request->length));

            $data['data']=$qry->orderByDesc('id')->get();


            return Helper::success($data, $message=__('translation.record_found'));

        } catch (ValidationException $validationException) {
            return Helper::errorWithData($validationException->errors()->first(), $validationException->errors());
        } catch (\Exception $e) {
            return Helper::errorWithData($e->getMessage(),[]);
        }

    }

    public function orderContactSave($request,$id)
    {
        try {
            DB::beginTransaction();
            $validator = Validator::make($request->all(), [
                'direction' => 'required',
                'operation' => 'required',
                'equipment_type' => 'required',
                'trans_mode' => 'required',
                'duration' => 'required',
                'status' => 'required',
            ]);


            if ($validator->fails())
                return Helper::errorWithData($validator->errors()->first(), $validator->errors());

            $load = LoadType::updateOrCreate(
                [
                    'id' => $id
                ],
                [
                    'wh_id' =>$request->hidden_wh_id_load_type?$request->hidden_wh_id_load_type:null,
                    'direction_id' => $request->direction,
                    'operation_id' => $request->operation,
                    'equipment_type_id' => $request->equipment_type,
                    'trans_mode_id' => $request->trans_mode,
                    'duration' => $request->duration,
                    'status' => $request->status,

                ]
            );

            ($id==0)?$message = __('translation.record_created'): $message =__('translation.record_updated');
            DB::commit();


            return Helper::success($load, $message);
        } catch (ValidationException $validationException) {
            DB::rollBack();
            return Helper::errorWithData($validationException->errors()->first(), $validationException->errors());
        } catch (\Exception $e) {
            DB::rollBack();
            return Helper::errorWithData($e->getMessage(),[]);
        }
    }

    public function changeStatus($id,$status)
    {
        try {
            $order= OrderContacts::find($id);
            $order->status_id = $status;
            $order->save();
            return Helper::success($order,'Status updated');
        } catch (\Exception $e) {
            return Helper::errorWithData($e->getMessage(),[]);

        }
    }

    public function getAllOrderContactList()
    {
        try {
            $qry= OrderContacts::query();
            $qry =$qry->with('carrier','order.dock.loadType.eqType','status');
            $data =$qry->orderByDesc('id')->get();
            return Helper::success($data, $message="Record found");
        } catch (\Exception $e) {
            return Helper::errorWithData($e->getMessage(),[]);
        }

    }
    public function getOrderContact($request)
    {
        try {
            $qry= OrderContacts::find($request->id);
            $qry =$qry->with('filemedia','carrier.docimages','carrier.company','order.dock.loadType.eqType','status');
            $data =$qry->orderByDesc('id')->first();
            return Helper::success($data, $message="Record found");
        } catch (\Exception $e) {
            return Helper::errorWithData($e->getMessage(),[]);
        }

    }

    public function updateOrderContact($request,$id)
    {
        try {
            DB::beginTransaction();
            $validator = Validator::make($request->all(), [
                'id' => 'required',
                'order_id' => 'required',
            ]);

            if ($validator->fails())
                return Helper::errorWithData($validator->errors()->first(), $validator->errors());

            $orderContact = OrderContacts::updateOrCreate(
                [
                    'id' => $id
                ],
                [
                    'is_verify' => '1'
                ]
            );

            DB::commit();

            return Helper::success($orderContact, $message="Carrier Documents Approved Successfully");

        } catch (ValidationException $validationException) {
            return Helper::errorWithData($validationException->errors()->first(), $validationException->errors());
        } catch (\Exception $e) {
            return Helper::errorWithData($e->getMessage(),[]);
        }

    }





}





