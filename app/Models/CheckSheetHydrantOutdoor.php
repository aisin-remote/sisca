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
        'catatan_pintu',
        'photo_pintu',
        'nozzle',
        'catatan_nozzle',
        'photo_nozzle',
        'selang',
        'catatan_selang',
        'photo_selang',
        'tuas',
        'catatan_tuas',
        'photo_tuas',
        'pilar',
        'catatan_pilar',
        'photo_pilar',
        'penutup',
        'catatan_penutup',
        'photo_penutup',
        'rantai',
        'catatan_rantai',
        'photo_rantai',
        'kupla',
        'catatan_kupla',
        'photo_kupla',
    ];

    public function hydrants()
    {
        return $this->belongsTo(Hydrant::class, 'hydrant_number', 'no_hydrant');
    }

    public $timestamps = true;
}
