<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckSheetHydrantIndoor extends Model
{
    use HasFactory;

    protected $table = 'tt_check_sheet_hydrant_indoor';

    protected $fillable = [
        'tanggal_pengecekan',
        'npk',
        'hydrant_number',
        'pintu',
        'emergency',
        'nozzle',
        'selang',
        'valve',
        'coupling',
        'pressure',
        'kupla',
    ];

    public $timestamps = true;

}
