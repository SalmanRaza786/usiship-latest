<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerCompany extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable=['wms_customer_id','title','email','contact','address'];
}
