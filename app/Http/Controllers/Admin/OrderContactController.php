<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Helper;
use App\Repositries\checkIn\CheckInInterface;
use App\Repositries\orderContact\OrderContactInterface;
use Illuminate\Http\Request;

class OrderContactController extends Controller
{
    private $orderContact;

    public function __construct(OrderContactInterface $orderContact)
    {
        $this->orderContact = $orderContact;
    }

    public function orderContactList(Request $request){
        try {
            $res=$this->orderContact->getOrderContactList($request);
            return Helper::ajaxDatatable($res['data']['data'], $res['data']['totalRecords'], $request);
        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }
    }
    public function updateOrderContact(Request $request)
    {
        try {
            $roleUpdateOrCreate = $this->orderContact->updateOrderContact($request->id);
            if ($roleUpdateOrCreate->get('status'))
                return Helper::ajaxSuccess($roleUpdateOrCreate->get('data'),$roleUpdateOrCreate->get('message'));
            return Helper::ajaxErrorWithData($roleUpdateOrCreate->get('message'), $roleUpdateOrCreate->get('data'));
        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }
    }
    public function getOrderContactList()
    {
        try {
            $res = $this->orderContact->getAllOrderContactList();
            if ($res->get('status'))
            {
                return Helper::success($res->get('data'),'Order Contact list');
            }else{
                return Helper::error("Data not found");
            }

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }


    public function verifyCarrier($id)
    {
        try {

            session()->put('previous_url', url()->previous());

            $res = $this->orderContact->getOrderContact($id);
            if ($res->get('status'))
            {
                $contactRes=$res->get('data');
                $contactRes->carrier->docimages->where('field_name','driver_id_pic')->pluck('file_name')->first();
                  $data['orderContacts']=array(

                    'orderContactId'=>$contactRes->id,
                    'vehicle_number'=>$contactRes->vehicle_number,
                    'vehicle_licence_plate'=>$contactRes->vehicle_licence_plate,
                    'bol_number'=>$contactRes->bol_number,
                    'do_number'=>$contactRes->do_number,
                    'status_id'=>$contactRes->status_id,
                    'company_name'=>$contactRes->carrier->company->company_title,
                    'company_id'=>$contactRes->carrier->company->id,
                    'company_phone'=>$contactRes->carrier->company->contact,
                    'carrier_id'=>$contactRes->carrier->id,
                    'driver_name'=>$contactRes->carrier->carrier_company_name,
                    'driver_phone'=>$contactRes->carrier->contacts,
                    'bol_image'=>$contactRes->filemedia->where('field_name','bol_image')->pluck('file_name')->last(),
                    'bolFileId'=>count($contactRes->filemedia->where('field_name','bol_image'))?$contactRes->filemedia->where('field_name','bol_image')->pluck('id')->last():0,
                    'bol_thumbnail'=>$contactRes->filemedia->where('field_name','bol_image')->pluck('file_thumbnail')->last(),
                    'do_document'=>$contactRes->filemedia->where('field_name','do_document')->pluck('file_name')->last(),
                    'doFileId'=>count($contactRes->filemedia->where('field_name','do_document'))?$contactRes->filemedia->where('field_name','do_document')->pluck('id')->last():0,
                    'driver_id'=>$contactRes->carrier->docimages->where('field_name','driver_id_pic')->pluck('file_name')->last(),
                    'driverFileId'=>count($contactRes->carrier->docimages->where('field_name','driver_id_pic'))?$contactRes->carrier->docimages->where('field_name','driver_id_pic')->pluck('id')->last():0,
                    'driver_id_thumbnail'=>$contactRes->carrier->docimages->where('field_name','driver_id_pic')->pluck('file_thumbnail')->last(),
                    'other_docs'=>$contactRes->carrier->docimages->where('field_name','other_document')->pluck('file_name')->last(),
                      'otherDocFileId'=>count($contactRes->carrier->docimages->where('field_name','other_document'))?$contactRes->carrier->docimages->where('field_name','other_document')->pluck('id')->last():0,
                    'is_verify'=>$contactRes->is_verify,
                    'order_id'=>$contactRes->order_id,
                    'order_reference'=>$contactRes->order->order_id,
                );
            }

            return  view('admin.carriers.verify-carrier-docs')->with(compact('data'));
        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }
    }
}
