<?php

namespace App\Http\Controllers\Outbounds;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Helper;
use App\Repositries\missing\MissingInterface;
use App\Repositries\wh\WhInterface;
use Illuminate\Http\Request;

class QcController extends Controller
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
            return view('admin.outbounds.qc.index');
        }catch (\Exception $e) {
            return redirect()->back()->with('error',$e->getMessage());
        }

    }

    public function qcDetail($id)
    {
        try {

            $data['orderInfo']=Helper::fetchOnlyData($this->missed->getMissedInfo($id));
            $data['missedItems']=Helper::fetchOnlyData($this->missed->getMissedItems($id));
            $data['locations']=Helper::fetchOnlyData($this->wh->getWhLocations());
            return view('admin.outbounds.qc.qc-detail')->with(compact('data'));
        }catch (\Exception $e) {
        return    $e->getMessage();
            return redirect()->back()->with('error',$e->getMessage());

        }

    }
}
