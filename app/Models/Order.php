<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
class Order extends Model
{
    use HasFactory;
    protected $fillable=['company_id','customer_id','wh_id','dock_id','operational_hour_id','order_type','status_id','order_date','created_by','guard','load_type_id','work_order_id'];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($order) {
            // Generate the Order number here
            $order->order_id = static::generateOrderId();
        });
    }

    public static function generateOrderId()
    {

        $latestOrder = DB::table('orders')->latest('id')->first();
        if ($latestOrder) {
            $latestOrderId = $latestOrder->order_id;
            $lastNumber = (int) substr($latestOrderId, 4); // Assuming format 'ORD#0001'
            $newOrderNumber = $lastNumber + 1;
        } else {
            $newOrderNumber = 1;
        }

        return 'ORD#' . str_pad($newOrderNumber, 4, '0', STR_PAD_LEFT);

    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id', 'id');
    }
    public function warehouse()
    {
        return $this->belongsTo(WareHouse::class, 'wh_id', 'id');
    }

    public function operationalHour()
    {
        return $this->belongsTo(OperationalHour::class, 'operational_hour_id', 'id');
    }
    public function dock()
    {
        return $this->belongsTo(DocksLoadType::class, 'dock_id', 'dock_id');
    }

    public function fileContents()
    {
        return $this->morphMany(FileContent::class, 'fileable');
    }

    public function orderForm()
    {
        return $this->hasMany(OrderForm::class, 'order_id', 'id');
    }
    public function orderLogs()
    {
        return $this->hasMany(OrderLog::class, 'order_id', 'id');
    }

    public function status()
    {
        return $this->belongsTo(OrderStatus::class, 'status_id', 'id');
    }

    public function bookedSlots()
    {
        return $this->hasMany(OrderBookedSlot::class, 'order_id', 'id');
    }

    public function packgingList()
    {
        return $this->hasMany(PackgingList::class, 'order_id', 'id');
    }
    public function orderContacts()
    {
        return $this->hasMany(OrderContacts::class, 'order_id', 'id');
    }

    public function loadType()
    {
        return $this->belongsTo(LoadType::class, 'load_type_id', 'id');
    }

    public function itemPutAway()
    {
        return $this->hasMany(OrderItemPutAway::class, 'order_id', 'id');
    }


}
