<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkOrderPicker extends Model
{
    use HasFactory;
    protected $fillable=['work_order_id','picker_id','status_code'];
    public function workOrder()
    {
        return $this->belongsTo(WorkOrder::class, 'work_order_id', 'id');
    }

    public function status()
    {
        return $this->belongsTo(OrderStatus::class, 'status_code', 'order_by');
    }


}
