<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckSheetHeadCrane extends Model
{
    use HasFactory;
    protected $table = 'tt_check_sheet_head_crane';
    protected $guarded = ['id'];
    public function headcranes()
    {
        return $this->belongsTo(HeadCrane::class, 'headcrane_number', 'no_headcrane');
    }
    
    public $timestamps = true;
}
