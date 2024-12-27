<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MissedItem extends Model
{
    use HasFactory;
    protected $fillable=['picker_table_id','work_order_id','status_code','start_time','end_time','auth_id','is_publish'];

    public function workOrder()
    {
        return $this->belongsTo(WorkOrder::class, 'work_order_id', 'id');
    }
    public function missingOrderItems()
    {
        return $this->hasMany(MissedItemDetail::class, 'missed_items_parent_id','id');
    }

    public function orderPicker()
    {
        return $this->belongsTo(WorkOrderPicker::class, 'picker_table_id', 'id');
    }

    public function status()
    {
        return $this->belongsTo(OrderStatus::class, 'status_code', 'order_by');
    }

        public function scopePublish($query)
        {
            return $query->where('is_publish',1);
        }

}
