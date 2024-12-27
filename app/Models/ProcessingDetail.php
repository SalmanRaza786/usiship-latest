<?php

namespace App\Models;

use Illuminate\Console\View\Components\Task;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProcessingDetail extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['processing_id','work_order_id','task_id','qty','comment','status_code','auth_id'];
    public function task()
    {
        return $this->belongsTo(ProcessingTask::class, 'task_id', 'id');
    }
    public function media()
    {
        return $this->morphMany(FileContent::class, 'fileable');
    }
    public function status()
    {
        return $this->belongsTo(OrderStatus::class, 'status_code', 'order_by');
    }

}
