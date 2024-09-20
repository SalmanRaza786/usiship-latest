<?php

namespace App\Http\Controllers\Outbounds;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Helper;
use App\Repositries\missing\MissingInterface;
use App\Repositries\processing\ProcessingInterface;
use App\Repositries\qc\QcInterface;
use App\Repositries\wh\WhInterface;
use Illuminate\Http\Request;

class ProcessingController extends Controller
{
    private $missed;
    private $wh;
    private $qc;
    public function __construct(MissingInterface $missed,WhInterface $wh,ProcessingInterface $qc) {
        $this->missed =$missed;
        $this->wh =$wh;
        $this->qc =$qc;
    }

    public function index()
    {
        try {
            return view('admin.outbounds.processing.index');
        }catch (\Exception $e) {
            return redirect()->back()->with('error',$e->getMessage());
        }

    }
    public function processDetail($id)
    {
        try {
            $data['orderInfo']=Helper::fetchOnlyData($this->qc->getProcessInfo($id));
            $data['processItems']=Helper::fetchOnlyData($this->qc->getProcessItems($id));
            return view('admin.outbounds.processing.processing-detail')->with(compact('data'));
        }catch (\Exception $e) {
            return    $e->getMessage();
            return redirect()->back()->with('error',$e->getMessage());

        }

    }
    public function getProcess($id)
    {
        try {

            $res = $this->qc->getProcessInfo($id);
             if($res->get('status')){
                 return Helper::ajaxSuccess($res->get('data'),"data found");
             }
            return Helper::ajaxSuccess([],"data not found");

        }catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());

        }

    }
    public function ProcessList(Request $request)
    {

        try {
            $res=$this->qc->getProcessList($request);
            return Helper::ajaxDatatable($res['data']['data'], $res['data']['totalRecords'],$request);
        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }
    }
    public function saveProcess(Request $request)
    {

        try {
            $request->all();
            return $res=$this->qc->createProcessItems($request);

        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }
    }
    public function saveProcessDetail(Request $request)
    {

        try {
             $request->all();
            return $res=$this->qc->createProcessItems($request);
        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }
    }
    public function updateProcessItem(Request $request)
    {

        try {
            $request->all();
            $res=$this->qc->updateProcessItems($request);
//             if($res->get('status')){
//                $response= $this->qc->updateStartQc($request);
//             }
            return Helper::ajaxSuccess($res->get('data'),$res->get('message'));

        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }
    }
    public function deleteProcessItem(Request $request)
    {
        try {
            $request->all();
            $res=$this->qc->deleteProcessItems($request);
            return Helper::ajaxSuccess($res->get('data'),$res->get('message'));
        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }
    }

    public function updateStartProcess(Request $request)
    {

        try {
            return  $res=$this->qc->updateStartProcess($request);
        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }
    }
}
