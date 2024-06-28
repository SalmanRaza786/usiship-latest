<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Helper;
use App\Models\OrderItemPutAway;
use App\Models\PackgingList;
use App\Repositries\inventory\InventoryInterface;
use App\Repositries\offLoading\OffLoadingInterface;
use App\Repositries\packagingList\PackagingListInterface;
use App\Repositries\putaway\PutAwayInterface;
use App\Repositries\wh\WhInterface;
use Illuminate\Http\Request;

class PutAwayController extends Controller
{
    private $putAway;
    private $offLoading;
    private $wh;
    private $inventory;
    private $packging;
    public function __construct(PutAwayInterface $putAway,OffLoadingInterface $offLoading,WhInterface $wh,InventoryInterface $inventory,PackagingListInterface $packging) {
        $this->putAway = $putAway;
        $this->offLoading = $offLoading;
        $this->wh = $wh;
        $this->inventory =$inventory;
        $this->packging =$packging;
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
         $request->all();
           return $this->putAway->updateOrCreatePutAway($request);
        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }

    }

    //deletePutAwayItem
    public function deletePutAwayItem($id)
    {
        try {
            if(!OrderItemPutAway::find($id)){
                return Helper::error('Invalid id',[]);
            }
            $res = $this->putAway->deletePutAway($id);
            return Helper::ajaxSuccess($res->get('data'),$res->get('message'));
        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }
    }
    //checkPutAwayStatus
    public function checkPutAwayStatus($offLoadingId,$orderId)
    {
        try {

            $res=Helper::fetchOnlyData($this->packging->getPackgeingListEachQty($orderId));
              $itemList=collect([]);
              foreach ($res as $row){

                    $putAwayQty = Helper::fetchOnlyData($this->putAway->checkPutAwayStatus($offLoadingId,$row->inventory_id));

                  $data=array(
                      'item_name'=>$row->inventory->item_name,
                      'sku'=>$row->inventory->sku,
                      'put_away_qty'=>$putAwayQty,
                      'packgingQty'=>$row->qty_received_each,
                      'pending'=>$row->qty_received_each - $putAwayQty,
                  );
                  $itemList->push($data);
              }

            return Helper::success($itemList,'Putaway items list');
        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }
    }
}
