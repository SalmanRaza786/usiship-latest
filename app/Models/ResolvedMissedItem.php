<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResolvedMissedItem extends Model
{
    use HasFactory;
    protected $fillable=['missed_detail_parent_id','new_loc_id','resolve_qty','missed_table_id'];

    public function media()
    {
        return $this->morphMany(FileContent::class, 'fileable');
    }
}
