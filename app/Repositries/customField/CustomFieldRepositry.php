<?php
namespace App\Repositries\customField;

use App\Http\Helpers\Helper;

use App\Models\Admin;
use App\Models\CustomFields;
use App\Models\LoadType;
use App\Models\WhAssignedField;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use DataTables;


class CustomFieldRepositry implements CustomFieldInterface {

    public function customFieldList($request)
    {
        try {
            $data['totalRecords'] = CustomFields::count();

            $qry = CustomFields::query();

            $qry=$qry->when($request->s_name, function ($query, $name) {
                return $query->where('label', 'LIKE', "%{$name}%")
                    ->orWhere('input_type','LIKE',"%{$name}%")
                    ->orWhere('place_holder','LIKE',"%{$name}%")
                    ->orWhere('description','LIKE',"%{$name}%")
                    ->orWhere('require_type','LIKE',"%{$name}%");
            });


            $qry=$qry->when($request->start, fn($q)=>$q->offset($request->start));
            $qry=$qry->when($request->length, fn($q)=>$q->limit($request->length));
            $data['data']=$qry->orderByDesc('id')->get();

            if (!empty($request->get('name')) OR !empty($request->get('status')) ) {
                $data['totalRecords']=$data['data']->count();
            }
            return Helper::success($data, $message=__('translation.record_found'));

        } catch (ValidationException $validationException) {
            return Helper::errorWithData($validationException->errors()->first(), $validationException->errors());
        } catch (\Exception $e) {
            return Helper::errorWithData($e->getMessage(),[]);
        }

    }


    public function customFieldSave($request,$id)
    {
        try {
            DB::beginTransaction();
            $validator = Validator::make($request->all(), [
                'labal' => 'required|string|max:255|unique:custom_fields,label,'. $id,
                'input_type' => 'required',
                'place_holder' => 'required',
                'description' => 'required',
            ]);


            if ($validator->fails())
                return Helper::errorWithData($validator->errors()->first(), $validator->errors());

            $role = CustomFields::updateOrCreate(
                [
                    'id' => $id
                ],
                [
                    'label' => $request->labal,
                    'input_type' => $request->input_type,
                    'place_holder' => $request->place_holder,
                    'description' => $request->description,
                    'require_type' =>($request->require_type)?1:2,
                    'order_by' =>$request->order_by,

                ]
            );

            ($id==0)?$message = __('translation.record_created'): $message =__('translation.record_updated');
            DB::commit();


            return Helper::success($role, $message);
        } catch (ValidationException $validationException) {
            DB::rollBack();
            return Helper::errorWithData($validationException->errors()->first(), $validationException->errors());
        } catch (\Exception $e) {
            DB::rollBack();
            return Helper::errorWithData($e->getMessage(),[]);
        }
    }

    public function deleteCustomField($id)
    {
        try {
            $role = CustomFields::find($id);
            $role->delete();
            return Helper::success($role, $message=__('translation.record_deleted'));
        } catch (ValidationException $validationException) {
            DB::rollBack();
            return Helper::errorWithData($validationException->errors()->first(), $validationException->errors());
        }

    }
    public function editCustomField($id)
    {
        try {
            $res = CustomFields::findOrFail($id);
            return Helper::success($res, $message='Record found');
        } catch (ValidationException $validationException) {
            return Helper::errorWithData($validationException->errors()->first(), $validationException->errors());
        }
    }

    public function customFieldsForDropdown()
    {
        try {
            $qry = CustomFields::query();
            $data=$qry->orderByDesc('id')->get();
            return Helper::success($data, $message=__('translation.record_found'));

        } catch (ValidationException $validationException) {
            return Helper::errorWithData($validationException->errors()->first(), $validationException->errors());
        } catch (\Exception $e) {
            return Helper::errorWithData($e->getMessage(),[]);
        }

    }

    public function getFieldsAccordingWareHouse($whId)
    {
        try {


//            $qry = WhAssignedField::query();
//            $qry=$qry->where('wh_id',$whId);
//            $qry=$qry->with('customFields');
//            $data=$qry->get();


            $qry = WhAssignedField::query();
            $qry = $qry->where('wh_id', $whId);
            $qry = $qry->leftJoin('custom_fields', 'wh_assigned_fields.field_id', '=', 'custom_fields.id')
                ->orderBy('custom_fields.order_by', 'asc');
            $data = $qry->with('customFields')->get();

            return Helper::success($data, $message=__('translation.record_found'));

        } catch (ValidationException $validationException) {
            return Helper::errorWithData($validationException->errors()->first(), $validationException->errors());
        } catch (\Exception $e) {
            return Helper::errorWithData($e->getMessage(),[]);
        }

    }

}





