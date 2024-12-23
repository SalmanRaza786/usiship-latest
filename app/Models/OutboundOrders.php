<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OutboundOrders extends Model
{
    use HasFactory;
    protected $fillable=['order_id','work_order_id','company_id'];
    public function wmsOrder()
    {
        return $this->belongsTo(WorkOrder::class, 'work_order_id', 'id');
    }

    public function company()
    {
        return $this->belongsTo(CustomerCompany::class, 'company_id', 'id');
    }
}
