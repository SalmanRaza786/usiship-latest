<?php

namespace App\Repositries\permissions;

use App\Http\Helpers\Helper;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Role;
use DataTables;


class PermissionRepositry implements PermissionInterface
{
    public function assignPermissions($request)
    {

        try {
            DB::beginTransaction();
            $validator = Validator::make($request->all(), [
                'role_id' => 'required',
            ]);
            if ($validator->fails())
                return Helper::errorWithData($validator->errors()->first(), $validator->errors());

            $role= Role::find($request->role_id);
            $permissions = array_map('intval', $request->permissions);
            $role->syncPermissions($permissions);
            $message = $message =__('translation.record_updated');
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

}
