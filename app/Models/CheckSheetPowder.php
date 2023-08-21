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
        'hose',
        'tabung',
        'regulator',
        'lock_pin',
        'powder',
    ];

    // Jika tidak ingin menggunakan timestamps (created_at dan updated_at)
    // public $timestamps = false;

    // Atau jika ingin menggunakan timestamps
    public $timestamps = true;
    
    // ... tambahkan relasi, method, atau atribut lainnya di sini
}
