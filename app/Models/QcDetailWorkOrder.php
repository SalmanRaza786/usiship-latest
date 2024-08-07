<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QcDetailWorkOrder extends Model
{
    use HasFactory;

    protected $fillable=['qc_parent_id','w_order_item_id','picked_qty'];

    public function workOrderItem()
    {
        return $this->belongsTo(WorkOrderItem::class, 'w_order_item_id', 'id');
    }


}
