<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderCheckIn extends Model
{
    use HasFactory;
    protected $fillable=['order_id','order_contact_id','container_no','seal_no','delivery_order_signature','other_document','status_id'];







}
