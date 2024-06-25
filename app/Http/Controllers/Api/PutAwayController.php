<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Helper;
use App\Models\OrderItemPutAway;
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
        public function storePutAway(Request $request){
        try {
            $request->all();
            return $this->putAway->updateOrCreatePutAway($request);
        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }

    }
        public function createPutAway($offLoadingId){
        try {

            $data['offLoadingInfo']=Helper::fetchOnlyData($this->offLoading->getOffLoadingInfo($offLoadingId));
            $data['locations']=Helper::fetchOnlyData($this->wh->getWhLocations($data['offLoadingInfo']->order->wh_id));
            $data['inventory']=Helper::fetchOnlyData($this->inventory->getAllItems());
            $data['putAwayItems']=Helper::fetchOnlyData($this->putAway->getPutAwayItemsAccordingOffLoading($offLoadingId));
            return Helper::success($data,'Putaway items');
        }catch (\Exception $e) {
            return redirect()->back()->with('error',$e->getMessage());
        }
    }
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
        public function checkPutAwayStatus($offLoadingId)
        {
            try {

                $res = Helper::fetchOnlyData($this->putAway->checkPutAwayStatus($offLoadingId));

                $itemList=collect([]);
                foreach ($res as $row){
                    $packgingQty= $this->packging->getRecvQty($row->order_id,$row->inventory_id);

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
        public function putAwayList(Request $request){
        try {
            $res=$this->offLoading->getOffLoadingListForPutAway($request);
            return Helper::ajaxDatatable($res['data']['data'], $res['data']['totalRecords'], $request);
        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }

    }
}
