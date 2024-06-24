<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Helper;
use App\Models\PackgingList;
use App\Repositries\inventory\InventoryInterface;
use App\Repositries\offLoading\OffLoadingInterface;
use App\Repositries\putaway\PutAwayInterface;
use App\Repositries\wh\WhInterface;
use Illuminate\Http\Request;

class PutAwayController extends Controller
{
    private $putAway;
    private $offLoading;
    private $wh;
    private $inventory;
    public function __construct(PutAwayInterface $putAway,OffLoadingInterface $offLoading,WhInterface $wh,InventoryInterface $inventory) {
        $this->putAway = $putAway;
        $this->offLoading = $offLoading;
        $this->wh = $wh;
        $this->inventory =$inventory;
    }

    public function index(){
        try {
            return view('admin.putaway.index');
        }catch (\Exception $e) {
            return redirect()->back()->with('error',$e->getMessage());
        }
    }

    //createPutAway
    public function createPutAway($offLoadingId){
        try {
             $data['offLoadingInfo']=Helper::fetchOnlyData($this->offLoading->getOffLoadingInfo($offLoadingId));
             $data['locations']=Helper::fetchOnlyData($this->wh->getWhLocations($data['offLoadingInfo']->order->wh_id));
             $data['inventory']=Helper::fetchOnlyData($this->inventory->getAllItems());
             $data['putAwayItems']=Helper::fetchOnlyData($this->putAway->getPutAwayItemsAccordingOffLoading($offLoadingId));
            return view('admin.putaway.create')->with(compact('data'));
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

    //storePutAway
    public function storePutAway(Request $request){
        try {

           return $this->putAway->updateOrCreatePutAway($request);
        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }

    }

    //deletePutAwayItem
    public function deletePutAwayItem($id)
    {
        try {
            $res = $this->putAway->deletePutAway($id);
            return Helper::ajaxSuccess($res->get('data'),$res->get('message'));
        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }
    }
    //checkPutAwayStatus
    public function checkPutAwayStatus($offLoadingId)
    {
        try {
              $res = Helper::fetchOnlyData($this->putAway->checkPutAwayStatus($offLoadingId));
              $itemList=collect([]);
              foreach ($res as $row){
                $packgingQty= PackgingList::where('inventory_id',$row->inventory_id)->where('order_id',$row->order_id)->sum('qty_received_each');

                  $data=array(
                      'item_name'=>$row->inventory->item_name,
                      'sku'=>$row->inventory->sku,
                      'put_away_qty'=>$row->qty,
                      'packgingQty'=>$packgingQty,
                      'pending'=>$packgingQty - $row->qty,
                  );
                  $itemList->push($data);
              }

            return Helper::success($itemList,'Putaway items list');
        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }
    }
}
