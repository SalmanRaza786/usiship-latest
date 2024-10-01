<?php
namespace App\Repositries\loadType;

use App\Http\Helpers\Helper;

use App\Models\Admin;
use App\Models\LoadType;
use App\Models\WareHouse;
use App\Models\WhDock;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use DataTables;


class loadTypeRepositry implements loadTypeInterface {

    public function getloadList($request,$wh_id=null)
    {
        try {
            if($wh_id!=null) {
                $data['totalRecords'] = LoadType::where('wh_id',$wh_id)->count();
            }else {
                $data['totalRecords'] = LoadType::count();
            }

            $qry = LoadType::query();
            $qry =$qry->with('direction','operation','eqType','transMode');

            $qry=$qry->when($request->s_name, function ($query, $name) {

                return $query->whereRelation('direction','value', 'LIKE', "%{$name}%")
                    ->orWhereRelation('operation','value', 'LIKE', "%{$name}%")
                    ->orWhereRelation('eqType','value', 'LIKE', "%{$name}%")
                    ->orWhereRelation('transMode','value', 'LIKE', "%{$name}%");
            });

            $qry=$qry->when($request->s_status, function ($query, $status) {
                return $query->where('status',$status);
            });
            $qry=$qry->when($request->start, fn($q)=>$q->offset($request->start));
            $qry=$qry->when($request->length, fn($q)=>$q->limit($request->length));



            ($wh_id > 0)?$qry=$qry->where('wh_id',$wh_id)->orWhere('wh_id',null):$qry=$qry->where('wh_id',null);;


            $qry=$qry->where('status','!=',2);
            $data['data']=$qry->orderByDesc('id')->get();

//            if (!empty($request->get('s_name')) OR !empty($request->get('s_status')) ) {
//                $data['totalRecords']=$data['data']->count();
//            }
            return Helper::success($data, $message=__('translation.record_found'));

        } catch (ValidationException $validationException) {
            return Helper::errorWithData($validationException->errors()->first(), $validationException->errors());
        } catch (\Exception $e) {
            return Helper::errorWithData($e->getMessage(),[]);
        }

    }
    public function getAllloadListByWh($wh_id)
    {
        try {
            $data['wh'] = WareHouse::find($wh_id);
            $qry = LoadType::query();
            $qry =$qry->with('direction','operation','eqType','transMode');
            ($wh_id > 0)?$qry=$qry->where('wh_id',$wh_id)->orWhere('wh_id',null):$qry=$qry->where('wh_id',null);
            $data['loadType']=$qry->get();
            return Helper::success($data, $message=__('translation.record_found'));
        } catch (ValidationException $validationException) {
            return Helper::errorWithData($validationException->errors()->first(), $validationException->errors());
        } catch (\Exception $e) {
            return Helper::errorWithData($e->getMessage(),[]);
        }
    }
    public function adminLoadTypeList($request)
    {
        try {

                $data['totalRecords'] = LoadType::count();


            $qry = LoadType::query();
            $qry =$qry->with('wareHouse','direction','operation','eqType','transMode');

            $qry=$qry->when($request->s_name, function ($query, $name) {

                return $query->whereRelation('direction','value', 'LIKE', "%{$name}%")
                    ->orWhereRelation('operation','value', 'LIKE', "%{$name}%")
                    ->orWhereRelation('eqType','value', 'LIKE', "%{$name}%")
                    ->orWhereRelation('transMode','value', 'LIKE', "%{$name}%");
            });

            $qry=$qry->when($request->s_status, function ($query, $status) {
                return $query->where('status',$status);
            });
            $qry=$qry->when($request->start, fn($q)=>$q->offset($request->start));
            $qry=$qry->when($request->length, fn($q)=>$q->limit($request->length));

            $data['data']=$qry->orderByDesc('id')->get();

            if (!empty($request->get('s_name')) OR !empty($request->get('s_status')) ) {
                $data['totalRecords']=$data['data']->count();
            }
            return Helper::success($data, $message=__('translation.record_found'));

        } catch (ValidationException $validationException) {
            return Helper::errorWithData($validationException->errors()->first(), $validationException->errors());
        } catch (\Exception $e) {
            return Helper::errorWithData($e->getMessage(),[]);
        }

    }

    public function loadSave($request,$id)
    {
        try {
            DB::beginTransaction();
            $validator = Validator::make($request->all(), [
                'direction' => 'required',
                'operation' => 'required',
                'equipment_type' => 'required',
                'trans_mode' => 'required',
                'duration' => 'required',
                'status' => 'required',
            ]);


            if ($validator->fails())
                return Helper::errorWithData($validator->errors()->first(), $validator->errors());

            $load = LoadType::updateOrCreate(
                [
                    'id' => $id
                ],
                [
                    'wh_id' =>$request->hidden_wh_id_load_type?$request->hidden_wh_id_load_type:null,
                    'direction_id' => $request->direction,
                    'operation_id' => $request->operation,
                    'equipment_type_id' => $request->equipment_type,
                    'trans_mode_id' => $request->trans_mode,
                    'duration' => $request->duration,
                    'status' => $request->status,

                ]
            );

            ($id==0)?$message = __('translation.record_created'): $message =__('translation.record_updated');
            DB::commit();


            return Helper::success($load, $message);
        } catch (ValidationException $validationException) {
            DB::rollBack();
            return Helper::errorWithData($validationException->errors()->first(), $validationException->errors());
        } catch (\Exception $e) {
            DB::rollBack();
            return Helper::errorWithData($e->getMessage(),[]);
        }
    }

    public function deleteload($id)
    {
        try {

            $role = LoadType::find($id);
            $role->delete();
            return Helper::success($role, $message=__('translation.record_deleted'));
        } catch (ValidationException $validationException) {
            DB::rollBack();
            return Helper::errorWithData($validationException->errors()->first(), $validationException->errors());
        }

    }
    public function editload($id)
    {
        try {
            $res = LoadType::findOrFail($id);
            return Helper::success($res, $message='Record found');
        } catch (ValidationException $validationException) {
            return Helper::errorWithData($validationException->errors()->first(), $validationException->errors());
        }
    }

    public function getGeneralLoadTypes()
    {
        try {

            $qry = LoadType::with('direction','operation','eqType','transMode');
            $qry = $qry->where('wh_id',null);
            $data['data']=$qry->orderByDesc('id')->get();
            return Helper::success($data, $message=__('translation.record_found'));

        } catch (ValidationException $validationException) {
            return Helper::errorWithData($validationException->errors()->first(), $validationException->errors());
        } catch (\Exception $e) {
            return Helper::errorWithData($e->getMessage(),[]);
        }

    }

    public function getCombineLoadType($whId)
    {
        try {

            $qry = LoadType::query();
            $qry = $qry->where('wh_id',null)->orWhere('wh_id',$whId);
            $data=$qry->orderByDesc('id')->get();
            return Helper::success($data, $message=__('translation.record_found'));

        } catch (ValidationException $validationException) {
            return Helper::errorWithData($validationException->errors()->first(), $validationException->errors());
        } catch (\Exception $e) {
            return Helper::errorWithData($e->getMessage(),[]);
        }

    }

}





