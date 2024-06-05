<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderLog extends Model
{
    use HasFactory;

    protected $fillable=['order_id','status_id','created_by','guard'];

    public function orderStatus()
    {
        return $this->belongsTo(OrderStatus::class, 'status_id', 'id');
    }


    public function admin()
    {
        return $this->belongsTo(Admin::class, 'created_by', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function createdBy()
    {

        if ($this->guard == 'admin') {
            return $this->admin;
        } elseif ($this->guard == 'web') {
            return $this->user;
        }

    }

    public function getCreatedByNameAttribute()
    {
        return  $createdBy = $this->createdBy();
        return $createdBy->name;
        return $createdBy ? $createdBy->name : 'Unknown';

    }
}
