<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LoadType extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable=['direction_id',
        'operation_id',
        'equipment_type_id',
        'trans_mode_id',
        'status',
        'wh_id',
        'duration'
        ];



    public static function getLoadTypeMaterial()
    {
        $data['direction']=LTDirection::get();
        $data['operations']=LTOperation::get();
        $data['equipmentType']=LTEquipmentType::get();
        $data['transportationMode']=LTTransportaionMode::get();
        return $data;
    }

    public function direction()
    {
        return $this->belongsTo(LTDirection::class, 'direction_id', 'id');
    }
    public function operation()
    {
        return $this->belongsTo(LTOperation::class, 'operation_id', 'id');
    }
    public function eqType()
    {
        return $this->belongsTo(LTEquipmentType::class, 'equipment_type_id', 'id');
    }
    public function transMode()
    {
        return $this->belongsTo(LTTransportaionMode::class, 'trans_mode_id', 'id');
    }
    public function wareHouse()
    {
        return $this->belongsTo(WareHouse::class, 'wh_id', 'id');
    }
    public function docks()
    {
        return $this->hasMany(WhDock::class,  'load_type_id','id');
    }


}
