<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckSheetCo2 extends Model
{
    use HasFactory;

    protected $table = 'tt_check_sheet_co2s';

    protected $fillable = [
        'tanggal_pengecekan',
        'npk',
        'apar_number',
        'pressure',
        'photo_pressure',
        'hose',
        'photo_hose',
        'corong',
        'photo_corong',
        'tabung',
        'photo_tabung',
        'regulator',
        'photo_regulator',
        'lock_pin',
        'photo_lock_pin',
        'berat_tabung',
        'photo_berat_tabung',
        'description',
    ];

    public function apars()
    {
        return $this->belongsTo(Apar::class, 'apar_number', 'tag_number');
    }

    // Jika tidak ingin menggunakan timestamps (created_at dan updated_at)
    // public $timestamps = false;

    // Atau jika ingin menggunakan timestamps
    public $timestamps = true;

    // ... tambahkan relasi, method, atau atribut lainnya di sini
}
