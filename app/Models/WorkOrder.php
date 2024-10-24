<?php

namespace App\Models;

use http\Client;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkOrder extends Model
{
    use HasFactory;

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id', 'id');
    }

    public function status()
    {
        return $this->belongsTo(OrderStatus::class, 'status_code', 'order_by');
    }

    public function carrier()
    {
        return $this->belongsTo(Carriers::class, 'carrier_id', 'id');
    }

    public function loadType()
    {
        return $this->belongsTo(LoadType::class, 'load_type_id', 'id');
    }
}
