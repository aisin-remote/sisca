<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckSheetNitrogenServer extends Model
{
    use HasFactory;

    protected $table = 'tt_check_sheet_nitrogen_servers';

    protected $fillable = [
        'tanggal_pengecekan',
        'npk',
        'tabung_number',
        'operasional',
        'catatan_operasional',
        'photo_operasional',
        'selector_mode',
        'catatan_selector_mode',
        'photo_selector_mode',
        'pintu_tabung',
        'catatan_pintu_tabung',
        'photo_pintu_tabung',
        'pressure_pilot',
        'catatan_pressure_pilot',
        'photo_pressure_pilot',
        'pressure_no1',
        'catatan_pressure_no1',
        'photo_pressure_no1',
        'pressure_no2',
        'catatan_pressure_no2',
        'photo_pressure_no2',
        'pressure_no3',
        'catatan_pressure_no3',
        'photo_pressure_no3',
        'pressure_no4',
        'catatan_pressure_no4',
        'photo_pressure_no4',
        'pressure_no5',
        'catatan_pressure_no5',
        'photo_pressure_no5',
    ];

    public function nitrogens()
    {
        return $this->belongsTo(Nitrogen::class, 'tabung_number', 'no_tabung');
    }

    public $timestamps = true;
}
