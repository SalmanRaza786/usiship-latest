<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhOperationHour extends Model
{
    use HasFactory;
    protected $fillable=['wh_id','day_name','wh_from','wh_to'];

}
