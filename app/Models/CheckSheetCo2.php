<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckSheetCo2 extends Model
{
    use HasFactory;

    protected $fillable = [
        'tanggal_pengecekan',
        'npk',
        'apar_number',
        'pressure',
        'hose',
        'corong',
        'tabung',
        'regulator',
        'lock_pin',
        'berat_tabung',
    ];

    // Jika tidak ingin menggunakan timestamps (created_at dan updated_at)
    // public $timestamps = false;

    // Atau jika ingin menggunakan timestamps
    public $timestamps = true;
    
    // ... tambahkan relasi, method, atau atribut lainnya di sini
}
