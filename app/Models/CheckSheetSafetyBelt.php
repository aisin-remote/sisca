<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckSheetSafetyBelt extends Model
{
    use HasFactory;
    protected $table = 'tt_check_sheet_safety_belts';
    protected $guarded = [];

    public function safetybelts()
    {
        return $this->belongsTo(Safetybelt::class, 'safetybelt_number', 'no_safetybelt');
    }

    public $timestamps = true;
}
