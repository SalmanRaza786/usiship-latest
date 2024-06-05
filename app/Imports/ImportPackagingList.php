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
                    'qty' => $row['qty'],
                ]
            );
        }
    }
    public function rules(): array
    {
        return [
            'item_name' => 'required',
            'sku' => 'required',
            'qty' => 'required',
        ];
    }
}
