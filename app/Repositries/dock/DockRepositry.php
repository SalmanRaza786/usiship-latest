<?php
namespace App\Repositries\dock;

use App\Http\Helpers\Helper;

use App\Models\Admin;
use App\Models\DocksLoadType;
use App\Models\LoadType;
use App\Models\WareHouse;
use App\Models\WhDock;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use DataTables;


class DockRepositry implements DockInterface {

    public function dockList($request,$wh_id=null)
    {
        try {
            $qry = WhDock::query();
            $qry = $qry->with('dockLoadTypes');
            $qry = $qry->where('wh_id',$wh_id);
            $data=$qry->orderByDesc('id')->get();
            return Helper::success($data, $message=__('translation.record_found'));

        } catch (ValidationException $validationException) {
            return Helper::errorWithData($validationException->errors()->first(), $validationException->errors());
        } catch (\Exception $e) {
            return Helper::errorWithData($e->getMessage(),[]);
        }

    }
    public function getDockListByLoadtype($loadTypeId,$whId)
    {
        try {
//here
            $qry=DocksLoadType::query();
            $qry=$qry->with('dock:id,title,wh_id');
            $qry=$qry->with('loadType:id,wh_id,duration');
            $qry=$qry->whereRelation('dock','wh_id',$whId);
            $qry=$qry->where('load_type_id',$loadTypeId);
            $data=$qry->get();
            return Helper::success($data, $message=__('translation.record_found'));
        } catch (ValidationException $validationException) {
            return Helper::errorWithData($validationException->errors()->first(), $validationException->errors());
        } catch (\Exception $e) {
            return Helper::errorWithData($e->getMessage(),[]);
        }
    }




    public function storeUpdateDock($request,$id)
    {
        try {

            $validator = Validator::make($request->all(), [
                'load_type_id' => 'required',
                'hidden_wh_id_dock' => 'required',
                'doc_title' => 'required',
                'slot' => 'required',
                'schedule_limit' => 'required',
                'reschedule_before' => 'required',
                'status' => 'required',
            ]);

            if ($validator->fails())
                return Helper::errorWithData($validator->errors()->first(), $validator->errors());



                $dock = WhDock::updateOrCreate(
                    [
                        'id' => $id
                    ],
                    [
                        'wh_id' =>$request->hidden_wh_id_dock,
                        'title' => $request->doc_title,
                        'slot' => $request->slot,
                        'cancel_before' => $request->reschedule_before,
                        'schedule_limit' => $request->schedule_limit,
                        'status' => $request->status,
                    ]);

            $dockId=$dock->id;
            DocksLoadType::where('dock_id',$dockId)->delete();

            foreach ($request->load_type_id as $key=>$val){
            $dockLoad = DocksLoadType::updateOrCreate(
                [
                    'dock_id' =>$dockId,
                    'load_type_id' =>$val,
                ],
                [
                    'dock_id' =>$dockId,
                    'load_type_id' =>$val,

                ]);
            }
            ($id==0)?$message = __('translation.record_created'): $message =__('translation.record_updated');

            return Helper::success($dock,$message);
        } catch (ValidationException $validationException) {

            return Helper::errorWithData($validationException->errors()->first(), $validationException->errors());
        } catch (\Exception $e) {

            return Helper::errorWithData($e->getMessage(),[]);
        }
    }

    public function deleteDock($id)
    {
        try {
            $role = WhDock::find($id);
            $role->delete();
            return Helper::success($role, $message=__('translation.record_deleted'));
        } catch (ValidationException $validationException) {
            DB::rollBack();
            return Helper::errorWithData($validationException->errors()->first(), $validationException->errors());
        }

    }
    public function editDock($id)
    {
        try {
            $res = WhDock::with('dockLoadTypes')->findOrFail($id);
            return Helper::success($res, $message='Record found');
        } catch (ValidationException $validationException) {
            return Helper::errorWithData($validationException->errors()->first(), $validationException->errors());
        }
    }

    public function dockInfo($dockId,$loadTypeId)
    {
        try {

            $qry=DocksLoadType::query();
            $qry=$qry->with('dock:id,title,wh_id,slot');
            $qry=$qry->with('loadType:id,wh_id,duration');
            $qry=$qry->where('dock_id',$dockId);
            $qry=$qry->where('load_type_id',$loadTypeId);
            $data=$qry->first();

            return Helper::success($data,'dock info');

        } catch (ValidationException $validationException) {
            return Helper::errorWithData($validationException->errors()->first(), $validationException->errors());
        } catch (\Exception $e) {
            return Helper::errorWithData($e->getMessage(),[]);
        }

    }

}





