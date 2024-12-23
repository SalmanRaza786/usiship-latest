<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Helper;
use App\Repositries\appointment\AppointmentInterface;
use App\Repositries\customer\CustomerInterface;
use App\Repositries\customerCompanies\CustomerCompaniesInterface;
use App\Repositries\inventory\InventoryInterface;
use App\Repositries\notification\NotificationInterface;
use App\Repositries\putaway\PutAwayInterface;
use App\Repositries\qc\QcInterface;
use App\Repositries\wh\WhInterface;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    private $order;
    private $wh;
    private $customer;
    private $appointment;
    private $notification;
    private $WorkOrderQC;
    private $putAway;
    private $inventory;

    public function __construct(AppointmentInterface $order,WhInterface $wh,CustomerCompaniesInterface $customer,AppointmentInterface $appointment,NotificationInterface $notification,QcInterface $WorkOrderQC,PutAwayInterface $putAway,InventoryInterface $inventory){
        $this->order = $order;
        $this->wh = $wh;
        $this->customer =$customer;
        $this->appointment =$appointment;
        $this->notification =$notification;
        $this->WorkOrderQC =$WorkOrderQC;
        $this->putAway =$putAway;
        $this->inventory =$inventory;
    }
    public function outboundIndex()
    {
        try {
            $data['status']=Helper::fetchOnlyData($this->order->getAllStatus());
            $data['locations']=Helper::fetchOnlyData($this->wh->getWhLocations(1));
            $data['inventory']=Helper::fetchOnlyData($this->inventory->getAllItems());
            $data['customers']=Helper::fetchOnlyData($this->customer->getAllCompanies());
            $data['status']=Helper::fetchOnlyData($this->order->getAllStatus());
            return view('admin.reports.outbound-report')->with(compact('data'));
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    public function inboundIndex()
    {
        try {
            $data['status']=Helper::fetchOnlyData($this->order->getAllStatus());
            $data['locations']=Helper::fetchOnlyData($this->wh->getWhLocations(1));
            $data['inventory']=Helper::fetchOnlyData($this->inventory->getAllItems());
            $data['customers']=Helper::fetchOnlyData($this->customer->getAllCompanies());
            return view('admin.reports.inbound-report')->with(compact('data'));
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function outboundReportList(Request $request){
        try {
            $res=$this->WorkOrderQC->outboundReportList($request);
            return Helper::ajaxDatatable($res['data']['data'], $res['data']['totalRecords'], $request);
        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }

    }
    public function inboundReportList(Request $request){
        try {
            $res=$this->putAway->inboundReportList($request);
            return Helper::ajaxDatatable($res['data']['data'], $res['data']['totalRecords'], $request);
        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }
    }


}
