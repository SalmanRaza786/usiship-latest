<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderOffLoading extends Model
{
    use HasFactory;
    protected $fillable=['order_id','order_check_in_id','start_time','end_time','open_time','p_staged_location','status_id'];

    public function filemedia()
    {
        return $this->morphMany(FileContent::class, 'fileable');
    }
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }
    public function checkin()
    {
        return $this->belongsTo(OrderCheckIn::class, 'order_check_in_id', 'id');
    }



}
