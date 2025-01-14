<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeadCrane extends Model
{
    use HasFactory;
    protected $table = 'tm_headcranes';

    protected $guarded = [];
    public function locations()
    {
        return $this->belongsTo(Location::class, 'location_id', 'id');
    }
    public function checkSheets()
    {
        return $this->hasMany(CheckSheetHeadCrane::class, 'headcrane_id');
    }
}
