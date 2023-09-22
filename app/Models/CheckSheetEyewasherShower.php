<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckSheetEyewasherShower extends Model
{
    use HasFactory;

    protected $table = 'tt_check_sheet_eye_washer_showers';

    protected $fillable = [
        'tanggal_pengecekan',
        'npk',
        'eyewasher_number',
        'instalation_base',
        'catatan_instalation_base',
        'photo_instalation_base',
        'pipa_saluran_air',
        'catatan_pipa_saluran_air',
        'photo_pipa_saluran_air',
        'wastafel_eye_wash',
        'catatan_wastafel_eye_wash',
        'photo_wastafel_eye_wash',
        'tuas_eye_wash',
        'catatan_tuas_eye_wash',
        'photo_tuas_eye_wash',
        'kran_eye_wash',
        'catatan_kran_eye_wash',
        'photo_kran_eye_wash',
        'tuas_shower',
        'catatan_tuas_shower',
        'photo_tuas_shower',
        'sign',
        'catatan_sign',
        'photo_sign',
        'shower_head',
        'catatan_shower_head',
        'photo_shower_head',
    ];

    public function eyewashers()
    {
        return $this->belongsTo(Eyewasher::class, 'eyewasher_number', 'no_eyewasher');
    }

    public $timestamps = true;
}
