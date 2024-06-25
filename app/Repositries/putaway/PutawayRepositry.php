<?php
namespace App\Repositries\putaway;

use App\Http\Helpers\Helper;

use App\Models\Admin;
use App\Models\LoadType;
use App\Models\OrderCheckIn;
use App\Models\OrderContacts;
use App\Models\OrderItemPutAway;
use App\Models\OrderOffLoading;
use App\Models\WareHouse;
use App\Models\WhDock;
use App\Repositries\appointment\AppointmentRepositry;
use App\Repositries\offLoading\OffLoadingInterface;
use App\Traits\HandleFiles;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use DataTables;


class PutawayRepositry implements PutAwayInterface {

    protected $putAwayFilePath = 'putaway-media/';
    use HandleFiles;

    public function putAwayList($request)
    {
        try {

            $data['totalRecords'] = OrderItemPutAway::count();

            $qry = OrderItemPutAway::query();
            $qry =$qry->with('order.dock.loadType.eqType','status');

            $qry=$qry->when($request->s_name, function ($query, $name) {
                return $query->whereRelation('order','order_id', 'LIKE', "%{$name}%");
            });

            $qry=$qry->when($request->start, fn($q)=>$q->offset($request->start));
            $qry=$qry->when($request->length, fn($q)=>$q->limit($request->length));

            $data['data']=$qry->orderByDesc('id')->get();

            return Helper::success($data, $message=__('translation.record_found'));

        } catch (ValidationException $validationException) {
            return Helper::errorWithData($validationException->errors()->first(), $validationException->errors());
        } catch (\Exception $e) {
            return Helper::errorWithData($e->getMessage(),[]);
        }

    }

    public function updateOrCreatePutAway($request)
    {

        try {
            DB::beginTransaction();
            $validator = Validator::make($request->all(), [
                'qty' => 'required',
            ]);
            if ($validator->fails())
                return Helper::errorWithData($validator->errors()->first(), $validator->errors());

            $orderId=$request->hidden_order_id;
            $offLoadingId=$request->order_off_loading_id;
            $id=$request->putAwayId[0];

            foreach ($request->inventory_id as $key => $val) {

                $item = OrderItemPutAway::updateOrCreate(
                    [
                        'id' =>$request->putAwayId[$key]
                    ],
                    [
                        'order_id' =>$orderId,
                        'order_off_loading_id' =>$offLoadingId,
                        'inventory_id' => $request->inventory_id[$key],
                        'qty' =>$request->qty[$key],
                        'pallet_number' => $request->pallet_number[$key],
                        'location_id' => $request->loc_id[$key],
                        'status_id' => 14,
                    ]
                );


                if ($item) {
                    $fileableId = $item->id;
                    $fileableType = 'App\Models\OrderItemPutAway';

                    // Handle multiple file uploads for each row
                    if ($request->hasFile("putawayImages.$key")) {
                        $uploadedFiles = $request->file("putawayImages.$key");

                        $imageSets = [
                            'putawayImages' => $uploadedFiles
                        ];

                        if (!empty($imageSets['putawayImages'])) {
                            $media = Helper::uploadMultipleMedia($imageSets, $fileableId, $fileableType, $this->putAwayFilePath);
                        }
                    }
                }
            }
            ($id==0)?$message = __('translation.record_created'): $message =__('translation.record_updated');
            DB::commit();


            return Helper::success($item,$message);
        }  catch (\Exception $e) {
            DB::rollBack();
            return Helper::errorWithData($e->getMessage(),[]);
        }
    }

    public function getPutAwayItemsAccordingOffLoading($OffLoadingId)
    {
        try {
            $qry = OrderItemPutAway::query();
            $qry =$qry->with('putAwayMedia');
            $qry =$qry->with('whLocation','inventory');
            $qry =$qry->where('order_off_loading_id',$OffLoadingId);
            $data=$qry->orderByDesc('id')->get();
            return Helper::success($data, 'record_found');

        } catch (ValidationException $validationException) {
            return Helper::errorWithData($validationException->errors()->first(), $validationException->errors());
        } catch (\Exception $e) {
            return Helper::errorWithData($e->getMessage(),[]);
        }

    }

    public function deletePutAway($id)
    {
        try {
            $item = OrderItemPutAway::find($id);
            $item->delete();
            return Helper::success($item, $message=__('translation.record_deleted'));
        } catch (ValidationException $validationException) {
            return Helper::errorWithData($validationException->errors()->first(), $validationException->errors());
        }

    }

    public function checkPutAwayStatus($offLoadingId)
    {
        try {

            $qry=OrderItemPutAway::query();
            $qry=$qry->with('inventory');
            $qry=$qry->where('order_off_loading_id',$offLoadingId);
            $qry=$qry->get();
            return  Helper::success($qry,'Put away items found');
        }catch(\Exception $e){
            throw $e;
        }
    }
}
