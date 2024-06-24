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
            $validator = Validator::make($request->all(), [
                'cartons_qty' => 'nullable|integer',
                'received_each' => 'nullable|integer',
                'exception_qty' => 'nullable|integer',
                'ti' => 'nullable|string',
                'hi' => 'nullable|string',
                'total_pallets' => 'nullable|integer',
                'lot_3' => 'nullable|string',
                'serial_number' => 'nullable|string',
                'upc_label' => 'nullable|string',
                'expiry_date' => 'nullable|date',
                'length' => 'nullable|numeric',
                'width' => 'nullable|numeric',
                'height' => 'nullable|numeric',
                'weight' => 'nullable|numeric',
                'custom_field_1' => 'nullable|string',
                'custom_field_2' => 'nullable|string',
                'custom_field_3' => 'nullable|string',
                'custom_field_4' => 'nullable|string',
                'damageImages.*' => 'nullable|image|max:2048', // Validate each image
                'upc_label_photos.*' => 'nullable|image|max:2048', // Validate each image
            ]);

            if ($validator->fails())
                return Helper::errorWithData($validator->errors()->first(), $validator->errors());

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

            if($packinglist)
            {
                $fileableId = $packinglist->id;
                $fileableType = 'App\Models\PackgingList';

                $imageSets = [
                    'damageImages' => $request->file('damageImages', []),
                    'upc_label_photos' => $request->file('upc_label_photos', []),
                ];

                if (!empty($imageSets['damageImages']) || !empty($imageSets['upc_label_photos'])){
                    $media =  Helper::uploadMultipleMedia($imageSets,$fileableId,$fileableType,$this->packagingListFilePath);
                }


            }

            DB::commit();

            ($id==0)?$message = __('translation.record_created'): $message =__('translation.record_updated');
            return Helper::success($packinglist, $message);

        } catch (ValidationException $validationException) {
            return Helper::errorWithData($validationException->errors()->first(), $validationException->errors());
        } catch (\Exception $e) {
            return Helper::errorWithData($e->getMessage(),[]);
        }

    }


}





