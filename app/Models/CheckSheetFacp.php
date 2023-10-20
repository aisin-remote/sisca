<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckSheetFacp extends Model
{
    use HasFactory;
    protected $table = 'tt_check_sheet_facps';
    protected $guarded = [];

    public function facps()
    {
        return $this->belongsTo(Facp::class, 'zona_number', 'zona');
    }
}
