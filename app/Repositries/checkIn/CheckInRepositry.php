<?php
namespace App\Repositries\checkIn;

use App\Http\Helpers\Helper;

use App\Models\Admin;
use App\Models\LoadType;
use App\Models\OrderContacts;
use App\Models\WareHouse;
use App\Models\WhDock;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use DataTables;


class CheckInRepositry implements CheckInInterface {
    public function getCheckinList($request)
    {
        try {

                $data['totalRecords'] = OrderContacts::count();


            $qry = OrderContacts::query();
            $qry =$qry->with('carrier','order');

            $qry=$qry->when($request->s_name, function ($query, $name) {

                return $query->whereRelation('carrier','value', 'LIKE', "%{$name}%")
                    ->orWhereRelation('order','value', 'LIKE', "%{$name}%");

            });

//            $qry=$qry->when($request->s_status, function ($query, $status) {
//                return $query->where('status',$status);
//            });
            $qry=$qry->when($request->start, fn($q)=>$q->offset($request->start));
            $qry=$qry->when($request->length, fn($q)=>$q->limit($request->length));


            ///$qry=$qry->where('status','!=',2);
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
    public function checkinSave($request,$id)
    {
        try {


            return Helper::success($data, $message=__('translation.record_found'));

        } catch (ValidationException $validationException) {
            return Helper::errorWithData($validationException->errors()->first(), $validationException->errors());
        } catch (\Exception $e) {
            return Helper::errorWithData($e->getMessage(),[]);
        }

    }

}





