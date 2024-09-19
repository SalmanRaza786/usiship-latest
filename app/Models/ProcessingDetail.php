<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProcessingDetail extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['processing_id','work_order_id','task_id','qty','comment','status_code','auth_id'];
    public function media()
    {
        return $this->morphMany(FileContent::class, 'fileable');
    }
}
