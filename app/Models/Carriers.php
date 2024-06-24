<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carriers extends Model
{
    use HasFactory;
    protected $fillable=['company_id','carrier_company_name','email','contacts','id_card_image','other_docs'];

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }
    public function docimages()
    {
        return $this->morphMany(FileContent::class, 'fileable');
    }
}
