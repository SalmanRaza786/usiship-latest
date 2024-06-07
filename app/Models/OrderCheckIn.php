<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderCheckIn extends Model
{
    use HasFactory;
    protected $fillable=['order_id','order_contact_id','container_no','seal_no','delivery_order_signature','other_document','status_id','door_id'];

    public function orderContact()
    {
        return $this->belongsTo(OrderContacts::class, 'order_id', 'id');
    }
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }
    public function door()
    {
        return $this->belongsTo(WhDoor::class, 'door_id', 'id');
    }

    public function status()
    {
        return $this->belongsTo(OrderStatus::class, 'status_id', 'id');
    }



}
