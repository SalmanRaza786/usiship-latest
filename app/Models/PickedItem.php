<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PickedItem extends Model
{
    use HasFactory;

    protected $fillable=['picker_table_id','inventory_id','loc_id','order_qty','w_order_item_id','picked_loc_id','picked_qty'];

    public function inventory()
    {
        return $this->belongsTo(Inventory::class, 'inventory_id','id');
    }

    public function location()
    {
        return $this->belongsTo(WhLocation::class, 'loc_id','id');
    }

    public function wOrderItems()
    {
        return $this->belongsTo(WorkOrderItem::class, 'w_order_item_id','id');
    }

    public function pickerTable()
    {
        return $this->belongsTo(WorkOrderPicker::class, 'picker_table_id','id');
    }

}
