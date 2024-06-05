<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhWorkingHour extends Model
{
    use HasFactory;
    protected $fillable=['wh_id','from_wh_id','to_wh_id','is_open','day_name','open_type'];

    public function oprationHoursFrom()
    {
        return $this->hasMany(OperationalHour::class,  'id','from_wh_id');
    }
    public function oprationHoursTo()
    {
        return $this->hasMany(OperationalHour::class,  'id','to_wh_id');
    }
    public function operationalHours()
    {
        return $this->hasMany(OperationalHour::class);
    }
}
