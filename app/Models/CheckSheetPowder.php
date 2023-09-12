<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckSheetPowder extends Model
{
    use HasFactory;

    protected $table = 'tt_check_sheet_powders';

    protected $fillable = [
        'tanggal_pengecekan',
        'npk',
        'apar_number',
        'pressure',
        'catatan_pressure',
        'photo_pressure',
        'hose',
        'catatan_hose',
        'photo_hose',
        'tabung',
        'catatan_tabung',
        'photo_tabung',
        'regulator',
        'catatan_regulator',
        'photo_regulator',
        'lock_pin',
        'catatan_lock_pin',
        'photo_lock_pin',
        'powder',
        'catatan_powder',
        'photo_powder',
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
