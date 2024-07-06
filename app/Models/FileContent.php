<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileContent extends Model
{
    use HasFactory;
    protected $fillable=['file_name','file_type','fileable_id','fileable_type','form_id','field_name','file_thumbnail'];
    public function fileable()
    {
        return $this->morphTo();
    }

    public function formData()
    {
        return $this->belongsTo(OrderForm::class, 'form_id','id');
    }
    protected $casts = [
        'created_at' => 'datetime:d M, Y H:i:s ',
    ];
}
