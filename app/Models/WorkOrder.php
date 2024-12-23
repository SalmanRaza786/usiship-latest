<?php

namespace App\Models;

use http\Client;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'wms_transaction_id',
        'ship_method',
        'order_date',
        'ship_date',
        'load_type_id',
        'carrier_id',
        'order_reference',
        'wms_order_status',
        'wms_created_at',
        'wms_updated_at',
        'status_code',
    ];

    public function client()
    {
        return $this->belongsTo(CustomerCompany::class, 'client_id', 'id');
    }

    public function status()
    {
        return $this->belongsTo(OrderStatus::class, 'status_code', 'order_by');
    }
    public function wOrderItems()
    {
        return $this->hasMany(WorkOrderItem::class, 'work_order_id','id');
    }
    public function carrier()
    {
        return $this->belongsTo(Carriers::class, 'carrier_id', 'id');
    }

    public function loadType()
    {
        return $this->belongsTo(LoadType::class, 'load_type_id', 'id');
    }

    public function picker()
    {
        return $this->hasOneThrough(
            Admin::class,        // The model you want to retrieve (e.g., User model for picker details)
            WorkOrderPicker::class, // The intermediate model (e.g., OrderPicker pivot table)
            'work_order_id',    // Foreign key on the OrderPicker table
            'id',               // Foreign key on the User table
            'id',               // Local key on the WorkOrder table
            'picker_id'         // Local key on the OrderPicker table that points to the picker
        );
    }
}
