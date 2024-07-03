<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Helper;
use App\Models\OrderItemPutAway;
use App\Models\OrderOffLoading;
use App\Repositries\inventory\InventoryInterface;
use App\Repositries\offLoading\OffLoadingInterface;
use App\Repositries\packagingList\PackagingListInterface;
use App\Repositries\putaway\PutAwayInterface;
use App\Repositries\wh\WhInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
            $validator = Validator::make($request->all(), [
                'qty' => 'required',
            ]);
            if ($validator->fails()){
                return  Helper::createAPIResponce(true,400,$validator->errors()->first(),$validator->errors());
            }
            $res= $this->putAway->updateOrCreatePutAway($request);
            if($res['status']){
                return  Helper::createAPIResponce(true,200,'Record updated',$res['data']);
            }else{
                return  Helper::createAPIResponce(true,400,$res['message'],$res['data']);
            }
        } catch (\Exception $e) {
            return  Helper::createAPIResponce(true,400,$e->getMessage(),[]);
        }

    }
        public function createPutAway($offLoadingId){
        try {

            if(!OrderOffLoading::find($offLoadingId)){
                return  Helper::createAPIResponce(true,400,'invalid offloading id',[]);
            }

            $data['offLoadingInfo']=Helper::fetchOnlyData($this->offLoading->getOffLoadingInfo($offLoadingId));
            $data['locations']=Helper::fetchOnlyData($this->wh->getWhLocations($data['offLoadingInfo']->order->wh_id));
            $data['inventory']=Helper::fetchOnlyData($this->inventory->getAllItems());
            $data['putAwayItems']=Helper::fetchOnlyData($this->putAway->getPutAwayItemsAccordingOffLoading($offLoadingId));
            return  Helper::createAPIResponce(false,200,'Putaway items',$data);

        }catch (\Exception $e) {
            return  Helper::createAPIResponce(true,400,$e->getMessage(),[]);
        }
    }
        public function deletePutAwayItem(Request $request)
    {
        try {

            $id=$request->query('id');
            if(!OrderItemPutAway::find($id)){
                return  Helper::createAPIResponce(true,400,'invalid put away id',[]);

            }
            $res = $this->putAway->deletePutAway($id);
            return  Helper::createAPIResponce(false,200,$res->get('message'),$res->get('data'));
        } catch (\Exception $e) {
            return  Helper::createAPIResponce(true,400,$e->getMessage(),[]);

        }
    }
        //checkPutAwayStatus
        public function checkPutAwayStatus(Request $request)
        {
            try {
                $offLoadingId = $request->query('offLoadingId');
                $orderId = $request->query('orderId');

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
                return  Helper::createAPIResponce(false,200,'Put away items list',$itemList);
            } catch (\Exception $e) {
                return  Helper::createAPIResponce(true,400,$e->getMessage(),[]);
            }
        }
        public function putAwayList(Request $request){
        try {
            $res=$this->offLoading->getOffLoadingListForPutAwayApi($request);
            return  Helper::createAPIResponce(false,200,'Put away items list',$res['data']['data']);
            } catch (\Exception $e) {
            return  Helper::createAPIResponce(true,400,$e->getMessage(),[]);
        }
    }
}
