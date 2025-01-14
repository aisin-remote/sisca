<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckSheetHeadCrane extends Model
{
    use HasFactory;
    protected $table = 'tm_check_sheet_head_crane';
    protected $guarded = ['id'];
    public function headcrane()
    {
        return $this->belongsTo(HeadCrane::class, 'headcrane_id');
    }
    public function checkSheetItems()
    {
        return $this->hasMany(CheckSheetItemHeadcrane::class, 'check_sheet_id');
    }
    public $timestamps = true;
}
