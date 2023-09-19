<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckSheetTabungCo2 extends Model
{
    use HasFactory;

    protected $table = 'tt_check_sheet_tabung_co2s';


    protected $fillable = [
        'tanggal_pengecekan',
        'npk',
        'tabung_number',
        'cover',
        'catatan_cover',
        'photo_cover',
        'tabung',
        'catatan_tabung',
        'photo_tabung',
        'lock_pin',
        'catatan_lock_pin',
        'photo_lock_pin',
        'segel_lock_pin',
        'catatan_segel_lock_pin',
        'photo_segel_lock_pin',
        'kebocoran_regulator_tabung',
        'catatan_kebocoran_regulator_tabung',
        'photo_kebocoran_regulator_tabung',
        'selang',
        'catatan_selang',
        'photo_selang',
    ];

    public function co2s()
    {
        return $this->belongsTo(Co2::class, 'tabung_number', 'no_tabung');
    }

    public $timestamps = true;
}
