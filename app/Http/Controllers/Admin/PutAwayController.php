<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Helper;
use App\Repositries\offLoading\OffLoadingInterface;
use App\Repositries\putaway\PutAwayInterface;
use Illuminate\Http\Request;

class PutAwayController extends Controller
{
    private $putAway;
    private $offLoading;
    public function __construct(PutAwayInterface $putAway,OffLoadingInterface $offLoading) {
        $this->putAway = $putAway;
        $this->offLoading = $offLoading;
    }

    public function index(){
        try {
            return view('admin.putaway.index');
        }catch (\Exception $e) {
            return redirect()->back()->with('error',$e->getMessage());
        }
    }

    //createPutAway
    public function createPutAway(){
        try {
            return view('admin.putaway.create');
        }catch (\Exception $e) {
            return redirect()->back()->with('error',$e->getMessage());
        }
    }



    public function putAwayList(Request $request){
        try {
            $res=$this->offLoading->getOffLoadingListForPutAway($request);
            return Helper::ajaxDatatable($res['data']['data'], $res['data']['totalRecords'], $request);
        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }

    }
}
