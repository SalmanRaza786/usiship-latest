<?php

namespace App\Http\Controllers\Outbounds;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Helper;
use App\Repositries\missing\MissingInterface;
use App\Repositries\qc\QcInterface;
use App\Repositries\wh\WhInterface;
use Illuminate\Http\Request;

class QcController extends Controller
{
    private $missed;
    private $wh;
    private $qc;
    public function __construct(MissingInterface $missed,WhInterface $wh,QcInterface $qc) {
        $this->missed =$missed;
        $this->wh =$wh;
        $this->qc =$qc;
    }

    public function index()
    {
        try {
            return view('admin.outbounds.qc.index');
        }catch (\Exception $e) {
            return redirect()->back()->with('error',$e->getMessage());
        }

    }
    public function qcDetail($id)
    {
        try {

            $data['orderInfo']=Helper::fetchOnlyData($this->qc->getMissedInfo($id));
            $data['qcItems']=Helper::fetchOnlyData($this->qc->getQcItems($id));
            $data['locations']=Helper::fetchOnlyData($this->wh->getWhLocations());
            return view('admin.outbounds.qc.qc-detail')->with(compact('data'));
        }catch (\Exception $e) {
        return    $e->getMessage();
            return redirect()->back()->with('error',$e->getMessage());

        }

    }
    public function QcList(Request $request)
    {

        try {
            $res=$this->qc->getQcList($request);
            return Helper::ajaxDatatable($res['data']['data'], $res['data']['totalRecords'],$request);
        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }
    }
    public function saveQc(Request $request)
    {

        try {
            $request->all();
            return $res=$this->qc->saveQcItems($request);

        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }
    }
}
