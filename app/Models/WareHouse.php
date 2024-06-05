<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WareHouse extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable=[
        'title',
        'email',
        'phone',
        'address',
        'note',
        'status',
        ];

    public function whWorkingHours()
    {
        return $this->hasMany(WhWorkingHour::class,  'wh_id','id');
    }

    public function offDays()
    {
        return $this->hasMany(WhOffDay::class,  'wh_id','id');
    }

    public function loadTypes()
    {
        return $this->hasMany(LoadType::class,  'wh_id','id');
    }

    public function docks()
    {
        return $this->hasMany(WhDock::class,  'wh_id','id');
    }

    public function assignedFields()
    {
        return $this->hasMany(WhAssignedField::class,  'wh_id','id');
    }

    protected static function boot()
    {
        parent::boot();
        static::deleting(function ($wareHouse) {
            $wareHouse->whWorkingHours()->delete();
            $wareHouse->loadTypes()->delete();
            $wareHouse->docks()->delete();
            $wareHouse->assignedFields()->delete();
        });
    }





}
