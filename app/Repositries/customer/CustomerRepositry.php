<?php
namespace App\Repositries\customer;

use App\Http\Helpers\Helper;

use App\Models\Admin;
use App\Models\LoadType;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use DataTables;


class CustomerRepositry implements CustomerInterface {

    public function getcustomerList($request)
    {
        try {
            $data['totalRecords'] = User::count();
            $qry= User::with('company');

            $qry=$qry->when($request->s_name, function ($query, $name) {
                return $query->where('name', 'LIKE', "%{$name}%")
                    ->orWhere('email','LIKE',"%{$name}%");
            });


            $qry=$qry->when($request->start, fn($q)=>$q->offset($request->start));
            $qry=$qry->when($request->length, fn($q)=>$q->limit($request->length));
            $data['data'] =$qry->orderByDesc('id')->get();

            if (!empty($request->get('s_name')) ) {
                $data['totalRecords']=$qry->count();
            }
            return Helper::success($data, $message="Record found");

        } catch (ValidationException $validationException) {
            return Helper::errorWithData($validationException->errors()->first(), $validationException->errors());
        } catch (\Exception $e) {
            return Helper::errorWithData($e->getMessage(),[]);
        }

    }
    public function customerSave($request,$id)
    {
        try {

            DB::beginTransaction();

            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255'],
                'company_id' => 'required',
                'status' => 'required',
                'phone_no' => 'required',
                'email' => 'required|string|email|max:255|unique:users,email,'. $id,

            ]);

            if($request->password!=null){
                $validator = Validator::make($request->all(), [
                    'password' => ['nullable', 'string', 'min:8', 'confirmed'],
                ]);
            }

            if ($validator->fails())
                return Helper::errorWithData($validator->errors()->first(), $validator->errors());

            $customerData = [
                'name' => $request->name,
                'email' => $request->email,
                'company_id' => $request->company_id??null,
                'company_name' => $request->company_name,
                'phone_no' => $request->phone_no,
                'status' => $request->status??2,
            ];

            if ($request->filled('password')) {
                $customerData['password'] = $request->password;
            }

            $load = User::updateOrCreate(
                [
                    'id' => $id
                ],
                $customerData
            );

            ($id==0)?$message = __('translation.record_created'): $message =__('translation.record_updated');
            DB::commit();

            $customer = User::with('company')->find($load->id);

            return Helper::success($customer, $message);
        } catch (ValidationException $validationException) {
            DB::rollBack();
            return Helper::errorWithData($validationException->errors()->first(), $validationException->errors());
        } catch (\Exception $e) {
            DB::rollBack();
            return Helper::errorWithData($e->getMessage(),[]);
        }
    }

    public function deletecustomer($id)
    {
        try {
            $role = User::find($id);
            $role->delete();
            return Helper::success($role, $message=__('translation.record_deleted'));
        } catch (ValidationException $validationException) {
            DB::rollBack();
            return Helper::errorWithData($validationException->errors()->first(), $validationException->errors());
        }

    }
    public function editcustomer($id)
    {
        try {
            $res = User::findOrFail($id);
            return Helper::success($res, $message='Record found');
        } catch (ValidationException $validationException) {
            return Helper::errorWithData($validationException->errors()->first(), $validationException->errors());
        }
    }

    public function getAllCustomers()
    {
        try {
            $qry= User::query();
            $data=$qry->orderByDesc('id')->get();
            return Helper::success($data, $message="Record found");
        } catch (ValidationException $validationException) {
            return Helper::errorWithData($validationException->errors()->first(), $validationException->errors());
        } catch (\Exception $e) {
            return Helper::errorWithData($e->getMessage(),[]);
        }

    }

}





