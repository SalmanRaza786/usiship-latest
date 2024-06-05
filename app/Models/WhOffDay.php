<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhOffDay extends Model
{
    use HasFactory;
    protected $fillable=['wh_id','close_date'];
}
