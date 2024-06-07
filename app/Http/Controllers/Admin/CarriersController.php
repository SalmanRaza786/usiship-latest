<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Helper;
use App\Models\Carriers;
use App\Models\Company;
use App\Models\Order;
use App\Repositries\appointment\AppointmentInterface;
use App\Repositries\carriers\CarriersInterface;
use App\Repositries\companies\CompaniesInterface;
use App\Repositries\customField\CustomFieldInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class CarriersController extends Controller
{
    private $carriers;
    private $companies;
    private $order;

    public function __construct(CarriersInterface $carriers, CompaniesInterface $companies,AppointmentInterface $order) {
        $this->carriers = $carriers;
        $this->companies = $companies;
        $this->order = $order;
    }
    public function index(){
        try {
            $data['companies'] = $this->companies->getAllCompanies();
            return view('admin.carriers.index', compact('data'));
        }catch (\Exception $e) {
            return redirect()->back()->with('error',$e->getMessage());
        }
    }

    public function carrierOnboard($id)
    {
        try {
            //$decryptedId = Crypt::decryptString($id);
            $order = Order::find($id);
            if($order)
            {
                return view('carrier.carrier-onboard')->with(compact('order'));

            }else{
                return "Invalid Order Id";
            }

        }catch (\Exception $e) {
            return redirect()->back()->with('error',$e->getMessage());
        }
    }


    public function getCompanies()
    {
        try {

            $var = Company::get();
            return json_encode($var);
        }catch (\Exception $e) {
            return redirect()->back()->with('error',$e->getMessage());

        }

    }

    //loadCreateOrUpdate

    public function carriersCreateOrUpdate(Request $request)
    {

        try {

            $roleUpdateOrCreate = $this->carriers->CarriersSave($request,$request->id);
            if ($roleUpdateOrCreate->get('status'))
                return Helper::ajaxSuccess($roleUpdateOrCreate->get('data'),$roleUpdateOrCreate->get('message'));
            return Helper::ajaxErrorWithData($roleUpdateOrCreate->get('message'), $roleUpdateOrCreate->get('data'));
        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }

    }
    public function saveCarrierInfo(Request $request)
    {
        try {
            $roleUpdateOrCreate = $this->carriers->CarriersSaveInfo($request,$request->id);
            if ($roleUpdateOrCreate->get('status')){
                $order= $this->order->changeOrderStatus($request->order_id,9);
                if($order->get('status')){
                    $data=$order->get('data');
                    $notification= $this->order->sendNotification($data->id,$data->customer_id,9,1);
                    if($notification->get('status')){
                        Helper::notificationTriggerHelper(1);

                    }
                }

                return Helper::ajaxSuccess($roleUpdateOrCreate->get('data'),$roleUpdateOrCreate->get('message'));
            }
            return Helper::ajaxErrorWithData($roleUpdateOrCreate->get('message'), $roleUpdateOrCreate->get('data'));
        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }

    }
    public function carriersList(Request $request){
        try {
            $res=$this->carriers->carriersList($request);
            return Helper::ajaxDatatable($res['data']['data'], $res['data']['totalRecords'], $request);
        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }

    }
    public function destroy($id)
    {

        try {
            $res = $this->carriers->deletecarriers($id);
            return Helper::ajaxSuccess($res->get('data'),$res->get('message'));
        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }
    }
    public function edit($id)
    {
        try {
            $data['companies'] = $this->companies->getAllCompanies();
            $res= $this->carriers->editCarriers($id);
            if($res->get('data')){
                $data['load']=$res->get('data');
                return Helper::ajaxSuccess($data,$res->get('message'));
            }else{
                return Helper::ajaxError('Record not found');
            }
        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }
    }
}
