<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MissedItemDetail extends Model
{
    use HasFactory;
    protected $fillable=['missed_items_parent_id','picked_item_table_id','inventory_id','missed_qty'];
}
