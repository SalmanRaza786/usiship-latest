<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItemPutAway extends Model
{
    use HasFactory;
    protected $fillable=['order_id','order_off_loading_id','inventory_id','qty','pallet_number','location_id','status_id'];

    public function whLocation()
    {
        return $this->belongsTo(WhLocation::class, 'location_id', 'id');
    }

    public function inventory()
    {
        return $this->belongsTo(Inventory::class, 'inventory_id', 'id');
    }
    public function location()
    {
        return $this->belongsTo(WhLocation::class, 'location_id', 'id');
    }

    public function putAwayMedia()
    {
        return $this->morphMany(FileContent::class, 'fileable');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    protected static function boot()
    {
        parent::boot();
        static::deleting(function ($invoice) {
            $invoice->putAwayMedia()->delete();

        });
    }



}
