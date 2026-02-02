<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Helper;
use App\Models\User;
use App\Repositries\appointment\AppointmentInterface;
use App\Repositries\appSettings\AppSettingsInterface;
use App\Repositries\checkIn\CheckInInterface;
use App\Repositries\customer\CustomerInterface;
use App\Repositries\missing\MissingInterface;
use App\Repositries\offLoading\OffLoadingInterface;
use App\Repositries\orderContact\OrderContactInterface;
use App\Repositries\picking\PickingInterface;
use App\Repositries\processing\ProcessingInterface;
use App\Repositries\qc\QcInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{

    private $appSetting;
    private $orderContact;
    private $checkIn;
    private $offLoading;
    private $appointment;
    private $picking;
    private $qc;
    private $processing;
    private $missing;
    private $customer;


    public function __construct(AppSettingsInterface $appSetting, OrderContactInterface $orderContact,CheckInInterface $checkIn,OffLoadingInterface $offLoading,AppointmentInterface $appointment, PickingInterface $picking, QcInterface $qc, ProcessingInterface $processing, MissingInterface $missing,CustomerInterface $customer) {
        $this->appSetting = $appSetting;
        $this->orderContact = $orderContact;
        $this->checkIn = $checkIn;
        $this->offLoading = $offLoading;
        $this->appointment = $appointment;
        $this->picking = $picking;
        $this->qc = $qc;
        $this->processing = $processing;
        $this->missing = $missing;
        $this->customer = $customer;

    }
    //appSetting
    public function appSetting(Request $request){
        try {

            $res = $this->appSetting->getAppSettings($request);
            if($res->get('status')){
                return  Helper::createAPIResponce(false,200,'App Setting',$res->get('data'));
            }else{
                return  Helper::createAPIResponce(false,200,'App Setting list empty',$res->get('data'));
            }

        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }

    }
    public function adminHome(Request $request){
        try {

            $data=[];
              $data['checkIn'] = Helper::fetchOnlyData($this->orderContact->getAllOrderContactList($request->limit));
              $data['outboundOnLoading'] = Helper::fetchOnlyData($this->checkIn->getOutboundCheckinList($request->limit));
              $data['offLoading'] = Helper::fetchOnlyData($this->checkIn->getOrderCheckinList($request->limit));
              $data['outboundCheckIn'] = Helper::fetchOnlyData($this->checkIn->getOutboundCheckinList($request->limit));
              $data['picking'] = Helper::fetchOnlyData($this->picking->getAllPickersList($request->limit));
              $data['qc'] = Helper::fetchOnlyData($this->qc->getAllQcList($request->limit));
              $data['processing'] = Helper::fetchOnlyData($this->processing->getAllProcessList($request->limit));
              $data['missing'] = Helper::fetchOnlyData($this->missing->getAllMissingList($request->limit));
              $res = Helper::fetchOnlyData($this->offLoading->getOffLoadingListForPutAwayApi($request->limit));
              $data['itemPutaway'] =$res['data'];

              return  Helper::createAPIResponce(false,200,'Admin home',$data);
        } catch (\Exception $e) {
            return    Helper::createAPIResponce(false,200,$e->getMessage(),[]);
        }

    }

    public function customerHome(Request $request){
        try {
            $validator = Validator::make($request->all(), [
                'customer_id' => 'required',
            ]);
            if ($validator->fails()){
                return  Helper::createAPIResponce(true,400,$validator->errors()->first(),$validator->errors());
            }

            if (!User::find($request->customer_id)) {
                return  Helper::createAPIResponce(true,400,'Invalid customer id',[]);
            }

            $data=[];
            return  $data['myOrders'] = Helper::fetchOnlyData($this->appointment->getMyAppointmentsForApi($request->customer_id,$request->limit));

            return  Helper::createAPIResponce(false,200,'Admin home',$data);
        } catch (\Exception $e) {
            return    Helper::createAPIResponce(false,200,$e->getMessage(),[]);
        }

    }

    public function customersList(){
        try {
            $res = $this->customer->getAllCustomers();
            if($res->get('status')){
                return  Helper::createAPIResponce(false,200,'Customers List',$res->get('data'));
            }else{
                return  Helper::createAPIResponce(false,200,'Customers list empty',$res->get('data'));
            }
        } catch (\Exception $e) {
            return  Helper::createAPIResponce(true,400,$e->getMessage(),[]);
        }

    }


}
