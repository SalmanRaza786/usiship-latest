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

            $data['totalRecords'] = OrderContacts::whereHas('order', function($query) use ($request){
                $query->where('order_type',$request->order_type);
            })->count();

            $qry = OrderContacts::query();
            $qry =$qry->with('carrier','order.dock.loadType.eqType','status');
         $qry = $qry->whereHas('order', function($query) use ($request){
            $query->where('order_type',$request->order_type);
         });

            $qry=$qry->when($request->s_name, function ($query, $name) {

                return $query->whereRelation('order','value', 'LIKE', "%{$name}%")
                    ->orWhereRelation('carrier','value', 'LIKE', "%{$name}%");
            });
            $qry=$qry->when($request->s_status, function ($query, $status) {
                return $query->where('status_id',$status);
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

    public function getAllOrderContactList($limit=null)
    {
        try {
            $qry= OrderContacts::query();
            $qry =$qry->with('filemedia','carrier.docimages','carrier.company','order.dock.loadType.eqType','status');
            $qry =$qry->where('status_id','=',9);
            $qry =$qry->orderByDesc('id');
            ($limit!=null)?$qry->take($limit):'';
            $data=$qry->get();
            return Helper::success($data, $message="Record found");
        } catch (\Exception $e) {
            return Helper::errorWithData($e->getMessage(),[]);
        }

    }
    public function getOrderContact($contactId)
    {
        try {

            $qry= OrderContacts::query();
            $qry =$qry->with('filemedia','carrier.docimages','carrier.company','order.dock.loadType.eqType','status');
            $data =$qry->find($contactId);
            return Helper::success($data, $message="Record found");
        } catch (\Exception $e) {
            return Helper::errorWithData($e->getMessage(),[]);
        }

    }

    public function updateOrderContact($id)
    {
        try {


            $orderContact = OrderContacts::updateOrCreate(
                [
                    'id' => $id
                ],
                [
                    'is_verify' => '1'
                ]
            );

            return Helper::success($orderContact, $message="Carrier Documents Approved Successfully");

        } catch (ValidationException $validationException) {
            return Helper::errorWithData($validationException->errors()->first(), $validationException->errors());
        } catch (\Exception $e) {
            return Helper::errorWithData($e->getMessage(),[]);
        }

    }





}





