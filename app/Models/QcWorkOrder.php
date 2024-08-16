<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QcWorkOrder extends Model
{
    use HasFactory;
    protected  $fillable=['work_order_id','start_time','end_time','status_code','auth_id'];

    public function workOrder()
    {
        return $this->belongsTo(WorkOrder::class, 'work_order_id', 'id');
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
