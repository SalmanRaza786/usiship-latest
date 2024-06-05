<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderForm extends Model
{
    use HasFactory;
    protected $fillable=['order_id','field_id','form_value','is_file'];

    public function customFields()
    {
        return $this->belongsTo(CustomFields::class, 'field_id', 'id');
    }

    public function files()
    {
        return $this->hasOne(FileContent::class, 'form_id','id');
    }









}
