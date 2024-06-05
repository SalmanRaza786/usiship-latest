<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocksLoadType extends Model
{
    use HasFactory;
    protected $fillable=['dock_id','load_type_id'];


    public function loadType()
    {
        return $this->belongsTo(LoadType::class,  'load_type_id','id');
    }

    public function dock()
    {
        return $this->belongsTo(WhDock::class,  'dock_id','id');
    }
}
