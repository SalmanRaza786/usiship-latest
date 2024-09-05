<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkOrderItem extends Model
{
    use HasFactory;
    protected $fillable = [
        'work_order_id',
        'inventory_id',
        'loc_id',
        'qty',
        'pallet_number',
        'auth_id',
    ];

    public function inventory()
    {
        return $this->belongsTo(Inventory::class, 'inventory_id', 'id');
    }

    public function location()
    {
        return $this->belongsTo(WhLocation::class, 'loc_id', 'id');
    }
}
