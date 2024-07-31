<?php

namespace App\Http\Controllers\Outbounds;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Helper;
use App\Repositries\picking\PickingInterface;
use App\Repositries\wh\WhInterface;
use App\Repositries\workOrder\WorkOrderInterface;
use Illuminate\Http\Request;
use PHPUnit\TextUI\Help;

class PickingController extends Controller
{

    private $workOrder;
    private $picking;
    private $wh;
    protected $pickedItemFilePath = 'picked-item-media/';
    public function __construct(WorkOrderInterface $workOrder,PickingInterface $picking,WhInterface $wh,) {
        $this->workOrder =$workOrder;
        $this->picking =$picking;
        $this->wh =$wh;
    }

    public function index()
    {
        try {
            return view('admin.outbounds.picking.index');
        }catch (\Exception $e) {
            return redirect()->back()->with('error',$e->getMessage());

        }

    }

    //startPicking
    public function startPicking($id)
    {
        try {
            $data['orderInfo']=Helper::fetchOnlyData($this->picking->getPickerInfo($id));
            $data['pickingItems']=Helper::fetchOnlyData($this->picking->getPickingItems($id));
            $data['locations']=Helper::fetchOnlyData($this->wh->getWhLocations());
            return view('admin.outbounds.picking.picking-detail')->with(compact('data'));
        }catch (\Exception $e) {
            return redirect()->back()->with('error',$e->getMessage());

        }

    }

    //pickerList
    public function pickerList(Request $request)
    {

        try {
            $res=$this->picking->getAllPickers($request);
            return Helper::ajaxDatatable($res['data']['data'], $res['data']['totalRecords'],$request);
        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }
    }

    //updateStartPicking
    public function updateStartPicking(Request $request)
    {

        try {
          return  $res=$this->picking->updateStartPicking($request);

        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }
    }

    //savePickedItems
    public function savePickedItems(Request $request)
    {

        try {
             $request->all();
        return $res=$this->picking->savePickedItems($request);

        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }
    }
}
