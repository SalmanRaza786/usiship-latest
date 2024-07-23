<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackgingList extends Model
{
    use HasFactory;
    protected $fillable=[
        'order_id',
        'inventory_id',
        'qty',
        'recv_qty',
        'remarks',
        'qty_received_cartons',
        'qty_received_each',
        'exception_qty',
        'damage',
        'ti',
        'hi',
        'total_pallets',
        'lot_3',
        'serial_number',
        'upc_label',
        'upc_label_photo',
        'expiry_date',
        'length',
        'width',
        'height',
        'weight',
        'custom_field_1',
        'custom_field_2',
        'custom_field_3',
        'custom_field_4',];

    public function inventory()
    {
        return $this->belongsTo(Inventory::class, 'inventory_id', 'id');
    }
    public function filemedia()
    {
        return $this->morphMany(FileContent::class, 'fileable');
    }



}
