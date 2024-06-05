<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhDock extends Model
{
    use HasFactory;

    protected $fillable=['wh_id','load_type_id','title','slot','cancel_before','schedule_limit','status'];

    public function loadType()
    {
        return $this->belongsTo(LoadType::class,  'load_type_id','id');
    }

    public function getStatusAttribute($value)
    {
        if($value==1){
            $getVal='Active';
        }
        if($value==2){
            $getVal='InActive';
        }
        return $getVal;
    }


    public function dockLoadTypes()
    {
        return $this->hasMany(DocksLoadType::class,  'dock_id','id');
    }

    protected static function boot()
    {
        parent::boot();
        static::deleting(function ($wareHouse) {
            $wareHouse->dockLoadTypes()->delete();
        });
    }


}
