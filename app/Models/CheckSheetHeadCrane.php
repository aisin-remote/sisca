<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckSheetHeadCrane extends Model
{
    use HasFactory;
    protected $table = 'tt_check_sheet_head_cranes';
    protected $guarded = [];
    public function headcranes()
    {
        return $this->belongsTo(HeadCrane::class, 'safetybelt_number', 'no_safetybelt');
    }

    public $timestamps = true;
}
