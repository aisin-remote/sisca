<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckSheetItemHeadcrane extends Model
{
    protected $table = 'tt_check_sheet_item_headcrane';
    protected $guarded = [];
    use HasFactory;
    public function checkSheet()
    {
        return $this->belongsTo(CheckSheetHeadCrane::class, 'check_sheet_id');
    }
    public function itemCheck()
    {
        return $this->belongsTo(ItemCheckHeadCrane::class, 'item_check_id');
    }
}
