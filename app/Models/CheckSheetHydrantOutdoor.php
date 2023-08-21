<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckSheetHydrantOutdoor extends Model
{
    use HasFactory;

    protected $table = 'tt_check_sheet_hydrant_outdoor';

    protected $fillable = [
        'tanggal_pengecekan',
        'npk',
        'hydrant_number',
        'pintu',
        'nozzle',
        'selang',
        'tuas',
        'pilar',
        'penutup',
        'rantai',
        'kupla',
    ];
    
    public $timestamps = true;
}
