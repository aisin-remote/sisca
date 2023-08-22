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
        'selector_mode',
        'pintu_tabung',
        'pressure_pilot',
        'pressure_no1',
        'pressure_no2',
        'pressure_no3',
        'pressure_no4',
        'pressure_no5',
    ];
    
    public $timestamps = true;
}
