<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhAssignedField extends Model
{
    use HasFactory;
    protected $fillable=['wh_id','field_id','status'];

    public function wh()
    {
        return $this->belongsTo(WareHouse::class, 'wh_id', 'id');
    }
    public function customFields()
    {
        return $this->belongsTo(CustomFields::class, 'field_id', 'id');
    }

    public function getStatusAttribute($value)
    {
        if($value==1){
            $getVal='Active';
        }
        if($value==2){
            $getVal='In-Active';
        }
        return $getVal;
    }
}
