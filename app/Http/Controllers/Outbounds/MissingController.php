<?php

namespace App\Http\Controllers\Outbounds;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Helper;
use App\Repositries\missing\MissingInterface;
use App\Repositries\wh\WhInterface;
use Illuminate\Http\Request;

class MissingController extends Controller
{
    private $missed;
    private $wh;
    public function __construct(MissingInterface $missed,WhInterface $wh) {
        $this->missed =$missed;
        $this->wh =$wh;
    }

    public function index()
    {
        try {
            return view('admin.outbounds.missing.index');
        }catch (\Exception $e) {
            return redirect()->back()->with('error',$e->getMessage());

        }

    }

    public function missedList(Request $request)
    {

        try {
            $res=$this->missed->getAllMissing($request);
            return Helper::ajaxDatatable($res['data']['data'], $res['data']['totalRecords'],$request);
        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }
    }

    public function missedDetail($id)
    {
        try {
            return $id;
            $data['orderInfo']=Helper::fetchOnlyData($this->picking->getPickerInfo($id));
            $data['pickingItems']=Helper::fetchOnlyData($this->picking->getPickingItems($id));
            $data['locations']=Helper::fetchOnlyData($this->wh->getWhLocations());
            return view('admin.outbounds.missing.missing-detail')->with(compact('data'));
        }catch (\Exception $e) {
            return redirect()->back()->with('error',$e->getMessage());

        }

    }
}