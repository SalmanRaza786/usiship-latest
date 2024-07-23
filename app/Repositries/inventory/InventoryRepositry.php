<?php

namespace App\Repositries\inventory;
use App\Http\Helpers\Helper;
use App\Models\Inventory;
use Illuminate\Validation\ValidationException;
use DataTables;


class InventoryRepositry implements InventoryInterface
{
    public function getAllItems()
    {
        try {
            $qry= Inventory::query();
            $data =$qry->orderByDesc('id')->get();
            return Helper::success($data, $message="Record found");
        } catch (\Exception $e) {
            return Helper::errorWithData($e->getMessage(),[]);
        }

    }

}
