<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomFields extends Model
{
    use HasFactory;
    protected $fillable=['label','input_type','place_holder','description','require_type',];

    public function orderForm()
    {
        return $this->hasMany(OrderForm::class, 'field_id');
    }

    public function getRequireTypeAttribute($value)
    {
        if($value==1){
            $getVal='Yes';
        }
        if($value==2){
            $getVal='No';
        }
        return $getVal;
    }


}
