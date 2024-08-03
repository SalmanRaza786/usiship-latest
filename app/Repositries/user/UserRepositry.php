<?php
namespace App\Repositries\user;

use App\Http\Helpers\Helper;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use DataTables;


class UserRepositry implements UserInterface {

    public function getUserList($request)
    {
        try {
            $data['totalRecords'] = Admin::count();

            $qry = Admin::query();
            $qry=$qry->when($request->name, function ($query, $name) {
                return $query->where('name',$name);
            });

            $qry=$qry->when($request->status, function ($query, $status) {
                return $query->where('status',$status);
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


    public function userSave($request,$id)
    {
        try {
            DB::beginTransaction();
            $validator = Validator::make($request->all(), [
                'first_name' => 'required|string|max:255',
                'email' => 'required|email',
                'contact' => 'required',
                'status' => 'required',
            ]);



         if($request->password){
             $validator = Validator::make($request->all(), [
                 'password' => 'required|min:8|confirmed',
             ]);
         }
            if ($validator->fails())
                return Helper::errorWithData($validator->errors()->first(), $validator->errors());

            $user = $id > 0 ? Admin::find($id) : new Admin();
            $user->name = $request->first_name;
            $user->email = $request->email;
            $user->phone = $request->contact;
            $user->role_id = $request->roles[0];
            ($request->password)?$user->password =Hash::make($request->password):'';
            $user->status = $request->status;
            $user->save();

            $user->syncRoles(intval($request->roles[0]));

            ($id==0)?$message = __('translation.record_created'): $message =__('translation.record_updated');
            DB::commit();


            return Helper::success($user, $message);
        } catch (ValidationException $validationException) {
            DB::rollBack();
            return Helper::errorWithData($validationException->errors()->first(), $validationException->errors());
        } catch (\Exception $e) {
            DB::rollBack();
            return Helper::errorWithData($e->getMessage(),[]);
        }
    }

    public function deleteUser($id)
    {
        try {
            $role = Admin::find($id);
            $role->delete();
            return Helper::success($role, $message=__('translation.record_deleted'));
        } catch (ValidationException $validationException) {
            DB::rollBack();
            return Helper::errorWithData($validationException->errors()->first(), $validationException->errors());
        }

    }
    public function editUser($id)
    {
        try {
            $res = Admin::findOrFail($id);
            return Helper::success($res, $message='Record found');
        } catch (ValidationException $validationException) {
            return Helper::errorWithData($validationException->errors()->first(), $validationException->errors());
        }
    }

    public function getAllUser()
    {
        try {

            $qry = Admin::query();
            $data=$qry->orderByDesc('id')->get();
            return Helper::success($data,'Staff list');

        } catch (\Exception $e) {
            return Helper::errorWithData($e->getMessage(),[]);
        }

    }

}





