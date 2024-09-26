<?php
namespace App\Repositries\carriers;

use App\Http\Helpers\Helper;

use App\Models\Admin;
use App\Models\Carriers;
use App\Models\Company;
use App\Models\CustomFields;
use App\Models\FileContent;
use App\Models\LoadType;
use App\Models\OrderContacts;
use App\Repositries\appointment\AppointmentRepositry;
use App\Traits\HandleFiles;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use DataTables;


class CarriersRepositry implements CarriersInterface {

    protected $carrierFilePath = 'carrier-media/';
    protected $carrierFileName = "";
    protected $carrierDocFileName = "";
    protected $carrierBolImage = "";
    protected $carrierDoDocument= "";

    use HandleFiles;
    public function carriersList($request)
    {
        try {
            $data['totalRecords'] = Carriers::count();

            $qry = Carriers::with('company');
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


    public function CarriersSave($request,$id)
    {
        try {
            DB::beginTransaction();
            $validator = Validator::make($request->all(), [
                'company_id' => 'required',
                'carrier_company_name'=> 'required',
                'email' => 'required',
                'contacts' => 'required',

            ]);


            if ($validator->fails())
                return Helper::errorWithData($validator->errors()->first(), $validator->errors());

            $role = Carriers::updateOrCreate(
                [
                    'id' => $id
                ],
                [
                    'company_id' => $request->company_id,
                    'carrier_company_name' => $request->carrier_company_name,
                    'email' => $request->email,
                    'contacts' => $request->contacts,


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

    public function CarriersSaveInfo($request,$id)
    {
        try {
            DB::beginTransaction();
            $validator = Validator::make($request->all(), [
                'order_id' => 'required',
                'driver_name'=> 'required',
                'phone_no' => 'required',


            ]);

            if($request->from==0){
                $validator = Validator::make($request->all(), [
                    'other_document' => 'required',
                    'driver_id_pic'=> 'required',
                    'do_document' => 'required',
                    'bol_image' => 'required',
                ]);
            }

            if ($validator->fails())
                return Helper::errorWithData($validator->errors()->first(), $validator->errors());


            $company = Company::updateOrCreate(
                [
                    'id' => $request->company_id,
                ],
                [
                    'company_title' => $request->company_name,
                    'contact' => $request->company_phone_no,
                ]
            );

            if($company)
            {
                $carrier = Carriers::updateOrCreate(
                    [
                        'id' => $request->carrier_id
                    ],
                    [
                        'company_id' => $company->id,
                        'carrier_company_name' => $request->driver_name,
                        'email' => "test@gmail.com",
                        'contacts' => $request->phone_no,
                        'id_card_image' =>$this->carrierFileName,
                        'other_docs' =>$this->carrierDocFileName,
                    ]
                );
                if($carrier)
                {
                    $fileableId = $carrier->id;
                    $fileableType = 'App\Models\Carriers';

                    if($request->file('driver_id_pic')){
                        $media = Helper::createOrUpdateSingleMedia($request->file('driver_id_pic'), $fileableId, $fileableType, $this->carrierFilePath,$request->driverFileId,'driver_id_pic');
                    }

                    if($request->file('other_document')){
                        $media = Helper::createOrUpdateSingleMedia($request->file('other_document'), $fileableId, $fileableType, $this->carrierFilePath,$request->otherDocFileId,'other_document');
                    }

                    $orderContact = OrderContacts::updateOrCreate(
                        [
                            'order_id' => $request->order_id,
                            'carrier_id' => $carrier->id,
                        ],
                        [
                            'order_id' => $request->order_id,
                            'carrier_id' => $carrier->id,
                            'arrival_time' => $request->currentdatetime,
                            'vehicle_number' => $request->vehicle_no,
                            'vehicle_licence_plate' => $request->license_no,
                            'bol_number' => $request->bol_no,
                            'do_number' => $request->do_no,
                            'status_id' => 9,
                        ]
                    );
                    if($orderContact)
                    {
                        $fileableId = $orderContact->id;
                        $fileableType = 'App\Models\OrderContacts';

                        if($request->file('bol_image')){
                            $media = Helper::createOrUpdateSingleMedia($request->file('bol_image'), $fileableId, $fileableType, $this->carrierFilePath,$request->bolFileId,'bol_image');

                        }
                        if($request->file('do_document')){
                            $media = Helper::createOrUpdateSingleMedia($request->file('do_document'), $fileableId, $fileableType, $this->carrierFilePath,$request->doFileId,'do_document');
                        }
                    }
                }
            }

            ($id==0)?$message = __('translation.record_created'): $message =__('translation.record_updated');
            DB::commit();
            return Helper::success($orderContact, $message);
        } catch (\Exception $e) {
            DB::rollBack();
            return Helper::errorWithData($e->getMessage(),[]);
        }
    }

    public function deleteCarriers($id)
    {
        try {
            $role = Carriers::find($id);
            $role->delete();
            return Helper::success($role, $message=__('translation.record_deleted'));
        } catch (ValidationException $validationException) {
            DB::rollBack();
            return Helper::errorWithData($validationException->errors()->first(), $validationException->errors());
        }

    }
    public function editCarriers($id)
    {
        try {
            $res = Carriers::findOrFail($id);
            return Helper::success($res, $message='Record found');
        } catch (ValidationException $validationException) {
            return Helper::errorWithData($validationException->errors()->first(), $validationException->errors());
        }
    }

}





