<?php
namespace App\Repositries\customerCompanies;

use App\Http\Helpers\Helper;

use App\Models\Admin;
use App\Models\Company;
use App\Models\CustomerCompany;
use App\Models\CustomFields;
use App\Models\LoadType;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use DataTables;


class CustomerCompaniesRepositry implements CustomerCompaniesInterface
{

    public function companiesList($request)
    {
        try {
            $data['totalRecords'] = Company::count();

            $qry = CustomerCompany::query();
            $qry = $qry->when($request->name, function ($query, $name) {
                return $query->where('title', $name);
            });

//            $qry = $qry->when($request->status, function ($query, $status) {
//                return $query->where('status', $status);
//            });
            $qry = $qry->when($request->start, fn($q) => $q->offset($request->start));
            $qry = $qry->when($request->length, fn($q) => $q->limit($request->length));
            $data['data'] = $qry->orderByDesc('id')->get();

            if (!empty($request->get('name'))) {
                $data['totalRecords'] = $data['data']->count();
            }
            return Helper::success($data, $message = __('translation.record_found'));

        } catch (ValidationException $validationException) {
            return Helper::errorWithData($validationException->errors()->first(), $validationException->errors());
        } catch (\Exception $e) {
            return Helper::errorWithData($e->getMessage(), []);
        }

    }


    public function companiesSave($request, $id)
    {
        try {
            DB::beginTransaction();
            $validator = Validator::make($request->all(), [
                'company_title' => 'required',
                'email' => 'required',
                'contact' => 'required',
                'address' => 'required',

            ]);


            if ($validator->fails())
                return Helper::errorWithData($validator->errors()->first(), $validator->errors());

            $role = CustomerCompany::updateOrCreate(
                [
                    'id' => $id
                ],
                [
                    'title' => $request->company_title,
                    'email' => $request->email,
                    'contact' => $request->contact,
                    'address' => $request->address,

                ]
            );

            ($id == 0) ? $message = __('translation.record_created') : $message = __('translation.record_updated');
            DB::commit();


            return Helper::success($role, $message);
        } catch (ValidationException $validationException) {
            DB::rollBack();
            return Helper::errorWithData($validationException->errors()->first(), $validationException->errors());
        } catch (\Exception $e) {
            DB::rollBack();
            return Helper::errorWithData($e->getMessage(), []);
        }
    }

    public function deleteCompanies($id)
    {
        try {
            $role = CustomerCompany::find($id);
            $role->delete();
            return Helper::success($role, $message = __('translation.record_deleted'));
        } catch (ValidationException $validationException) {
            DB::rollBack();
            return Helper::errorWithData($validationException->errors()->first(), $validationException->errors());
        }

    }

    public function editCompanies($id)
    {
        try {
            $res = CustomerCompany::findOrFail($id);
            return Helper::success($res, $message = 'Record found');
        } catch (ValidationException $validationException) {
            return Helper::errorWithData($validationException->errors()->first(), $validationException->errors());
        }
    }

    public function getAllCompanies()
    {
        try {

            $qry = CustomerCompany::query();
//            $qry = $qry->select('id', 'title');
            $data['data'] = $qry->get();
            return Helper::success($data, $message = "Record found");

        } catch (ValidationException $validationException) {
            return Helper::errorWithData($validationException->errors()->first(), $validationException->errors());
        } catch (\Exception $e) {
            return Helper::errorWithData($e->getMessage(), []);
        }


    }
}





