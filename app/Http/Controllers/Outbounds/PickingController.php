<?php

namespace App\Http\Controllers\Outbounds;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Helper;
use App\Repositries\picking\PickingInterface;
use App\Repositries\workOrder\WorkOrderInterface;
use Illuminate\Http\Request;

class PickingController extends Controller
{

    private $workOrder;
    private $picking;
    public function __construct(WorkOrderInterface $workOrder,PickingInterface $picking) {
        $this->workOrder =$workOrder;
        $this->picking =$picking;
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
    public function startPicking()
    {
        try {
            return view('admin.outbounds.picking.start-picking');
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
}
