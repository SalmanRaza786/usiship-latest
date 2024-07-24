<?php

namespace App\Imports;


use App\Models\Inventory;
use App\Models\PackgingList;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ImportPackagingList implements ToModel,WithHeadingRow,WithValidation
{
    protected  $order_id;

    public function __construct($order_id)
    {
        $this->order_id = $order_id;
    }

    public function model(array $row)
    {


        if ($this->order_id) {
            $cer = Inventory::updateOrCreate(
                [
                    'sku' => $row['sku'],
                ],
                [
                    'item_name' => $row['item_name'],
                    'sku' => $row['sku'],
                ]
            );

            $list = PackgingList::updateOrCreate(
                [
                    'order_id' => $this->order_id,
                    'inventory_id' => $cer->id,
                ],
                [
                    'order_id' => $this->order_id,
                    'inventory_id' => $cer->id,
                    'qty' => $row['qty_per_packing_slip'],
                    'hi' => $row['hi'],
                    'ti' => $row['ti'],
                    'qty_received_cartons' => $row['quantity_received_cartons'],
                    'qty_received_each' => $row['quantity_received_eaches'],
                    'exception_qty' => $row['exceptions'],
                    'total_pallets' => $row['total_pallets'],
                    'lot_3' => $row['lot'],
                    'serial_number' => $row['serial'],
                    'upc_label' => $row['upc_label'],
                    'expiry_date' =>Carbon::parse($row['expiration_date'])->format('Y-m-d'),
                    'length' => $row['length'],
                    'width' => $row['width'],
                    'height' => $row['height'],
                    'weight' => $row['weight'],
                    'custom_field_1' => $row['custom_field1'],
                    'custom_field_2' => $row['custom_field2'],
                    'custom_field_3' => $row['custom_field3'],
                    'custom_field_4' => $row['custom_field4'],
                ]
            );
        }
    }
    public function rules(): array
    {
        return [
            'item_name' => 'required',
            'sku' => 'required',
            'qty_per_packing_slip' => 'required',
        ];
    }
}
