<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MissedItem extends Model
{
    use HasFactory;
    protected $fillable=['picker_table_id','work_order_id','status_code','start_time','end_time','auth_id'];
}
