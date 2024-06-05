<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderBookedSlot extends Model
{
    use HasFactory;
    protected $fillable=['order_id','operational_hour_id'];


    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    public function operationalHour()
    {
        return $this->belongsTo(OperationalHour::class, 'operational_hour_id', 'id');
    }
}
