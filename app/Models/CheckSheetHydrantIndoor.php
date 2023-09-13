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
        'catatan_pintu',
        'photo_pintu',
        'lampu',
        'catatan_lampu',
        'photo_lampu',
        'emergency',
        'catatan_emergency',
        'photo_emergency',
        'nozzle',
        'catatan_nozzle',
        'photo_nozzle',
        'selang',
        'catatan_selang',
        'photo_selang',
        'valve',
        'catatan_valve',
        'photo_valve',
        'coupling',
        'catatan_coupling',
        'photo_coupling',
        'pressure',
        'catatan_pressure',
        'photo_pressure',
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
