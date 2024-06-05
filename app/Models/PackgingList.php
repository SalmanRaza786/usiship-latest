<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackgingList extends Model
{
    use HasFactory;
    protected $fillable=['order_id','inventory_id','qty','recv_qty','remarks','hi','ti'];

    public function inventory()
    {
        return $this->belongsTo(Inventory::class, 'inventory_id', 'id');
    }
}
