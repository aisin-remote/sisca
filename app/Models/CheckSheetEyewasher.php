<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckSheetEyewasher extends Model
{
    use HasFactory;

    protected $table = 'tt_check_sheet_eye_washers';

    protected $fillable = [
        'tanggal_pengecekan',
        'npk',
        'eyewasher_number',
        'pijakan',
        'catatan_pijakan',
        'photo_pijakan',
        'pipa_saluran_air',
        'catatan_pipa_saluran_air',
        'photo_pipa_saluran_air',
        'wastafel',
        'catatan_wastafel',
        'photo_wastafel',
        'kran_air',
        'catatan_kran_air',
        'photo_kran_air',
        'tuas',
        'catatan_tuas',
        'photo_tuas',
    ];

    public function eyewashers()
    {
        return $this->belongsTo(Eyewasher::class, 'eyewasher_number', 'no_eyewasher');
    }

    public $timestamps = true;
}
