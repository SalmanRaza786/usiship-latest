<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhLocation extends Model
{
    use HasFactory;
    protected $fillable=['loc_title','load_type_id','title','slot','cancel_before','schedule_limit','status'];
}
