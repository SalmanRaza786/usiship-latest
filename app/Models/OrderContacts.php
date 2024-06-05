<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderContacts extends Model
{
    use HasFactory;
    protected $fillable=['order_id','carrier_id','arrival_time','is_verify','vehicle_number','vehicle_licence_plate','bol_number','do_number','do_document'];

    public function carrier()
    {
        return $this->belongsTo(Carriers::class, 'carrier_id', 'id');
    }
    public function order()
    {
        return $this->belongsTo(OrderContacts::class, 'order_id', 'id');
    }

    public function getIsVerifyAttribute($value)
    {
        if($value==1){
            $getVal='Verified';
        }
        if($value==0){
            $getVal='Not Verified';
        }
        return $getVal;
    }


}
