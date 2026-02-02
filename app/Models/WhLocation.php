<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhLocation extends Model
{
    use HasFactory;
    protected $fillable=['loc_title','status','wms_location_id','wms_warehouse_id','type','wms_updated_date','wh_id'];
}
