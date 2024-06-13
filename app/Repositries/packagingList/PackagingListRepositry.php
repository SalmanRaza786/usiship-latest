<?php
namespace App\Repositries\packagingList;

use App\Http\Helpers\Helper;

use App\Models\Admin;
use App\Models\LoadType;
use App\Models\OrderCheckIn;
use App\Models\OrderContacts;
use App\Models\PackgingList;
use App\Models\WareHouse;
use App\Models\WhDock;
use App\Repositries\appointment\AppointmentRepositry;
use App\Repositries\orderContact\OrderContactRepositry;
use App\Traits\HandleFiles;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use DataTables;
use function Symfony\Component\Translation\t;


class PackagingListRepositry implements PackagingListInterface {

    protected $packagingListFilePath = 'packaging-list-media/';
    use HandleFiles;

    public function updatePackagingList($request,$id)
    {

        try {
            DB::beginTransaction();

            $packinglist = PackgingList::updateOrCreate(
                [
                    'id' => $id
                ],
                [
                    'qty_received_cartons' => $request->cartons_qty,
                    'qty_received_each' => $request->received_each,
                    'exception_qty' => $request->exception_qty,
                    'ti' => $request->ti,
                    'hi' => $request->hi,
                    'total_pallets' => $request->total_pallets,
                    'lot_3' => $request->lot_3,
                    'serial_number' => $request->serial_number,
                    'upc_label' => $request->upc_label,
                    'expiry_date' => $request->expiry_date,
                    'length' => $request->length,
                    'width' => $request->width,
                    'height' => $request->height,
                    'weight' => $request->weight,
                    'custom_field_1' => $request->custom_field_1,
                    'custom_field_2' => $request->custom_field_2,
                    'custom_field_3' => $request->custom_field_3,
                    'custom_field_4' => $request->custom_field_4,
                ]
            );

//            if($checkin)
//            {
//                $fileableId = $checkin->id;
//                $fileableType = 'App\Model\OrderCheckIn';
//
//                $imageSets = [
//                    'containerImages' => $request->file('containerImages', []),
//                    'sealImages' => $request->file('sealImages', []),
//                    'do_signatureImages' => $request->file('do_signatureImages', []),
//                    'other_docImages' => $request->file('other_docImages', []),
//                ];
//
//                $media =  Helper::uploadMultipleMedia($imageSets,$fileableId,$fileableType,$this->packagingListFilePath);
//
//                $orderContact = new OrderContactRepositry();
//                $orderContact->changeStatus($checkin->order_contact_id, 12);
//
//            }

            DB::commit();

            return Helper::success($packinglist, $message=__('translation.record_created'));

        } catch (ValidationException $validationException) {
            return Helper::errorWithData($validationException->errors()->first(), $validationException->errors());
        } catch (\Exception $e) {
            return Helper::errorWithData($e->getMessage(),[]);
        }

    }


}





